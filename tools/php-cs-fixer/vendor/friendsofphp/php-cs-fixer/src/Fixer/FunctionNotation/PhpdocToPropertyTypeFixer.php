<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PhpCsFixer\Fixer\FunctionNotation;

use PhpCsFixer\AbstractPhpdocToTypeDeclarationFixer;
use PhpCsFixer\DocBlock\Annotation;
use PhpCsFixer\Fixer\ExperimentalFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

/**
 * @phpstan-import-type _CommonTypeInfo from AbstractPhpdocToTypeDeclarationFixer
 */
final class PhpdocToPropertyTypeFixer extends AbstractPhpdocToTypeDeclarationFixer implements ExperimentalFixerInterface
{
    private const TYPE_CHECK_TEMPLATE = '<?php class A { private %s $b; }';

    /**
     * @var array<string, true>
     */
    private array $skippedTypes = [
        'resource' => true,
        'null' => true,
    ];

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Takes `@var` annotation of non-mixed types and adjusts accordingly the property signature. Requires PHP >= 7.4.',
            [
                new CodeSample(
                    '<?php
class Foo {
    /** @var int */
    private $foo;
    /** @var \Traversable */
    private $bar;
}
',
                ),
                new CodeSample(
                    '<?php
class Foo {
    /** @var int */
    private $foo;
    /** @var \Traversable */
    private $bar;
}
',
                    ['scalar_types' => false]
                ),
                new CodeSample(
                    '<?php
class Foo {
    /** @var int|string */
    private $foo;
    /** @var \Traversable */
    private $bar;
}
',
                    ['union_types' => false]
                ),
            ],
            null,
            'The `@var` annotation is mandatory for the fixer to make changes, signatures of properties without it (no docblock) will not be fixed. Manual actions might be required for newly typed properties that are read before initialization.'
        );
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(T_DOC_COMMENT);
    }

    /**
     * {@inheritdoc}
     *
     * Must run before NoSuperfluousPhpdocTagsFixer, PhpdocAlignFixer.
     * Must run after AlignMultilineCommentFixer, CommentToPhpdocFixer, PhpdocIndentFixer, PhpdocScalarFixer, PhpdocToCommentFixer, PhpdocTypesFixer.
     */
    public function getPriority(): int
    {
        return 7;
    }

    protected function isSkippedType(string $type): bool
    {
        return isset($this->skippedTypes[$type]);
    }

    protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = $tokens->count() - 1; 0 < $index; --$index) {
            if ($tokens[$index]->isGivenKind([T_CLASS, T_TRAIT])) {
                $this->fixClass($tokens, $index);
            }
        }
    }

    protected function createTokensFromRawType(string $type): Tokens
    {
        $typeTokens = Tokens::fromCode(sprintf(self::TYPE_CHECK_TEMPLATE, $type));
        $typeTokens->clearRange(0, 8);
        $typeTokens->clearRange(\count($typeTokens) - 5, \count($typeTokens) - 1);
        $typeTokens->clearEmptyTokens();

        return $typeTokens;
    }

    private function fixClass(Tokens $tokens, int $index): void
    {
        $index = $tokens->getNextTokenOfKind($index, ['{']);
        $classEndIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $index);

        for (; $index < $classEndIndex; ++$index) {
            if ($tokens[$index]->isGivenKind(T_FUNCTION)) {
                $index = $tokens->getNextTokenOfKind($index, ['{', ';']);

                if ($tokens[$index]->equals('{')) {
                    $index = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_CURLY_BRACE, $index);
                }

                continue;
            }

            if (!$tokens[$index]->isGivenKind(T_DOC_COMMENT)) {
                continue;
            }

            $docCommentIndex = $index;
            $propertyIndices = $this->findNextUntypedPropertiesDeclaration($tokens, $docCommentIndex);

            if ([] === $propertyIndices) {
                continue;
            }

            $typeInfo = $this->resolveApplicableType(
                $propertyIndices,
                $this->getAnnotationsFromDocComment('var', $tokens, $docCommentIndex)
            );

            if (null === $typeInfo) {
                continue;
            }

            $propertyType = $typeInfo['commonType'];
            $isNullable = $typeInfo['isNullable'];

            if (\in_array($propertyType, ['callable', 'never', 'void'], true)) {
                continue;
            }

            if (!$this->isValidSyntax(sprintf(self::TYPE_CHECK_TEMPLATE, $propertyType))) {
                continue;
            }

            $newTokens = array_merge(
                $this->createTypeDeclarationTokens($propertyType, $isNullable),
                [new Token([T_WHITESPACE, ' '])]
            );

            $tokens->insertAt(current($propertyIndices), $newTokens);

            $index = max($propertyIndices) + \count($newTokens) + 1;
            $classEndIndex += \count($newTokens);
        }
    }

    /**
     * @return array<string, int>
     */
    private function findNextUntypedPropertiesDeclaration(Tokens $tokens, int $index): array
    {
        do {
            $index = $tokens->getNextMeaningfulToken($index);
        } while ($tokens[$index]->isGivenKind([
            T_PRIVATE,
            T_PROTECTED,
            T_PUBLIC,
            T_STATIC,
            T_VAR,
        ]));

        if (!$tokens[$index]->isGivenKind(T_VARIABLE)) {
            return [];
        }

        $properties = [];

        while (!$tokens[$index]->equals(';')) {
            if ($tokens[$index]->isGivenKind(T_VARIABLE)) {
                $properties[$tokens[$index]->getContent()] = $index;
            }

            $index = $tokens->getNextMeaningfulToken($index);
        }

        return $properties;
    }

    /**
     * @param array<string, int> $propertyIndices
     * @param Annotation[] $annotations
     *
     * @return ?_CommonTypeInfo
     */
    private function resolveApplicableType(array $propertyIndices, array $annotations): ?array
    {
        $propertyTypes = [];

        foreach ($annotations as $annotation) {
            $propertyName = $annotation->getVariableName();

            if (null === $propertyName) {
                if (1 !== \count($propertyIndices)) {
                    continue;
                }

                $propertyName = array_key_first($propertyIndices);
            }

            if (!isset($propertyIndices[$propertyName])) {
                continue;
            }

            $typesExpression = $annotation->getTypeExpression();

            if (null === $typesExpression) {
                continue;
            }

            $typeInfo = $this->getCommonTypeInfo($typesExpression, false);
            $unionTypes = null;

            if (null === $typeInfo) {
                $unionTypes = $this->getUnionTypes($typesExpression, false);
            }

            if (null === $typeInfo && null === $unionTypes) {
                continue;
            }

            if (null !== $unionTypes) {
                $typeInfo = ['commonType' => $unionTypes, 'isNullable' => false];
            }

            if (\array_key_exists($propertyName, $propertyTypes) && $typeInfo !== $propertyTypes[$propertyName]) {
                return null;
            }

            $propertyTypes[$propertyName] = $typeInfo;
        }

        if (\count($propertyTypes) !== \count($propertyIndices)) {
            return null;
        }

        $type = array_shift($propertyTypes);

        foreach ($propertyTypes as $propertyType) {
            if ($propertyType !== $type) {
                return null;
            }
        }

        return $type;
    }
}
