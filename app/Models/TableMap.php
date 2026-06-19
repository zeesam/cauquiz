<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Migration;
use App\Models\Quiz;
use App\Models\User;


class TableMap extends Model
{
    use HasFactory;

    public function tablename()
    {
        return $this->hasOne(Migration::class,'id','table_id');
    }

    public function quizloc()
    {
        return $this->hasOne(Quiz::class,'id','quiz_id');
    }
    
    public function user()
    {
        return $this->hasOne(User::class,'id','mapped_by');
    }
}
