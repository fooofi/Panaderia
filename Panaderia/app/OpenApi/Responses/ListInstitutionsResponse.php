<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\InstitutionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ListInstitutionsResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::string('count')->description('Amount of Institutions'),
            Schema::array('institutions')->items(InstitutionSchema::ref())
        );
        return Response::ok()
            ->description('Successful response for listing Institutions')
            ->content(MediaType::json()->schema($response));
    }
}
