<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CampusSchema;
use App\OpenApi\Schemas\CareerSchema;
use App\OpenApi\Schemas\InstitutionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class AreasResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::integer('id')->description('ID of the Area'),
            Schema::string('name')->description('Name of the Area'),
        );
        return Response::ok()
            ->description('Successful response for retrieving a Areas')
            ->content(MediaType::json()->schema($response));
    }
}
