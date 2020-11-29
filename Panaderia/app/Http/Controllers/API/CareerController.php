<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Career;
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
class CareerController extends Controller
{
    /**
     * Retrieve a Careers
     *
     * Retrieves the Careers based on its ID
     *
     * @OpenApi\Operation(tags="careers")
     * @OpenApi\Response(factory="CareersResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     * @param int $institution_id
     * @param int $campus_id
     * @param int $career_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $institution_id, int $campus_id, int $career_id)
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

        $campus = Campus::find($campus_id);

        if (!$campus) {
            return response()->json(
                [
                    'message' => 'Campus not found',
                ],
                404
            );
        }

        $career = $campus->careers->filter(function ($career) use ($career_id) {
            return $career->id == $career_id;
        })
        ->first();


        if (!$career) {
            return response()->json(
                [
                    'message' => 'Career not found',
                ],
                404
            );
        }

        $scholarshipOwners = ScholarshipOwner::all()->map(function ($scholarshipOwner) use ($career){

            $scholarships = $career->scholarships->map(function ($scholarship) use ($scholarshipOwner){
    
                return (object)[
                        'id' => $scholarship->id,
                        'name' => $scholarship->name,
                        'scholarship_owner' => $scholarship->scholarship_owner->id
                    ];
                
                        
            })->filter(function($scholarship) use($scholarshipOwner)
        {
            return $scholarship->scholarship_owner == $scholarshipOwner->id;
        });
            return (object)[
                'scholarships_count' => $scholarships->count(),
                'name' => $scholarshipOwner->name,
                'id' => $scholarshipOwner->id,
            ];
        });

        $scholarships = $career->scholarships->map(function($scholarship)
        {
            return (object)[
                'id' => $scholarship->id,
                'scholarship_owner_id' => $scholarship->scholarship_owner->id,
                'name' => $scholarship->name
            ];
        });

        $images = $campus->campus_images->map(function ($campus_image) {
            return [
                'id' => FileController::getUrlOrId($campus_image->file->id),
            ];
        });
        $campus_data = [
            'id'          => $campus->id,
            'name'        => $campus->name,
            'description' => $campus->description,
            'link'        => $campus->link,
            'address'     => $campus->collapseAddress(false),
            'phone'       => $campus->phone,
            'lat'         => $campus->location_lat,
            'lng'         => $campus->location_lon,
            'images'      => $images,
        ];

        $institution_logo = $institution->file;
        $institution_data = [
            'id'         => $institution->id,
            'name'       => $institution->name,
            'link'       => $institution->link,
            'type'       => $institution->institution_type->name,
            'dependency' => $institution->institution_dependency->name,
            'cruch'      => $institution->cruch,
            'sua'        => $institution->sua,
            'gratuidad'  => $institution->gratuidad,
            'logo'       => $institution_logo ? FileController::getUrlOrId($institution_logo->id) : null,
            'banner'     => $institution->institution_banner ? FileController::getUrlOrId($institution->institution_banner->file->id) : null,
        ];

        if (!$career->career_score)
        {
            $scores = null;
        }else{
            $scores = [
                "id"              => $career->career_score->id,
                "career_id"       => $career->career_score->career_id,
                "year"            => $career->career_score->year,
                "nem"             => $career->career_score->nem,
                "ranking"         => $career->career_score->ranking,
                "math"            => $career->career_score->math,
                "history_science" => $career->career_score->history_science,
                'language'        => $career->career_score->language,
                "max_score"       => $career->career_score->max_score,
                "avg_score"       => $career->career_score->avg_score,
                "min_score"       => $career->career_score->min_score,

            ];
        }

        $related_careers = $campus->careers->take(3)->map(function ($career) {
            return [
                'id' => $career->id,
                'name' => $career->name,
            ];
        });


        return response()->json([
            'id'            => $career->id,
            'name'          => $career->name,
            'description'   => $career->description,
            'link'          => $career->link,
            'video'         => $career->video,
            'regime'        => $career->career_regime ? $career->career_regime->name : null,
            'accreditation' => [
                'id'   => $career->accreditation->id,
                'name' => $career->accreditation->name
            ],
            'semesters'           => $career->semesters,
            'area'                => $career->area->name,
            'type'                => $career->career_type->name,
            'modality'            => $career->modality->name,
            'brochure_pdf'        => File::find($career->brochure_pdf) ?  File::find($career->brochure_pdf)->id : false,
            'curricular_mesh_pdf' => File::find($career->curricular_mesh_pdf) ?  File::find($career->curricular_mesh_pdf)->id : false,
            'scores'              => $scores,
            'scholarship_owners'  => $scholarshipOwners,
            'scholarships'        => $scholarships,
            'campus_data'         => $campus_data,
            'related_careers'     => $related_careers,
            'institution'         => $institution_data,
        ]);
    }
}
