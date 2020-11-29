<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FairUserEmailVerification;
use App\Models\FairUserResetPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Client;
use App\Models\FairUser;
use App\Rules\Rut;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;
/**
 * @OpenApi\PathItem()
 */
class FairUserController extends Controller
{
    /**
     * Retrieve User data
     *
     * Returns the stored data of the User
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\Response(factory="FairUserResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorUnauthorizedResponse", statusCode=401)
     */
    public function index()
    {
        $user = auth('api')->user();
        return response()->json([
            'fairuser' => [
                'id' => $user->id,
                'name' => $user->name,
                'lastname' => $user->lastname,
                'rut' => $user->rut,
                'phone' => $user->phone,
                'email' => $user->email,
                'birthday' => $user->birthday,
                'commune' => $user->commune->name,
                'commune_id' => $user->commune_id,
                'survey' => $user->fair_survey ? 1 : 0,
            ],
        ]);
    }

    /**
     * Create a Fair User
     *
     * Register a new Fair User
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\RequestBody(factory="RegisterFairUserRequestBody")
     * @OpenApi\Response(factory="CreatedResponse", statusCode=201)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     * @OpenApi\Response(factory="ErrorClientResponse", statusCode=400)
     */
    public function create(Request $request)
    {
        $this->validator($request->all())->validate();
        if (!$this->checkClient($request->all())) {
            return response()->json(
                [
                    'message' => 'Invalid client credentials',
                ],
                400
            );
        }
        event(new Registered(($user = $this->register($request->all()))));

        Mail::to($user->email)->queue($user->getEmailForVerification());

        try{
            if (config('app.env') === 'production') {
                $this->newFreshdeskUser($user);
            }
        } catch (Exception $e) {
            Log::error("Error upload user in Freshdesk");
        }

        return response()->json(
            [
                'message' => 'Fair User created successfully',
            ],
            201
        );
    }

    /**
     * Validate Email for Fair User
     *
     * use token to check if email is valid
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\RequestBody(factory="ValidateEmailFairUserRequestBody")
     * @OpenApi\Response(factory="ValidateEmailFairUserResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     * @OpenApi\Response(factory="ErrorClientResponse", statusCode=400)
     */
    public function validateEmail(Request $request)
    {
        $this->validatorToken($request->all())->validate();
        if (!$this->checkClient($request->all())) {
            return response()->json(
                [
                    'message' => 'Invalid client credentials',
                ],
                400
            );
        }

        $email_verification = FairUserEmailVerification::where('token', $request['token'])->first();
        if ($email_verification == null) {
            return response()->json(
                [
                    'message' => 'the token is invalid',
                    'errors' => [
                        'token' => ['invalid token'],
                    ],
                ],
                422
            );
        }

        if ($email_verification->fair_user->hasVerifiedEmail()) {
            return response()->json(
                [
                    'message' => 'the user is already verified',
                    'errors' => [
                        'token' => ['the user is already verified'],
                    ],
                ],
                422
            );
        }

        if ($email_verification->updated_at < now()->subHours(intval(config('app.fair_verification_ttl')))) {
            $user = $email_verification->fair_user;
            Mail::to($user->email)->queue($user->getEmailForVerification());

            return response()->json(
                [
                    'message' => 'the token has expired, we send a new email for verify user email',
                    'errors' => [
                        'token' => ['the token has expired'],
                    ],
                ],
                422
            );
        }

        $email_verification->fair_user->markEmailAsVerified();
        $email_verification->fair_user->save();

        return response()->json(
            [
                'status' => true,
                'message' => 'Fair User email is validated successfully',
            ],
            200
        );
    }

    /**
     * Resend validate Email for Fair User
     *
     * send a new mail with token to validate fair user email
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\RequestBody(factory="ResendValidateEmailFairUserRequestBody")
     * @OpenApi\Response(factory="ValidateEmailFairUserResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     * @OpenApi\Response(factory="ErrorClientResponse", statusCode=400)
     */
    public function resendValidateEmail(Request $request)
    {
        $this->validatorEmail($request->all())->validate();
        if (!$this->checkClient($request->all())) {
            return response()->json(
                [
                    'message' => 'Invalid client credentials',
                ],
                400
            );
        }

        $user = FairUser::where('email', $request['email'])->first();
        if ($user == null) {
            return response()->json(
                [
                    'message' => 'the email is invalid',
                    'errors' => [
                        'email' => ['invalid email'],
                    ],
                ],
                422
            );
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(
                [
                    'message' => 'the user is already verified',
                    'errors' => [
                        'token' => ['the user is already verified'],
                    ],
                ],
                422
            );
        }

        Mail::to($user->email)->queue($user->getEmailForVerification());

        return response()->json(
            [
                'status' => true,
                'message' => 'Verification email sended',
            ],
            200
        );
    }

    /**
     * Resend validate Email for Fair User
     *
     * send a new mail with token to recover fair user password
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\RequestBody(factory="ResendValidateEmailFairUserRequestBody")
     * @OpenApi\Response(factory="ValidateEmailFairUserResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     * @OpenApi\Response(factory="ErrorClientResponse", statusCode=400)
     */
    public function sendResetPasswordEmail(Request $request)
    {
        $this->validatorEmail($request->all())->validate();
        if (!$this->checkClient($request->all())) {
            return response()->json(
                [
                    'message' => 'Invalid client credentials',
                ],
                400
            );
        }

        $user = FairUser::where('email', $request['email'])->first();
        if ($user == null) {
            return response()->json(
                [
                    'message' => 'the email is invalid',
                    'errors' => [
                        'email' => ['invalid email'],
                    ],
                ],
                422
            );
        }

        Mail::to($user->email)->queue($user->getEmailForPasswordReset());

        return response()->json(
            [
                'status' => true,
                'message' => 'Reset password email sended',
            ],
            200
        );
    }

    /**
     * Resend validate Email for Fair User
     *
     * send a new mail with token to recover fair user password
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\RequestBody(factory="ResendValidateEmailFairUserRequestBody")
     * @OpenApi\Response(factory="ValidateEmailFairUserResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     * @OpenApi\Response(factory="ErrorClientResponse", statusCode=400)
     */
    public function recoverPassword(Request $request)
    {
        $this->validatorTokenAndPassword($request->all())->validate();
        if (!$this->checkClient($request->all())) {
            return response()->json(
                [
                    'message' => 'Invalid client credentials',
                ],
                400
            );
        }

        $reset_password = FairUserResetPassword::where('token', $request['token'])->first();
        if ($reset_password == null) {
            return response()->json(
                [
                    'message' => 'the token is invalid',
                    'errors' => [
                        'token' => ['invalid token'],
                    ],
                ],
                422
            );
        }

        if ($reset_password->updated_at < now()->subHours(intval(config('app.fair_verification_ttl')))) {
            return response()->json(
                [
                    'message' => 'the token has expired',
                    'errors' => [
                        'token' => ['the token has expired'],
                    ],
                ],
                422
            );
        }

        if (Hash::check($request['password'], $reset_password->fair_user->password)) {
            return response()->json(
                [
                    'message' => "You can't set an old password",
                    'errors' => [
                        'password' => ["You can't set an old password"],
                    ],
                ],
                422
            );
        }
        $password = Hash::make($request['password']);
        $reset_password->fair_user->password = $password;
        $reset_password->fair_user->save();

        $reset_password->delete();

        return response()->json(
            [
                'status' => true,
                'message' => 'Fair User password is updated successfully',
            ],
            200
        );
    }

    /**
     * Edit Fair User
     *
     * Updates the Fair User data based on the data given.
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\RequestBody(factory="EditFairUserRequestBody")
     * @OpenApi\Response(factory="UpdatedResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorUnauthorizedResponse", statusCode=401)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     */
    public function edit(Request $request)
    {
        $this->validatorEdit($request->all())->validate();
        $user = auth('api')->user();
        $this->editUser($request->all(), $user);
        return response()->json(
            [
                "message" => "Fair User profile is updated successfully.",
            ],
            200
        );
    }

    /**
     * Change Fair User password
     *
     * Updates the Fair User password with a new one.
     *
     * @OpenApi\Operation(tags="fair users")
     * @OpenApi\RequestBody(factory="ChangeFairUserPasswordRequestBody")
     * @OpenApi\Response(factory="UpdatedResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorUnauthorizedResponse", statusCode=401)
     * @OpenApi\Response(factory="ErrorValidationResponse", statusCode=422)
     */
    public function password(Request $request)
    {
        $this->validatorPassword($request->all())->validate();
        $user = auth('api')->user();
        return $this->changePassword($request->all(), $user);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'client_id' => ['required', 'integer'],
            'client_secret' => ['required', 'string'],
            'fairuser.name' => ['required', 'string', 'max:255'],
            'fairuser.lastname' => ['required', 'string', 'max:255'],
            'fairuser.rut' => ['required', 'string', 'max:255', new Rut()],
            'fairuser.phone' => ['required', 'string', 'max:255'],
            'fairuser.email' => ['required', 'string', 'email', 'max:255', 'unique:fair_users,email'],
            'fairuser.password' => ['required', 'string', 'min:8', 'confirmed'],
            'fairuser.birthday' => ['required', 'date', 'date_format:Y-m-d'],
            'fairuser.commune' => ['required', 'integer', 'exists:communes,id'],
        ]);
    }

    protected function validatorToken(array $data)
    {
        return Validator::make($data, [
            'client_id' => ['required', 'integer'],
            'client_secret' => ['required', 'string'],
            'token' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function validatorEmail(array $data)
    {
        return Validator::make($data, [
            'client_id' => ['required', 'integer'],
            'client_secret' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
    }

    protected function validatorTokenAndPassword(array $data)
    {
        return Validator::make($data, [
            'client_id' => ['required', 'integer'],
            'client_secret' => ['required', 'string'],
            'token' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    protected function validatorEdit(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date', 'date_format:Y-m-d'],
            'commune' => ['required', 'integer', 'exists:communes,id'],
        ]);
    }

    protected function validatorPassword(array $data)
    {
        return Validator::make($data, [
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    protected function register(array $data)
    {
        return FairUser::create([
            'name' => $data['fairuser']['name'],
            'lastname' => $data['fairuser']['lastname'],
            'rut' => $data['fairuser']['rut'],
            'phone' => $data['fairuser']['phone'],
            'email' => $data['fairuser']['email'],
            'password' => Hash::make($data['fairuser']['password']),
            'birthday' => $data['fairuser']['birthday'],
            'commune_id' => $data['fairuser']['commune'],
        ])->assignRole('fairuser');
    }

    protected function checkClient(array $data)
    {
        return Client::where([
            'id' => $data['client_id'],
            'secret' => $data['client_secret'],
        ])->exists();
    }

    protected function editUser(array $data, FairUser $user)
    {
        if ($user->name != $data['name']) {
            $user->name = $data['name'];
        }
        if ($user->lastname != $data['lastname']) {
            $user->lastname = $data['lastname'];
        }
        if ($user->phone != $data['phone']) {
            $user->phone = $data['phone'];
        }
        if ($user->birthday != $data['birthday']) {
            $user->birthday = $data['birthday'];
        }
        if ($user->commune_id != $data['commune']) {
            $user->commune_id = $data['commune'];
        }
        $user->save();
    }

    protected function changePassword(array $data, FairUser $user)
    {
        if (!Hash::check($data['old_password'], $user->password)) {
            return response()->json(
                [
                    'message' => "The given data was invalid.",
                    'errors' => [
                        'old_password' => ["old_password mismatch."],
                    ],
                ],
                422
            );
        }
        if (Hash::check($data['new_password'], $user->password)) {
            return response()->json(
                [
                    'message' => "The given data was invalid.",
                    'errors' => [
                        'new_password' => ["The new password has to be different to an old_password."],
                    ],
                ],
                422
            );
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();
        return response()->json([
            [
                'message' => 'Fair User password is updated successfully',
            ],
            200,
        ]);
    }


    private function newFreshdeskUser(FairUser $user)
    {
        $url = config('freshdesk.url');
        $api_key = config('freshdesk.api_key');
        $route = '/api/v2/contacts';
        $method = 'post';
        $url = "$url/$route";

        $json_data = [
            'name' => "$user->name  $user->lastname",
            'email' => $user->email,
            'mobile' => $user->phone,
            'description' => 'fair user',
            'unique_external_id' => "fair_$user->id"
        ];
        $client = new \GuzzleHttp\Client();

        $promise = null;
        if($method=='post'){
            $promise = $client->post(
                $url,
                [
                    'content-type' => 'application/json',
                    'auth' => [$api_key, 'X'],
                    'json' => $json_data
                ]
            );
        }
    }
}
