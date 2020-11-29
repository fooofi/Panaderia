<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;

/**
 * @OpenApi\PathItem()
 */
class ChatController extends Controller
{
    /**
     * Generate Chat Access Token
     *
     * Generates a new Chat Access Token for the Fair User to use with the Twilio Chat API
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\Response(factory="TwilioTokenResponse", statusCode=200)
     */
    public function getToken()
    {
        $user = auth('api')->user();
        $token = new AccessToken(
            config('services.twilio.sid'),
            config('services.twilio.key'),
            config('services.twilio.secret'),
            3600,
            $user->email
        );

        $chat_grant = new ChatGrant();
        $chat_grant->setServiceSid(config('services.twilio.grant'));

        $token->addGrant($chat_grant);
        return response()->json([
            'token' => $token->toJWT(),
        ]);
    }
}
