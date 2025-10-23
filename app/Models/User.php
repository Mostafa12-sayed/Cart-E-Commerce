<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Notification;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = config('app.frontend_url') . "/reset-password?token=$token&email=" . urlencode($this->email);
//        $this->notify(new ResetPasswordNotification($url));
        $this->notify(new CustomResetPasswordNotification($url));

    }

}
