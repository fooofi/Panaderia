<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\FairUserSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class FairUserResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::object('fairuser')->properties(FairUserSchema::ref())
        );
        return Response::ok()
            ->description('Successful request of the Fair User')
            ->content(MediaType::json()->schema($response));
    }
}
