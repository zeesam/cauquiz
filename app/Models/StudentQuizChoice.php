<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use App\Models\Status;
use App\Models\QuizTimer;


class StudentQuizChoice extends Model
{
    use HasFactory;

    public function quiz()
    {
        return $this->hasOne(Quiz::class,'id','quiz_id');
    }

    public function timer()
    {
        return $this->belongsToMany(Quiz::class,'quiz_id');
    }

    public function username()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    
    public function quiztimer()
    {
        return $this->hasMany(QuizTimer::class,'user_id');
    }
    
}
