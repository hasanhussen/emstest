<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="repayments";
    protected $fillable = ["user_id","complain_id" ,"value" ];

    public function complain_user(){

        return $this->belongsTo("App\Models\User",'user_id');

    }


    public function complain_no(){

        return $this->belongsTo("App\Models\Complain",'complain_id');

    }

}
