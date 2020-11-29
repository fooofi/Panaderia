<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CampusSchema;
use App\OpenApi\Schemas\CareerSchema;
use App\OpenApi\Schemas\InstitutionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class CareersResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::integer('id')->description('ID of the Career'),
            Schema::string('name')->description('Name of the Career'),
            CareerSchema::ref(),
            Schema::array('related_careers')->items(
                Schema::object('career')->properties(
                    Schema::integer('id')
                        ->format(Schema::FORMAT_INT64)
                        ->description('ID of the Career'),
                    Schema::string('name')->description('Name of the Career')
                )
            ),
            InstitutionSchema::ref(),
        );
        return Response::ok()
            ->description('Successful response for retrieving a Career')
            ->content(MediaType::json()->schema($response));
    }
}
