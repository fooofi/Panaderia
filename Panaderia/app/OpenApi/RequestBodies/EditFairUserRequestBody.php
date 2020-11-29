<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class EditFairUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        $request = Schema::object()->properties(
            Schema::string('name'),
            Schema::string('lastname'),
            Schema::string('phone'),
            Schema::string('birthday')->format(Schema::FORMAT_DATE),
            Schema::integer('commune_id')->format(Schema::FORMAT_INT64)
        );
        return RequestBody::create('FairUserEdit')
            ->description('Fair User editable data')
            ->content(MediaType::json()->schema($request));
    }
}
