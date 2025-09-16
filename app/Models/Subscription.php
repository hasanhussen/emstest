<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['name','image','price'];

    public function Subscription()
    {
        return $this->hasMany(UserSubscription::class, 'subscription_id');
    }

}
