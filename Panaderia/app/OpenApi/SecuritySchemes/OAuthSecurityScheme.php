<?php

namespace App\OpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class OAuthSecurityScheme extends SecuritySchemeFactory implements Reusable
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('OAuth')
            ->description('OAuth 2.0 Authorization')
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer')
            ->bearerFormat('JWT');
    }
}
