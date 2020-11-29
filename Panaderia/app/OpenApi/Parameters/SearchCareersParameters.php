<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class SearchCareersParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('search')
                ->description('Text to search')
                ->required()
                ->schema(Schema::string()),
            Parameter::query()
                ->name('region')
                ->description('Region ID of the Object')
                ->required(true)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('type')
                ->description('Institution Type ID of the Object')
                ->required(true)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('online')
                ->description('The career modality has to be online')
                ->required(true)
                ->schema(Schema::boolean()),
            Parameter::query()
                ->name('presencial')
                ->description('The career modality has to be presencial')
                ->required(true)
                ->schema(Schema::boolean()),
            Parameter::query()
                ->name('mixto')
                ->description('The career modality has to be mixto')
                ->required(true)
                ->schema(Schema::boolean()),
            Parameter::query()
                ->name('becas')
                ->description('The career needs to have becas')
                ->required(true)
                ->schema(Schema::boolean()),
            Parameter::query()
                ->name('gratuidad')
                ->description('The institution needs to have gratuidad')
                ->required(true)
                ->schema(Schema::boolean()),
            Parameter::query()
                ->name('cruch')
                ->description('The institution needs to be in the cruch')
                ->required(true)
                ->schema(Schema::boolean()),
            Parameter::query()
                ->name('sua')
                ->description('The institution needs to be in the sua')
                ->required(true)
                ->schema(Schema::boolean()),
            Parameter::query()
                ->name('career_type')
                ->description('The institution needs to be in the selected Carrer Type')
                ->required(true)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('area')
                ->description('The institution needs to be in the selected Area')
                ->required(true)
                ->schema(Schema::integer()),
        ];
    }
}
