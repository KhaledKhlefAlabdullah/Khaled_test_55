<?php

namespace App\Helpers;


use Symfony\Component\Translation\Exception\NotFoundResourceException;

if (!function_exists('getAndCheckModelById')) {
    /*
     * This function is used to get and check if a model exists by ID
     * @param string $model
     * @param string $id
     *
     * @throws NotFoundResourceException
     */
    function getAndCheckModelById($model, $id)
    {
        $instance = $model::find($id);

        if (!$instance) {
            throw new NotFoundResourceException($model . " not found", 404);
        }

        return $instance;
    }
}

