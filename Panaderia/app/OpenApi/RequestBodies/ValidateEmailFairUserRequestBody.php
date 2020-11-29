<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ValidateEmailFairUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        $request = Schema::object()->properties(
            Schema::string('token'),
        );
        return RequestBody::create('FairUserValidateEmail')
            ->description('Fair User validate token')
            ->content(MediaType::json()->schema($request));
    }
}
