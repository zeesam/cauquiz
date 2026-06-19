<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuizMap;
use App\Models\Location;

class Quiz extends Model
{
    use HasFactory;

    public function loc()
    {
        return $this->hasOne(Location::class,'id','location');
    }
    public function map()
    {
        return $this->hasOne(QuizMap::class,'category_id','id');
    }
    public function questioncreatedx()
    {
        return $this->hasMany(Question::class,'quiz_id','id');
    }
}
