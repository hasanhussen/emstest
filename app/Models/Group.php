<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [ 'name'];
    public function doctor(){
        return $this->hasMany(User::class,'group_id');
    }
    public function shift()
    {
        return $this->hasMany(Shift::class,'group_id');
    }
}
