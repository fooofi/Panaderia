<?php

namespace App\Models;

use App\Notifications\UserResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Traits\HasRoles;
use Browser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'lastname', 'rut', 'organization_id', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $notification = new UserResetPasswordNotification($token);
        $notification->setSo(Browser::platformName());
        $notification->setBrowser(Browser::browserName());
        $notification->setUser($this);
        $this->notify($notification);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function institutionId()
    {
        $pattern = '/^institutions.view.([0-9]+)$/';
        $permission = $this->permissions
            ->filter(function ($permission) use ($pattern) {
                return preg_match($pattern, $permission->name);
            })
            ->first();
        if (!$permission) {
            return null;
        }
        $data = [];
        preg_match($pattern, $permission->name, $data);
        return $data[1];
    }
}
