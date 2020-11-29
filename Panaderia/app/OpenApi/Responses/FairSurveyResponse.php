<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\FairSurveySchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class FairSurveyResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::object('survey')->properties(FairSurveySchema::ref())
        );
        return Response::ok()
            ->description('Successful response')
            ->content(MediaType::json()->schema($response));
    }
}
