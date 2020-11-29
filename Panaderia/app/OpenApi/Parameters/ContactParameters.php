<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class ContactParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('name')
                ->description('User Name')
                ->required()
                ->schema(Schema::string()),
            Parameter::query()
                ->name('email')
                ->description('User Email')
                ->required()
                ->schema(Schema::string()),
            Parameter::query()
                ->name('description')
                ->description('Problem description')
                ->required()
                ->schema(Schema::string()),
        ];
    }
}
