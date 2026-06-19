<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\MapUser;
use App\Models\Quiz;
use App\Models\Question;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userlevel()
    {
        return $this->hasOne(MapUser::class,'user_id','id');
    }
    
    public function quizcreated()
    {
        return $this->hasMany(Quiz::class,'added_by','id')->where('shared_id',null);
    }
    
    public function questioncreated()
    {
        return $this->hasMany(Question::class,'added_by','id');
    }
    
    public function mapped(){
       return $this->hasOne(MapUser::class,'user_id','id');
    }
    
    public function loc(){
        return $this->hasOne(Location::class,'id','location');
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

    public function userMap()
    {
        return $this->hasOne(MapUser::class);
    }
}
