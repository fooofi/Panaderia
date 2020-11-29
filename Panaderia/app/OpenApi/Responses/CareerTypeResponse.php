<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CampusSchema;
use App\OpenApi\Schemas\CareerSchema;
use App\OpenApi\Schemas\InstitutionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class CareerTypeResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::integer('id')->description('ID of the Career Type'),
            Schema::string('name')->description('Name of the Career Type'),
        );
        return Response::ok()
            ->description('Successful response for retrieving a Career Type')
            ->content(MediaType::json()->schema($response));
    }
}
