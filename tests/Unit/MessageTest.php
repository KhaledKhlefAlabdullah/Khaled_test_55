<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
// tests/Feature/MessageControllerTest.php

    public function test_send_message()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson(
            route('messages.send'),
            [
                'message' => 'Hello, world!',
                'received_id' => $otherUser->id,
            ]
        );

        $response->assertStatus(200);
        $response->assertJson([
            'message' => __('send-message-successfully'),
        ]);

        $this->assertDatabaseHas('messages', [
            'message' => 'Hello, world!',
            'sender_id' => $user->id,
            'receiver_id' => $otherUser->id,
        ]);
    }
}
