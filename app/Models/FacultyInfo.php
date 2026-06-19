<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyInfo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'name_of_faculty',
        'email',
        'department',
        'college'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function irProjects()
    {
        return $this->hasMany(IRProject::class);
    }

    public function erProjects()
    {
        return $this->hasMany(ERProject::class);
    }

    public function getTotalCreditHoursAttribute()
    {
        return $this->subjects()->sum('total_credit');
    }

    public function getTotalIRPAttribute()
    {
        return $this->irProjects()->sum('amount');
    }

    public function getTotalERPAttribute()
    {
        return $this->erProjects()->sum('amount');
    }

    public function getIRPCountAttribute()
    {
        return $this->irProjects()->count();
    }

    public function getERPCountAttribute()
    {
        return $this->erProjects()->count();
    }
}