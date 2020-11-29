<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;

class FairSurveySchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('FairSurvey')->properties(
            Schema::string('school')->default(null),
            Schema::string('grade')->default(null),
            Schema::boolean('university')->default(null),
            Schema::boolean('ip')->default(null),
            Schema::boolean('cft')->default(null),
            Schema::boolean('ffaa')->default(null),
            Schema::boolean('gratuidad')->default(null),
            Schema::boolean('cae')->default(null),
            Schema::boolean('becas')->default(null),
            Schema::boolean('propio')->default(null),
            Schema::string('career')->default(null),
            Schema::string('institution')->default(null)
        );
    }
}
