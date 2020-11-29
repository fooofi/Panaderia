<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class SearchSchoolsParameters extends ParametersFactory
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
                ->name('commune')
                ->description('Commune ID of the Object')
                ->required()
                ->schema(Schema::integer()),
        ];
    }
}
