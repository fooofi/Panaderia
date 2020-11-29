<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactStatus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\RestException;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Client;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;

class ChatController extends Controller
{
    private $twilio_account_sid;
    private $twilio_api_key;
    private $twilio_api_secret;
    private $twilio_chat_sid;

    public function __construct()
    {
        $this->twilio_account_sid = config('services.twilio.sid');
        $this->twilio_api_key = config('services.twilio.key');
        $this->twilio_api_secret = config('services.twilio.secret');
        $this->twilio_chat_sid = config('services.twilio.grant');
    }

    public function index()
    {
        $token = new AccessToken(
            $this->twilio_account_sid,
            $this->twilio_api_key,
            $this->twilio_api_secret,
            3600,
            auth()->user()->id
        );

        $chat_grant = new ChatGrant();
        $chat_grant->setServiceSid($this->twilio_chat_sid);

        $token->addGrant($chat_grant);

        return view('executive.messages', ['token' => $token->toJWT()]);
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), ['contact' => ['required', 'integer', 'exists:contacts,id']])->validate();
        $user = auth()->user();
        $fail_action = redirect()
            ->route('executive.contacts')
            ->with('error', 'El usuario ya fue contactado');

        DB::beginTransaction();
        $contact = Contact::lockForUpdate()->find($request->contact);

        if ($contact->contact_status->name != 'Waiting' || $contact->contact_type->name != 'Chat') {
            DB::rollBack();
            return $fail_action;
        }

        if (
            $contact->organization_id != $user->organization_id ||
            $contact->institutionId() != $user->institutionId()
        ) {
            DB::rollBack();
            return $fail_action;
        }

        if ($contact->user_id) {
            DB::rollBack();
            return $fail_action;
        }

        $contact->user_id = $user->id;
        $assigned = $contact->save();

        if ($assigned) {
            $contact->channel = $this->createChannel($contact);
            $contact->contact_status_id = ContactStatus::where('name', 'In Progress')->first()->id;
            $contact->save();
            DB::commit();
            return redirect()->route('executive.messages');
        } else {
            DB::rollBack();
            return $fail_action;
        }
    }

    protected function createChannel($contact)
    {
        $user = $contact->user;
        $fairuser = $contact->fair_user;

        $client = new Client($this->twilio_api_key, $this->twilio_api_secret);
        $twilio_user = $this->getTwilioUser($client, [
            'identity' => $user->id,
            'name' => $user->name . ' ' . $user->lastname,
        ]);
        $twilio_fairuser = $this->getTwilioUser($client, [
            'identity' => $fairuser->email,
            'name' => $fairuser->name . ' ' . $fairuser->lastname,
        ]);
        try {
            $channel = $client->chat->v2->services($this->twilio_chat_sid)->channels->create([
                'uniqueName' => $twilio_fairuser->identity . '-' . $twilio_user->identity,
                'type' => 'private',
            ]);
            $channel->members->create($twilio_user->identity, ['lastConsumedMessageIndex' => 0]);
            $channel->members->create($twilio_fairuser->identity, ['lastConsumedMessageIndex' => 0]);
            return $channel->uniqueName;
        } catch (RestException $e) {
            Log::error($e);
        }
    }

    protected function getTwilioUser(Client $client, array $data)
    {
        try {
            $user = $client->chat->v2
                ->services($this->twilio_chat_sid)
                ->users($data['identity'])
                ->fetch();
        } catch (RestException $e) {
            $user = $client->chat->v2
                ->services($this->twilio_chat_sid)
                ->users->create($data['identity'], ['friendlyName' => $data['name']]);
        }

        return $user;
    }
}
