<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class FairUserSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('FairUser')->properties(
            Schema::integer('id')->format(Schema::FORMAT_INT64),
            Schema::string('name')->default(null),
            Schema::string('lastname')->default(null),
            Schema::string('rut')->default(null),
            Schema::string('phone')->default(null),
            Schema::string('email'),
            Schema::string('birthday')
                ->format(Schema::FORMAT_DATE)
                ->default(null),
            Schema::integer('commune_id')->format(Schema::FORMAT_INT64),
            Schema::string('commune')->default(null),
            Schema::boolean('survey')->default(null)
        );
    }
}
