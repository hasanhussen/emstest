<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpFile extends Model
{
    use HasFactory;
    protected $fillable = [ 'followup_id','file'];
    public function follow_up(){
        return $this->belongsTo(FollowUp::class,'followup_id');
    }
}
