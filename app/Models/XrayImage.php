<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XrayImage extends Model
{
    use HasFactory;
    protected $fillable = ['image','image_id' ];
    public function Xray()
    {
        return $this->belongsTo(Xray::class,'image_id');
    }
}
