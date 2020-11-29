<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\Area;
use App\Models\Campus;
use App\Models\Career;
use App\Models\CareerScholarship;
use App\Models\CareerType;
use App\Models\Commune;
use App\Models\Institution;
use App\Models\InstitutionType;
use App\Models\Modality;
use App\Models\Region;
use App\Models\Scholarship;
use App\Models\ScholarshipOwner;
use App\Models\School;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use AG\ElasticApmLaravel\Facades\ApmCollector;

/**
 * @OpenApi\PathItem()
 */
class SearchController extends Controller
{
    /**
     * Search for School
     *
     * Returns at most 20 Schools that match the name and commune.
     *
     * @OpenApi\Operation(tags="search")
     * @OpenApi\Parameters(factory="SearchParameters")
     * @OpenApi\Parameters(factory="SearchSchoolsParameters")
     * @OpenApi\Response(factory="SearchResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     */
    public function schools(Request $request)
    {
        Validator::make($request->all(), [
            'search' => ['required', 'string'],
            'commune' => ['required', 'integer', 'exists:communes,id'],
        ])->validate();

        $schools = School::search($request->search)
            ->where('commune_id', $request->commune)
            ->take(20)
            ->get();

        $schools = collect($schools)->map(function ($school) {
            return [
                'id' => $school->id,
                'name' => $school->name,
            ];
        });

        return response()->json([
            'results' => $schools,
            'count' => $schools->count(),
        ]);
    }
    /**
     * Search for Commune
     *
     * Returns at most 20 Communes that match the given name.
     *
     * @OpenApi\Operation(tags="search")
     * @OpenApi\Parameters(factory="SearchParameters")
     * @OpenApi\Response(factory="SearchResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     */
    public function communes(Request $request)
    {
        Validator::make($request->all(), ['search' => ['required', 'string']]);

        $communes = Commune::search($request->search)
            ->take(20)
            ->get();

        $communes = collect($communes)->map(function ($commune) {
            return [
                'id' => $commune->id,
                'name' => $commune->name,
            ];
        });
        return response()->json([
            'results' => $communes,
            'count' => $communes->count(),
        ]);
    }

    /**
     * Search for Careers
     *
     * Returns at most 50 Careers that match the given parameters.
     * @OpenApi\Operation(tags="search")
     * @OpenApi\Parameters(factory="SearchCareersParameters")
     * @OpenApi\Response(factory="SearchCareersResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     */
    public function careers(Request $request)
    {
        $this->validatorCareers($request->all())->validate();
        ApmCollector::startMeasure('career-search', 'custom', 'measure', 'Career Search');
        $careers = $this->filterCareersResults($request->all())->take(50);
        $careers = $careers->map(function ($career) use ($request) {
            $campus = null;
            if ($request->region != 0) {
                $campus = Campus::join('campus_career', 'campus_career.campus_id', '=', 'campuses.id')
                    ->where('campus_career.career_id', $career->id)
                    ->join('communes', 'communes.id', '=', 'campuses.commune_id')
                    ->join('provinces', 'provinces.id', '=', 'communes.province_id')
                    ->join('regions', 'regions.id', '=', 'provinces.region_id')
                    ->where('regions.id', $request->region)
                    ->select('campuses.*')
                    ->get()
                    ->first();
            } else {
                $campus = $career->campuses->first();
            }
            $institution = $career->institution;
            $banner = $campus->campus_images->first();
            $icon = $institution->institution_icon;
            return [
                'id' => $career->id,
                'institution_id' => $institution->id,
                'campus_id' => $campus->id,
                'name' => $career->name,
                'link' => $career->link,
                'address' => $campus->address . ', ' . $campus->commune->collapseName(false),
                'logo' => $institution->file ? FileController::getUrlOrId($institution->file->id) : null,
                'banner' => $banner ? FileController::getUrlOrId($banner->file->id) : null,
                'icon' => $icon ? FileController::getUrlOrId($icon->file->id) : null,
            ];
        });
        ApmCollector::stopMeasure('career-search');
        return response()->json([
            'count' => $careers->count(),
            'careers' => $careers,
        ]);
    }

    protected function validatorCareers(array $data)
    {
        return Validator::make($data, [
            'search' => ['present', 'string', 'nullable'],
            'region' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'online' => ['required', 'boolean'],
            'presencial' => ['required', 'boolean'],
            'mixto' => ['required', 'boolean'],
            'becas' => ['required', 'boolean'],
            'cae' => ['required', 'boolean'],
            'gratuidad' => ['required', 'boolean'],
            'cruch' => ['required', 'boolean'],
            'sua' => ['required', 'boolean'],
            'accredited' => ['required', 'boolean'],
            'in_accreditation' => ['required', 'boolean'],
            'career_type' => ['required', 'integer'],
            'area' => ['required', 'integer'],
        ]);
    }

    protected function filterCareersResults(array $data)
    {
        $careers_ids = null;

        if ($data['search']) {
            $search = $data['search'];
            Log::info("search->$search");
            $careers = Career::search($search)->get();
            $careers_ids = $careers->pluck('id');
        }

        // Filter by Region
        if (Region::where('id', $data['region'])->exists()) {
            $query = Region::where('regions.id', $data['region'])
                ->join('provinces', 'regions.id', '=', 'provinces.region_id')
                ->join('communes', 'provinces.id', '=', 'communes.province_id')
                ->join('campuses', 'communes.id', '=', 'campuses.commune_id')
                ->join('campus_career', 'campuses.id', '=', 'campus_career.campus_id');

            if($careers_ids!=null)
                $query->whereIn('campus_career.career_id', $careers_ids);

            $careers_ids = $query->orderBy('campus_career.career_id', 'asc')
                ->select('campus_career.career_id')
                ->distinct()
                ->get()
                ->pluck('career_id');
        }

        // Filter by Institution Type
        if (InstitutionType::where('id', $data['type'])->exists()) {
            $query = InstitutionType::where('institution_types.id', $data['type'])
                ->join('institutions', 'institutions.institution_type_id', '=', 'institution_types.id')
                ->join('careers', 'careers.institution_id', '=', 'institutions.id');

            if($careers_ids!=null)
                $query->whereIn('careers.id', $careers_ids);

            $careers_ids = $query->orderBy('careers.id', 'asc')
                ->select('careers.id')
                ->distinct()
                ->get()
                ->pluck('id');
        }

        // Filter by Modality
        $modalities = [];
        if ($data['online'])
            array_push($modalities, 'Online');
        if ($data['presencial'])
            array_push($modalities, 'Presencial');
        if ($data['mixto'])
            array_push($modalities, 'Mixto');

        if (!empty($modalities)){

            $query = Modality::whereIn('modalities.name', $modalities)
                ->join('careers', 'careers.modality_id', '=', 'modalities.id');

            if($careers_ids!=null)
                $query->whereIn('careers.id', $careers_ids);

            $careers_ids = $query->orderBy('careers.id', 'asc')
                ->select('careers.id')
                ->distinct()
                ->get()
                ->pluck('id');
        }

        // Filter by Becas
        $scholarships_ids = collect([]);
        if ($data['becas']) {
            $becas = ScholarshipOwner::where('scholarship_owners.name', 'regexp', '^Becas')
                ->join('scholarships', 'scholarships.scholarship_owner_id', '=', 'scholarship_owners.id')
                ->select('scholarships.id')
                ->distinct()
                ->get()
                ->pluck('id');
            $scholarships_ids = $scholarships_ids->merge($becas);
        }
        if ($data['cae']) {
            $cae = Scholarship::where('name', 'regexp', 'CAE')
                ->get()
                ->pluck('id');
            $scholarships_ids = $scholarships_ids->merge($cae);
        }

        if ($scholarships_ids->isNotEmpty()){
            $query = CareerScholarship::whereIn('scholarship_id', $scholarships_ids);

            if($careers_ids!=null)
                $query->whereIn('career_id', $careers_ids);

            $careers_ids = $query->orderBy('career_id', 'asc')
                ->select('career_id')
                ->distinct()
                ->get()
                ->pluck('career_id');
        }

        // Filter by Gratuidad - SUA - Cruch
        $filter_gsc = [];
        if ($data['gratuidad']) {
            array_push($filter_gsc, ['institutions.gratuidad', true]);
        }
        if ($data['sua']) {
            array_push($filter_gsc, ['institutions.sua', true]);
        }
        if ($data['cruch']) {
            array_push($filter_gsc, ['institutions.cruch', true]);
        }

        if (!empty($filter_gsc)){

            $query = Institution::where($filter_gsc)
                ->join('careers', 'careers.institution_id', '=', 'institutions.id');

            if($careers_ids!=null)
                $query->whereIn('careers.id', $careers_ids);

            $careers_ids = $query->orderBy('careers.id', 'asc')
                ->select('careers.id')
                ->distinct()
                ->get()
                ->pluck('id');
        }

        // Filter by accredited
        $accreditations = collect([]);
        if ($data['accredited']) {
            $query = Accreditation::where('name', 'regexp', '^[0-9]+\sAños?$')->get()->pluck('id');
            $accreditations = $accreditations->merge($query);
        }
        if ($data['in_accreditation']) {
            $query = Accreditation::where('name', 'En vias de acreditacion')->get()->pluck('id');
            $accreditations = $accreditations->merge($query);
        }

        if ($accreditations->isNotEmpty()){
            $query = Career::whereIn('accreditation_id', $accreditations);

            if($careers_ids!=null)
                $query->whereIn('id', $careers_ids);

            $careers_ids = $query->orderBy('id', 'asc')
                ->select('id')
                ->distinct()
                ->get()
                ->pluck('id');
        }

        // Filter by Career Type - Area
        $careers_filters = [];
        if (CareerType::where('id', $data['career_type'])->exists()) {
            array_push($careers_filters, ['career_type_id', $data['career_type']]);
        }
        if (Area::where('id', $data['area'])->exists()) {
            array_push($careers_filters, ['area_id', $data['area']]);
        }

        if (!empty($careers_filters)){

            $query = Career::where($careers_filters);

            if($careers_ids!=null)
                $query->whereIn('careers.id', $careers_ids);

            $careers_ids = $query->orderBy('id', 'asc')
                ->select('id')
                ->distinct()
                ->get()
                ->pluck('id');
        }

        $careers = [];
        if($careers_ids!=null){
            Log::info("Filtered Search");
            $careers = Career::whereIn('id', $careers_ids)->get();
        }
        else {
            Log::info("All Search");
            $careers = Career::all();
        }

        return $careers;
    }
}
