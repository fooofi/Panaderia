<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ResendValidateEmailFairUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        $request = Schema::object()->properties(
            Schema::string('email')->example("test@example.com"),
        );
        return RequestBody::create('ResendFairUserValidateEmail')
            ->description('Fair User resend email for validate token')
            ->content(MediaType::json()->schema($request));
    }
}
