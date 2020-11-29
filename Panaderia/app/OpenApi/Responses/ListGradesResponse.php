<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ListGradesResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::array('grades')->items(
                Schema::object()->properties(
                    Schema::integer('id')
                        ->format(Schema::FORMAT_INT64)
                        ->description('ID of the Grade'),
                    Schema::string('name')->description('Name of the Grade')
                )
            )
        );
        return Response::ok()
            ->description('Successful response for listing grades')
            ->content(MediaType::json()->schema($response));
    }
}
