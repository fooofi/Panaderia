<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;

/**
 * @OpenApi\PathItem()
 */
class CampusController extends Controller
{
    /**
     * Retrieve a Campus
     *
     * Returns the Campus data based on the given Institution ID and Campus ID.
     *
     * @OpenApi\Operation(tags="institutions")
     * @OpenApi\Response(factory="CampusResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     */
    public function show(int $institution_id, int $campus_id)
    {
        $institution = Institution::find($institution_id);
        if (!$institution) {
            return response()->json(
                [
                    'message' => 'Institution not found',
                ],
                404
            );
        }

        $campus = $institution->campuses
            ->filter(function ($campus) use ($campus_id) {
                return $campus_id == $campus->id;
            })
            ->first();
        if (!$campus) {
            return response()->json(
                [
                    'message' => 'Campus not found',
                ],
                404
            );
        }

        $images = $campus->campus_images->map(function ($campus_image) {
            return [
                'id' => FileController::getUrlOrId($campus_image->file->id),
            ];
        });
        $institution_logo = $institution->file;
        $careers = $campus->careers->map(function ($career) {
            return [
                'id' => $career->id,
                'name' => $career->name,
            ];
        });
        $campuses = $institution->campuses->map(function ($campus) {
            return [
                'id' => $campus->id,
                'name' => $campus->name,
            ];
        });
        $organization = $institution->organization;
        $institution_data = [
            'id' => $institution->id,
            'name' => $institution->name,
            'link' => $institution->link,
            'type' => $institution->institution_type->name,
            'dependency' => $institution->institution_dependency->name,
            'phone' => $institution->phone,
            'address' => $organization->address . ', ' . $organization->commune->collapseName(false),
            'cruch' => $institution->cruch,
            'sua' => $institution->sua,
            'gratuidad' => $institution->gratuidad,
            'logo' => $institution_logo ? FileController::getUrlOrId($institution_logo->id) : null,
            'banner' => $institution->institution_banner ? FileController::getUrlOrId($institution->institution_banner->file->id) : null,
            'campuses' => $campuses,
        ];

        return response()->json([
            'id' => $campus->id,
            'name' => $campus->name,
            'description' => $campus->description,
            'link' => $campus->link,
            'address' => $campus->collapseAddress(false),
            'phone' => $campus->phone,
            'lat' => $campus->location_lat,
            'lng' => $campus->location_lon,
            'images' => $images,
            'institution' => $institution_data,
            'careers' => $careers,
        ]);
    }
}
