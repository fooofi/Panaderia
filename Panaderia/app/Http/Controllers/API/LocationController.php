<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;

/**
 * @OpenApi\PathItem()
 */
class LocationController extends Controller
{
    /**
     * Retrieve the Countries
     *
     * Returns all the stored countries.
     *
     * @OpenApi\Operation(tags="location")
     * @OpenApi\Response(factory="ListLocationResponse", statusCode=200)
     */
    public function countries()
    {
        $countries = Country::all()->map(function ($country) {
            return (object) [
                'id' => $country->id,
                'name' => $country->name,
            ];
        });
        return response()->json([
            'countries' => $countries,
        ]);
    }

    /**
     * Retrieve the Regions of a Country
     *
     * Returns all the stored Regions for a given Country.
     *
     * @OpenApi\Operation(tags="location")
     * @param int $country_id Country ID
     * @OpenApi\Response(factory="ListLocationResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     */
    public function regions(int $country_id)
    {
        Log::info($country_id);
        $country = Country::find($country_id);
        if (!$country) {
            return response()->json(
                [
                    'message' => 'Country not found',
                ],
                404
            );
        }
        $regions = $country->regions->map(function ($region) {
            return (object) [
                'id' => $region->id,
                'name' => $region->name,
            ];
        });

        return response()->json([
            'regions' => $regions,
        ]);
    }

    /**
     * Retrieve the Provinces of a Region
     *
     * Returns all the stored Provinces for a given Region
     * @OpenApi\Operation(tags="location")
     * @param int $country_id Country ID
     * @param int $region_id Region ID
     * @OpenApi\Response(factory="ListLocationResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     */
    public function provinces(int $country_id, int $region_id)
    {
        $region = Region::find($region_id);
        if (!$region) {
            return response()->json(['message' => 'Region not found'], 404);
        }
        if ($region->country->id != $country_id) {
            return response()->json(
                [
                    'message' => 'Country not found',
                ],
                404
            );
        }
        $provinces = $region->provinces->map(function ($province) {
            return (object) [
                'id' => $province->id,
                'name' => $province->name,
            ];
        });
        return response()->json([
            'provinces' => $provinces,
        ]);
    }
    /**
     * Retrieve the Communes of a Province
     *
     * Returns all the stored Communes for a given Region
     * @OpenApi\Operation(tags="location")
     * @param int $country_id Country ID
     * @param int $region_id Region ID
     * @param int $province_id Province ID
     * @OpenApi\Response(factory="ListLocationResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     */
    public function communes(int $country_id, int $region_id, int $province_id)
    {
        $province = Province::find($province_id);
        if (!$province) {
            return response()->json(
                [
                    'message' => 'Province not found',
                ],
                404
            );
        }
        if ($province->region->id != $region_id) {
            return response()->json(
                [
                    'message' => 'Region not found',
                ],
                404
            );
        }
        if ($province->region->country->id != $country_id) {
            return response()->json(
                [
                    'message' => 'Country not found',
                ],
                404
            );
        }
        $communes = $province->communes->map(function ($commune) {
            return (object) [
                'id' => $commune->id,
                'name' => $commune->name,
            ];
        });
        return response()->json([
            'communes' => $communes,
        ]);
    }

    /**
     * List all the Regions
     *
     * Returns all the stored Regions.
     * @OpenApi\Operation(tags="location")
     * @OpenApi\Response(factory="ListRegionsResponse", statusCode=200)
     */
    public function allRegions()
    {
        $regions = Region::all()->map(function ($region) {
            return [
                'id' => $region->id,
                'name' => $region->name,
            ];
        });

        return response()->json([
            'regions' => $regions,
        ]);
    }
}
