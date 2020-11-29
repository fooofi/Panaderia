<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;
use App\Models\Contact;
use App\Models\ContactStatus;
use App\Models\ContactType;
use App\Rules\Contact as ContactRule;
use App\Rules\Contacted;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

/**
 * @OpenApi\PathItem()
 */
class ContactController extends Controller
{
    /**
     * Create Contact
     *
     * Creates a new Contact between a Fair User and a Institution.
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\RequestBody(factory="ContactRequestBody")
     * @OpenApi\Response(factory="CreatedResponse", statusCode=201)
     * @OpenApi\Response(factory="ErrorUnauthorizedResponse", statusCode=401)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     */
    public function create(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createContact($request->all());
        return response()->json(
            [
                'message' => 'Contact created successfully',
            ],
            201
        );
    }

    protected function validator(array $data)
    {
        $user = auth()->user();
        return Validator::make($data, [
            'from' => ['required', 'string', Rule::in(['institution', 'campus', 'career'])],
            'from_id' => ['required', 'integer', new ContactRule($data), new Contacted($data, $user)],
            'type' => ['required', 'integer', 'exists:contact_types,id'],
        ]);
    }

    protected function createContact(array $data)
    {
        $model = 'App\\Models\\' . Str::title($data['from']);
        $object = $model::find($data['from_id']);
        $organization = $object->organization;
        $user = auth('api')->user();
        $status = ContactStatus::where('name', 'Waiting')->first();
        Contact::create([
            'organization_id' => $organization->id,
            'fair_user_id' => $user->id,
            'source_model_id' => $object->id,
            'source_model_type' => $model,
            'contact_status_id' => $status->id,
            'contact_type_id' => $data['type'],
        ]);
    }

    /**
     * Retrieve Types of Contact
     *
     * Returns all the Types of contacts.
     *
     * @OpenApi\Operation(tags="contacts")
     * @OpenApi\Response(factory="ContactTypesResponse", statusCode=200)
     */
    public function types()
    {
        $types = ContactType::all()->map(function ($type) {
            return [
                'id' => $type->id,
                'name' => $type->name,
            ];
        });
        return response()->json([
            'types' => $types,
        ]);
    }

    /**
     * Send Contact
     *
     * Send Contact
     * @OpenApi\Operation(tags="contact")
     * @OpenApi\Parameters(factory="ContactParameters")
     * @OpenApi\Response(factory="UpdatedResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     */
    public function sendContact(Request $request)
    {
        $this->validatorSendContact($request->all())->validate();

        if (config('app.env') === 'production') {
            $this->newFreshdeskTicket($request->name, $request->description, $request->email);
        }

        return response()->json(
            [
                'message' => 'Message is send successfully.',
            ],
            200
        );
    }

    protected function validatorSendContact(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
    }

    private function newFreshdeskTicket(string $name, string $description, string $email)
    {
        $url = config('freshdesk.url');
        $api_key = config('freshdesk.api_key');
        $route = '/api/v2/tickets';
        $method = 'post';
        $url = "$url/$route";

        $json_data = [
            'name' => $name,
            'email' => $email,
            'subject' => config('freshdesk.contact_subject'),
            'description' => $description,
            'priority' => 1,
            'source' => 9,
            'status' => 2,
        ];
        $client = new Client();

        $promise = null;
        if ($method == 'post') {
            $promise = $client->post($url, [
                'content-type' => 'application/json',
                'auth' => [$api_key, 'X'],
                'json' => $json_data,
            ]);
        }
    }
}
