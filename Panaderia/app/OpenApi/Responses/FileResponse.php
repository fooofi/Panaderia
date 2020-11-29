<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class FileResponse extends ResponseFactory
{
    public function build(): Response
    {
        $fileSchema = Schema::object()->properties(Schema::string('url')->description('URL to download the File'));
        return Response::ok()
            ->description('Successful query for a file')
            ->content(MediaType::json()->schema($fileSchema));
    }
}
