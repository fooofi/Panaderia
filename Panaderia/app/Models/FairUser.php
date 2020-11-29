<?php

namespace App\Models;

use App\Mail\FairUserConfirmMail;
use App\Mail\FairUserResetPasswordMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use League\OAuth2\Server\Exception\OAuthServerException;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Browser;
use Throwable;

class FairUser extends Authenticable
{
    use HasFactory;
    use HasApiTokens;
    use HasRoles;

    protected $fillable = [
        'name',
        'lastname',
        'rut',
        'phone',
        'email',
        'password',
        'birthday',
        'commune_id',
        'email_verified_at',
    ];

    protected $hidden = ['password'];

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param  string  $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        $validate_password = Hash::check($password, $this->password);

        if (!$this->hasVerifiedEmail() && $validate_password) {
            throw OAuthServerException::accessDenied('The account is not verified');
        }

        return $validate_password;
    }

    public function markEmailAsVerified()
    {
        return $this->email_verified_at = now();
    }

    public function hasVerifiedEmail()
    {
        return $this->email_verified_at != null ? true : false;
    }

    /**
     * Retrieve a New Email for Validate User email
     *
     * @return FairUserConfirmMail
     */
    public function getEmailForVerification()
    {
        $token = $this->genToken();
        if ($this->fair_user_email_verification == null) {
            $this->fair_user_email_verification()->create([
                'token' => $token,
            ]);
        } else {
            $this->fair_user_email_verification->token = $token;
            $this->fair_user_email_verification->save();
        }
        $this->refresh();

        return new FairUserConfirmMail($this);
    }

    /**
     * Retrieve a New Email for reset user password
     *
     * @return FairUserResetPasswordMail
     */
    public function getEmailForPasswordReset()
    {
        $ip = '';

        try {
            $ip = request()->ip();
        } catch (Throwable $e) {
            $ip = '';
        }

        $token = $this->genToken();
        if ($this->fair_user_reset_password == null) {
            $this->fair_user_reset_password()->create([
                'token' => $token,
                'so' => Browser::platformName(),
                'ip' => $ip,
                'browser' => Browser::browserName(),
            ]);
        } else {
            $this->fair_user_reset_password->token = $token;
            $this->fair_user_reset_password->save();
        }
        $this->refresh();

        return new FairUserResetPasswordMail($this);
    }

    public function fair_survey()
    {
        return $this->hasOne(FairSurvey::class);
    }

    public function fair_user_email_verification()
    {
        return $this->hasOne(FairUserEmailVerification::class);
    }

    public function fair_user_reset_password()
    {
        return $this->hasOne(FairUserResetPassword::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Retrieve a New Token
     *
     * @return string
     */
    private function genToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }
}
