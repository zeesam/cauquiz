<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'faculty_info_id',
        'subject_name',
        'theory_credit',
        'practical_credit',
        'total_credit'
    ];

    protected $casts = [
        'theory_credit' => 'decimal:1',
        'practical_credit' => 'decimal:1',
        'total_credit' => 'decimal:1'
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