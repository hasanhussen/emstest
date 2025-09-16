<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;



    protected $table="payments";
    protected $fillable = ["card_id","user_id","owner_name" ,"code","expirationDate","csc" ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user(){


        return $this->belongsTo("App\Models\User",'user_id');

    }
     public function card(){


         return $this->belongsTo("App\Models\CardsType",'card_id');
    }
}
