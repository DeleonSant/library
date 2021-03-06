<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public $guarded = [];
    
    protected $dates = ['dob'];

    // public function setDobAttribute($dob)
    // {
    //     $this->attributes['dob'] = Carbon::parse($dob);
    // }
}
