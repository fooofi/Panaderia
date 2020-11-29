<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ValidateEmailFairUserResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::boolean('status')->example(true),
            Schema::string('message')->example('Fair User email is validated successfully')
        );

        return Response::create('ValidateEmailFairUser')
            ->description('Successful validate email or resend email for Fair User')
            ->content(MediaType::json()->schema($response));
    }
}
