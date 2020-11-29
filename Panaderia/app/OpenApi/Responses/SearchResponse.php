<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class SearchResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::integer('count')->format(Schema::FORMAT_INT32),
            Schema::array('results')
                ->items(
                    Schema::object()->properties(
                        Schema::number('id')->format(Schema::FORMAT_INT64),
                        Schema::string('name')
                    )
                )
                ->example([
                    (object) [
                        'id' => 1,
                        'name' => 'Name of object',
                    ],
                ])
        );
        return Response::create('Search')
            ->description('Search responses')
            ->content(MediaType::json()->schema($response));
    }
}
