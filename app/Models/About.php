<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'phone', 'email', 'overview','facebook', 'twitter', 'instagram', 'whatsApp', 'telegram','image'];

}
