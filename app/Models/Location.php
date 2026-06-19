<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    
    public function questioncreated()
    {
        return $this->hasMany(Question::class,'location','id');
    }
    public function quizcreated()
    {
        return $this->hasMany(Quiz::class,'location','id');
    }
    public function usermap()
    {
        return $this->hasMany(MapUser::class,'college','id')->where('level','!=','4');
    }
    public function usermapst()
    {
        return $this->hasMany(MapUser::class,'college','id')->where('level','4');
    }
}
