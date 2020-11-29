<?php

namespace App\Rules;

use App\Models\Contact;
use App\Models\FairUser;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Contacted implements Rule
{
    private $data;
    private $user;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $data, FairUser $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $contacts = Contact::where('fair_user_id', $this->user->id)
            ->get()
            ->filter(function ($contact) use ($value) {
                if (collect(['institution', 'campus', 'career'])->contains($this->data['from'])) {
                    $model = 'App\\Models\\' . Str::title($this->data['from']);
                    $institution_id = $model::find($value)->institution_id;
                    if ($this->data['from'] == 'institution') {
                        $institution_id = $model::find($value)->id;
                    }
                    return $contact->institutionId() == $institution_id &&
                        $contact->contact_type_id == $this->data['type'];
                }
                return true;
            });
        return $contacts->isEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.unique');
    }
}
