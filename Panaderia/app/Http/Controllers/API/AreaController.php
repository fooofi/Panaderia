<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Area;
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
class AreaController extends Controller
{
    /**
     * Retrieve a Areas
     *
     * Retrieves the Areas based on its ID
     *
     * @OpenApi\Operation(tags="careers")
     * @OpenApi\Response(factory="AreasResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {

        $areas = Area::select('id', 'name')->get();

        return response()->json([
            'areas' => $areas,
        ]);

    }
}
