<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
use Notifiable;
use HasRoles;
use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


     // type:
     //0: register_agent    1:agent;   2:delegate
     // 3: banned_agent       4 : register_delegate  5:ban_delegate

    // App\Models\User.php
protected $fillable = [
    'name', 'email', 'password', 'role', 'api_token'
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function friend1()
    {
        return $this->hasMany(FriendRequest::class, 'user_id1');
    }

    public function friend2()
    {
        return $this->hasMany(FriendRequest::class, 'user_id2');
    }
    public function chat1()
    {
        return $this->hasMany(Chat::class, 'user_id1');
    }

    public function chat2()
    {
        return $this->hasMany(Chat::class, 'user_id2');
    }
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

}
