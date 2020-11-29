<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class Rut implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $value = explode('-', Str::lower($value));
        $body = $value[0];
        $dv = $value[1];

        return $this->checkRut($body, $dv);
    }

    protected function checkRut($body, $dv)
    {
        if (strlen($body) < 7) {
            return false;
        }
        $sum = 0;
        $mul = 2;

        for ($i = 1; $i <= strlen($body); $i++) {
            $sum += $mul * $body[strlen($body) - $i];
            $mul++;
            if ($mul == 8) {
                $mul = 2;
            }
        }

        $expectedDv = 11 - ($sum % 11);
        $dv = $dv == 'k' ? 10 : $dv;
        $dv = $dv == '0' ? 11 : $dv;
        return $dv == $expectedDv;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.rut');
    }
}
