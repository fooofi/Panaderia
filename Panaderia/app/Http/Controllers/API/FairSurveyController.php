<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FairSurvey;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;

/**
 * @OpenApi\PathItem()
 */
class FairSurveyController extends Controller
{
    /**
     * Retrieve the Fair Survey
     *
     * Returns the Survey associated with the Fair User or returns an error if it doesn't exists.
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\Response(factory="FairSurveyResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     * @OpenApi\Response(factory="ErrorUnauthorizedResponse", statusCode=401)
     */
    public function index()
    {
        $survey = auth('api')->user()->fair_survey;
        if (!$survey) {
            return response()->json(
                [
                    'message' => 'User has no Survey.',
                ],
                404
            );
        }
        return response()->json([
            'survey' => [
                'school' => $survey->school->name,
                'grade' => $survey->grade->name,
                'university' => $survey->university,
                'ip' => $survey->ip,
                'cft' => $survey->cft,
                'ffaa' => $survey->ffaa,
                'gratuidad' => $survey->gratuidad,
                'cae' => $survey->cae,
                'propio' => $survey->propio,
                'becas' => $survey->becas,
                'career' => $survey->career,
                'institution' => $survey->institution,
            ],
        ]);
    }
    /**
     * Create a Fair Survey
     *
     * Creates a Fair User Survey or returns the existing Survey for that Fair User.
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\RequestBody(factory="StoreFairSurveyRequestBody")
     * @OpenApi\Response(factory="CreatedResponse", statusCode=201)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     * @OpenApi\Response(factory="ErrorUnauthorizedResponse", statusCode=401)
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->create($request->all());
        return $request->json([], 201);
    }

    /**
     * List all Grades
     *
     * Returns all the store Grades.
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\Response(factory="ListGradesResponse", statusCode=200)
     */
    public function grades()
    {
        $grades = Grade::all()->map(function ($grade) {
            return [
                'id' => $grade->id,
                'name' => $grade->name,
            ];
        });

        return response()->json([
            'grades' => $grades,
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'school' => ['required', 'integer', 'exists:schools,id'],
            'grade' => ['required', 'integer', 'exists:grades,id'],
            'university' => ['required', 'boolean'],
            'ip' => ['required', 'boolean'],
            'cft' => ['required', 'boolean'],
            'ffaa' => ['required', 'boolean'],
            'gratuidad' => ['required', 'boolean'],
            'cae' => ['required', 'boolean'],
            'propio' => ['required', 'boolean'],
            'becas' => ['required', 'boolean'],
            'career' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function create(array $data)
    {
        return FairSurvey::create([
            'fair_user_id' => auth('api')->user()->id,
            'school_id' => $data['school'],
            'grade_id' => $data['grade'],
            'university' => $data['university'],
            'ip' => $data['ip'],
            'cft' => $data['cft'],
            'ffaa' => $data['ffaa'],
            'gratuidad' => $data['gratuidad'],
            'cae' => $data['cae'],
            'propio' => $data['propio'],
            'becas' => $data['becas'],
            'career' => $data['career'],
            'institution' => $data['institution'],
        ]);
    }
}
