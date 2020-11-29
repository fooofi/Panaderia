<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ContactRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        $request = Schema::object()->properties(
            Schema::string('from')->description(
                'Name of the resource, should be one of this: [institution, campus, career]'
            ),
            Schema::integer('from_id')->description('ID of the resource contacted'),
            Schema::integer('type')->description('ID of Type of Contact')
        );
        return RequestBody::create('ContactRequestBody')
            ->description('Values needed to make a contact')
            ->content(MediaType::json()->schema($request));
    }
}
