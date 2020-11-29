<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Career;
use App\Models\CareerType;
use App\Models\File;
use App\Models\Institution;
use App\Models\Scholarship;
use App\Models\ScholarshipOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;

/**
 * @OpenApi\PathItem()
 */
class CareerTypeController extends Controller
{
    /**
     * Retrieve a Careers
     *
     * Retrieves the Careers based on its ID
     *
     * @OpenApi\Operation(tags="careers")
     * @OpenApi\Response(factory="CareerTypeResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {

        $career_types = CareerType::select('id', 'name')->get();

        return response()->json([
            'career_types' => $career_types,
        ]);

    }
}
