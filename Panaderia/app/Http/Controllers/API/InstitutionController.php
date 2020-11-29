<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\InstitutionType;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;

/**
 * @OpenApi\PathItem()
 */
class InstitutionController extends Controller
{
    /**
     * List Institutions
     *
     * Retrieves all the Institutions based on the query.
     * @OpenApi\Operation(tags="institutions")
     * @OpenApi\Parameters(factory="InstitutionsParameters")
     * @OpenApi\Response(factory="ListInstitutionsResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     */
    public function index(Request $request)
    {
        Validator::make($request->all(), ['type' => ['required', 'string', 'exists:institution_types,id']])->validate();
        $institutions = InstitutionType::find($request->type)->institutions->map(function ($institution) {
            $banner = $institution->institution_banner;
            $icon = $institution->institution_icon;
            $organization = $institution->organization;
            return (object) [
                'id' => $institution->id,
                'name' => $institution->name,
                'type' => $institution->institution_type->name,
                'dependency' => $institution->institution_dependency->name,
                'phone' => $institution->phone,
                'address' => $organization->address . ', ' . $organization->commune->collapseName(false),
                'link' => $institution->link,
                'cruch' => $institution->cruch ? true : false,
                'sua' => $institution->sua ? true : false,
                'gratuidad' => $institution->gratuidad ? true : false,
                'logo' => $institution->file ? FileController::getUrlOrId($institution->file->id) : null,
                'banner' => $banner ? FileController::getUrlOrId($banner->file->id) : null,
                'icon' => $icon ? FileController::getUrlOrId($icon->file->id) : null,
            ];
        });

        return response()->json([
            'count' => $institutions->count(),
            'institutions' => $institutions,
        ]);
    }

    /**
     * Random 8
     *
     * Retrieves 8 random Institutions.
     * @OpenApi\Operation(tags="institutions")
     * @OpenApi\Response(factory="List8InstitutionsResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     */
    public function random8()
    {
        $institutions = Institution::all()->shuffle()->take(8);

        $institutions = $institutions->map(function ($institution) {
            $icon = $institution->institution_icon;
            return (object) [
                'id' => $institution->id,
                'name' => $institution->name,
                'careers' => $institution->careers->count(),
                'campuses' => $institution->campuses->count(),
                'icon' => $icon ? FileController::getUrlOrId($icon->file->id) : null,
            ];
        });

        return response()->json([
            'institutions' => $institutions,
        ]);
    }

    /**
     * Retrieve a Institution
     *
     * Retrieves the Institution based on its ID
     *
     * @OpenApi\Operation(tags="institutions")
     * @OpenApi\Response(factory="InstitutionResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     */
    public function show(int $id)
    {
        $institution = Institution::find($id);
        if (!$institution) {
            return response()->json(
                [
                    'message' => 'Institution not found',
                ],
                404
            );
        }

        $campuses = $institution->campuses->map(function ($campus) {
            $campus_image = $campus->campus_images->first();
            return [
                'id' => $campus->id,
                'name' => $campus->name,
                'address' => $campus->collapseAddress(false),
                'link' => $campus->link,
                'image' => $campus_image ? FileController::getUrlOrId($campus_image->file->id) : null,
            ];
        });
        $logo = $institution->file;
        $banner = $institution->institution_banner;
        $icon = $institution->institution_icon;
        $organization = $institution->organization;
        return response()->json([
            'id' => $institution->id,
            'name' => $institution->name,
            'type' => $institution->institution_type->name,
            'dependency' => $institution->institution_dependency->name,
            'link' => $institution->link,
            'phone' => $institution->phone,
            'address' => $organization->address . ', ' . $organization->commune->collapseName(false),
            'cruch' => $institution->cruch ? true : false,
            'sua' => $institution->sua ? true : false,
            'gratuidad' => $institution->gratuidad ? true : false,
            'logo' => $logo ? FileController::getUrlOrId($logo->id) : null,
            'icon' => $icon ? FileController::getUrlOrId($icon->file->id) : null,
            'banner' => $banner ? FileController::getUrlOrId($banner->file->id) : '',
            'campuses' => $campuses,
        ]);
    }

    /**
     * Retrieve Institution Types
     *
     * Retrieves all the Institution Types.
     *
     * @OpenApi\Operation(tags="institutions")
     * @OpenApi\Response(factory="ListInstitutionTypesResponse", statusCode=200)
     */
    public function types()
    {
        $types = InstitutionType::all()->map(function ($type) {
            return (object) [
                'id' => $type->id,
                'name' => $type->name,
            ];
        });

        return response()->json([
            'types' => $types,
        ]);
    }

    /**
     * Count Institutions by Region.
     *
     * Retrieves and counts all the Institutions that have a Faculty on each Region.
     * @OpenApi\Operation(tags="institutions")
     * @OpenApi\Response(factory="ListInstitutionsByRegionResponse", statusCode=200)
     */
    public function byRegion()
    {
        $regions = Region::all()->map(function ($region) {
            return (object) [
                'id' => $region->id,
                'name' => $region->name,
                'count' => 0,
            ];
        });
        Institution::all()->map(function ($institution) use ($regions) {
            $campuses = $institution->campuses->unique(function ($campus) {
                return $campus->commune_id;
            });
            $campuses->each(function ($campus) use ($regions) {
                $region_id = $campus->commune->province->region->id;
                $regions->each(function ($region) use ($region_id) {
                    if ($region->id == $region_id) {
                        $region->count++;
                    }
                });
            });
        });

        return response()->json([
            'regions' => $regions,
        ]);
    }
}
