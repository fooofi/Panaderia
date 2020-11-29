<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\InstitutionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class List8InstitutionsResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::array('institutions')->items(
                Schema::object()->properties(
                    Schema::integer('id')->format(Schema::FORMAT_INT64),
                    Schema::integer('careers'),
                    Schema::integer('campuses'),
                    Schema::string('name'),
                    Schema::string('icon')
                )
            )
        );
        return Response::ok()
            ->description('Successful response for listing 8 random Institutions')
            ->content(MediaType::json()->schema($response));
    }
}
