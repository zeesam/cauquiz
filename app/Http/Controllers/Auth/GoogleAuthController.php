<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Auth;

class GoogleAuthController extends Controller
{
 
    public function googlelogin()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function googlecallback()
    {
        try{
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email',$user->email)->first();
            if($finduser)
            {
                Auth::login($finduser);
                return redirect('home');
            }
            else
            {
                /*
                $new_user = new User;
                $new_user->name = $user->name;
                $new_user->email = $user->email;
                $new_user->password = Hash::make('cauimphal2023');
                $new_user->type = 'New User';
                $new_user->save();
                Auth::login($new_user);
                return redirect('home');
                */
                return back()->with('message', "Your account hasn't registered yet");
            }
        }
        catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
