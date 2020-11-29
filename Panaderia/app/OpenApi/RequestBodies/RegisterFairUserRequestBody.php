<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class RegisterFairUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        $request = Schema::object()->properties(
            Schema::integer('client_id')->format(Schema::FORMAT_INT64),
            Schema::string('client_secret'),
            Schema::object('fairuser')->properties(
                Schema::string('name'),
                Schema::string('lastname'),
                Schema::string('rut'),
                Schema::string('phone'),
                Schema::string('email'),
                Schema::string('birthday')->format(Schema::FORMAT_DATE),
                Schema::integer('commune_id')->format(Schema::FORMAT_INT64),
                Schema::string('password')->format(Schema::FORMAT_PASSWORD),
                Schema::string('password_confirmation')->format(
                    Schema::FORMAT_PASSWORD
                )
            )
        );
        return RequestBody::create('FairUserRegister')
            ->description('Fair User data')
            ->content(MediaType::json()->schema($request));
    }
}
