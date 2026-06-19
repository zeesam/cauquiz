<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ERProject extends Model
{
    use HasFactory;

    protected $table = 'e_r_projects';

    protected $fillable = [
        'user_id',
        'faculty_info_id',
        'project_name',
        'sponsoring_agency',
        'sanctioned_year',
        'duration',
        'status',
        'amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facultyInfo()
    {
        return $this->belongsTo(FacultyInfo::class);
    }
}