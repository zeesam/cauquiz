<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
      'quiz_id',
      'question',
      'optiona',
      'optionb',
      'optionc',
      'optiond',
      'correct_ans'
    ];
    public function questionstore($data)
    {
      return Question::create($data);
    }
    public function questionupdate($data,$id)
    {
      return Question::find($id)->update($data);
    }
    public function quizer()
    {
      return $this->hasOne('App\Models\Quiz','id','quiz_id');
    }
    public function quizcreated()
    {
        return $this->hasMany(Quiz::class,'location','location');
    }
    
    public function user()
    {
      return $this->hasOne('App\Models\User','id','added_by');
    }
}
