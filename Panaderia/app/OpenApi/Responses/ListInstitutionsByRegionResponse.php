<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ListInstitutionsByRegionResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::array('regions')->items(
                Schema::object()->properties(
                    Schema::integer('id')
                        ->format(Schema::FORMAT_INT64)
                        ->description('ID of the Region'),
                    Schema::string('name')->description('Name of the Region'),
                    Schema::integer('count')
                        ->format(Schema::FORMAT_INT32)
                        ->description('Institutions in that Region')
                )
            )
        );
        return Response::ok()
            ->description('Successful response for counting the institutions by region')
            ->content(MediaType::json()->schema($response));
    }
}
