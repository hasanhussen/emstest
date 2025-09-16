<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="company_types";
    protected $fillable = ["type","image" ];


}
