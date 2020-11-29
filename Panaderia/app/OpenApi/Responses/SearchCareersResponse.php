<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class SearchCareersResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::integer('count')->description('Amount of Careers found'),
            Schema::array('careers')->items(
                Schema::object()->properties(
                    Schema::integer('id')->description('ID of the Career'),
                    Schema::integer('institution_id')->description('ID of the Institution'),
                    Schema::integer('campus_id')->description('ID of the Campus'),
                    Schema::string('name')->description('Name of the Career'),
                    Schema::string('link')->description('External URL of the Career'),
                    Schema::string('address')->description('Address of the Campus that has this Career'),
                    Schema::integer('logo')->description('ID of the file storing the institution logo'),
                    Schema::integer('banner')->description('ID of the file storing the banner of the Campus'),
                    Schema::integer('icon')->description('ID of the file storing the icon of the institution')
                )
            )
        );
        return Response::ok()
            ->description('Successful response of searching careers')
            ->content(MediaType::json()->schema($response));
    }
}
