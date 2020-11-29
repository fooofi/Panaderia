<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use App\OpenApi\Schemas\FairSurveySchema;

class StoreFairSurveyRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('SurveyCreate')
            ->description('Survey data')
            ->content(MediaType::json()->schema(FairSurveySchema::ref()));
    }
}
