<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserStars extends Model
{
    use HasFactory;
    use SoftDeletes;

    // user1_id  client
    //user2_id   delegate 
    protected $fillable = [
        "user1_id",
        "user2_id",
        "stars"
    ];

  
    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
