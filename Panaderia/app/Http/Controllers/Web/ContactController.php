<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactStatus;
use App\Models\ContactType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;

class ContactController extends Controller
{
    //
    public function index()
    {
        return view('executive.contacts');
    }

    public function contacts()
    {
        $user = auth()->user();
        $type = ContactType::where('name', 'Chat')->first();
        $status = ContactStatus::where('name', 'Waiting')->first();
        $contacts = Contact::where([
            'organization_id' => $user->organization_id,
            'contact_status_id' => $status->id,
        ])
            ->orderBy('created_at', 'asc')
            ->get()
            ->filter(function ($contact) use ($user) {
                return $contact->institutionId() == $user->institutionId();
            })
            ->take(20)
            ->map(function ($contact) {
                $fairuser = $contact->fair_user;
                $survey = $fairuser->fair_survey;
                return (object) [
                    'id' => $contact->id,
                    'name' => $fairuser->name,
                    'origin' => $contact->source_model->name,
                    'type' => $contact->contact_type->name,
                    'career' => $survey->career,
                    'received' => $contact->created_at,
                ];
            })
            ->flatten();
        return response()->json([
            'contacts' => $contacts,
        ]);
    }
}
