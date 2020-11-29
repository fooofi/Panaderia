<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\InstitutionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class InstitutionResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::object('institution')->properties(
                InstitutionSchema::ref(),
                Schema::array('campuses')->items(
                    Schema::object()->properties(
                        Schema::integer('id')
                            ->format(Schema::FORMAT_INT64)
                            ->description('ID of the Campus'),
                        Schema::string('name')->description('Name of the Campus'),
                        Schema::string('address')->description('Full address of the Campus'),
                        Schema::string('link')->description('External URL of the Campus'),
                        Schema::integer('image')
                            ->format(Schema::FORMAT_INT64)
                            ->description('ID of a Image of the Campus')
                    )
                )
            )
        );
        return Response::ok()
            ->description('Successful response for retrieving a Institution')
            ->content(MediaType::json()->schema($response));
    }
}
