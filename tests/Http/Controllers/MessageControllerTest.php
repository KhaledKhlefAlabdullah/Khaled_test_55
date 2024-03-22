<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Events\ChatEvent;

/**
 * The MessageControllerTest class contains tests for the MessageController class.
 *
 * This test suite focuses on the send_message method of the MessageController,
 * ensuring that messages are sent correctly and validation is handled properly.
 */
class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test sending a message successfully.
     *
     * @return void
     */
    public function testSendMessageSuccessfully()
    {
        Event::fake();

        $request = Request::create('/send_message', 'POST', [
            'received_id' => 'valid-uuid',
            'message' => 'Hello, World!',
        ]);

        $controller = new MessageController();

        $response = $controller->send_message($request);

        $responseContent = json_decode($response->getContent(), true);

        Event::assertDispatched(ChatEvent::class);
        $this->assertEquals(__('send-message-successfully'), $responseContent['message']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test sending a message with invalid data.
     *
     * @return void
     */
    public function testSendMessageWithInvalidData()
    {
        Event::fake();

        $request = Request::create('/send_message', 'POST', [
            'received_id' => 'invalid-uuid',
            'message' => '', // Empty message should fail validation
        ]);

        $controller = new MessageController();

        $response = $controller->send_message($request);

        $this->assertEquals(422, $response->getStatusCode());
    }
}
