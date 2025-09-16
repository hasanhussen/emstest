<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cataloge extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="cataloges";
    protected $fillable = ["image" ];
}
