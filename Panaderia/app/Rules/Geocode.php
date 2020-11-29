<?php

namespace App\Rules;

use App\Models\Commune;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Geocode implements Rule
{
    private $data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
        //
        $commune = Commune::find($this->data['commune']);
        if (!$commune) {
            return false;
        }
        $province = $commune->province;
        $region = $province->region;
        $country = $region->country;
        $response = Http::get(config('app.google_geocode_json_api'), [
            'key' => config('app.google_mix_api_key'),
            'address' => preg_replace('/\s+/', '+', $value),
            'components' =>
                $commune->geocodeComponent() .
                '|' .
                $province->geocodeComponent() .
                '|' .
                $region->geocodeComponent() .
                '|' .
                $country->geocodeComponent(),
        ]);

        if ($response->failed()) {
            return false;
        }

        $response = $response->json();
        return $response['status'] == 'OK';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.geocode');
    }
}
