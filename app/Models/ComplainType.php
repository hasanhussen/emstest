<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ComplainType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="complain_types";
    protected $fillable = ["type" ];
    
}
