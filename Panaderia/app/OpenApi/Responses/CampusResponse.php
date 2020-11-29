<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CampusSchema;
use App\OpenApi\Schemas\InstitutionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class CampusResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            CampusSchema::ref(),
            Schema::object('institution')->properties(
                InstitutionSchema::ref(),
                Schema::array('campuses')->items(
                    Schema::object()->properties(
                        Schema::integer('id')->description('ID of the Campus'),
                        Schema::string('name')->description('Name of the Campus')
                    )
                )
            ),
            Schema::array('careers')->items(
                Schema::object()->properties(
                    Schema::integer('id')->description('ID of the Career'),
                    Schema::string('name')->description('Name of the Career')
                )
            )
        );
        return Response::ok()
            ->description('Successful response for retrieving a Campus')
            ->content(MediaType::json()->schema($response));
    }
}
