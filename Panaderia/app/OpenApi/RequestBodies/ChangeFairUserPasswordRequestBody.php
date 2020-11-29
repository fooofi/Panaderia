<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ChangeFairUserPasswordRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        $request = Schema::object()->properties(
            Schema::string('old_password')->minLength(8),
            Schema::string('new_password')->minLength(8),
            Schema::string('new_password_confirmed')->minLength(8)
        );
        return RequestBody::create('FairUserChangePassword')
            ->description('Fair User change password data')
            ->content(MediaType::json()->schema($request));
    }
}
