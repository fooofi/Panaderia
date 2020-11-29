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

class CampusSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Campus')->properties(
            Schema::integer('id')
                ->format(Schema::FORMAT_INT64)
                ->description('ID of the Campus'),
            Schema::string('name')->description('Name of the Campus'),
            Schema::string('description')->description('Description of the Campus'),
            Schema::string('address')->description('Address of the Campus'),
            Schema::string('phone')->description('Phone of the Campus'),
            Schema::string('lat')->description('Latitude coordinate of the Campus'),
            Schema::string('lng')->description('Longitude coordinate of the Campus'),
            Schema::string('link')->description('External URL of the Campus'),
            Schema::array('images')->items(
                Schema::object()->properties(
                    Schema::integer('id')
                        ->format(Schema::FORMAT_INT64)
                        ->description('ID of a Image of the Campus')
                )
            )
        );
    }
}
