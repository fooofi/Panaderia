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

class InstitutionSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Institution')->properties(
            Schema::integer('id')->description('ID of the Institution'),
            Schema::string('name')->description('Name of the Institution'),
            Schema::string('phone')->description('Phone of the Institution'),
            Schema::string('address')->description('Address of the Institution'),
            Schema::string('type')->description('Type of Institution'),
            Schema::string('dependency')->description('Dependency of the Institution'),
            Schema::string('link')->description('External Link of the Institution'),
            Schema::boolean('cruch')->description('Member of the CRUCh'),
            Schema::boolean('sua')->description('Member of the Sistema Unico de Admisión'),
            Schema::boolean('gratuidad')->description('Has Gratuidad'),
            Schema::integer('logo')->description('ID of the image containing the Logo'),
            Schema::integer('banner')->description('ID of the image containing the Banner'),
            Schema::integer('icon')->description('ID of the image containing the Icon')
        );
    }
}
