<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TableMap;
use App\Models\Quiz;
use App\Models\User;

class Migration extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'migration',
        'batch'
    ];

    public function tablemap()
    {
        return $this->hasOne(TableMap::class,'table_id','id');
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
