<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Location;

class MapUser extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function loc()
    {
        return $this->hasOne(Location::class,'id','college');
    }
}
