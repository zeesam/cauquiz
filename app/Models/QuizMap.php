<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use App\Models\TableMap;


class QuizMap extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->hasOne(Quiz::class,'id','category_id');
    }

    public function tablemap()
    {
        return $this->hasOne(TableMap::class,'quiz_id','category_id');
    }
}
