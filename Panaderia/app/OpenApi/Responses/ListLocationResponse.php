<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\LocationSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ListLocationResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::array('[location_name]')->items(LocationSchema::ref())
        );
        return Response::create('Locations')
            ->description(
                'Successful response for Countries, Regions, Provinces and Communes'
            )
            ->content(MediaType::json()->schema($response));
    }
}
