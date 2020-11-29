<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ContactTypesResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::array('types')->items(Schema::object()->properties(Schema::integer('id'), Schema::string('name')))
        );
        return Response::ok()
            ->description('Successful response for listing Contact Types')
            ->content(MediaType::json()->schema($response));
    }
}
