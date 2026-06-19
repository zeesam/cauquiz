<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Location;
use App\Models\MapUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Notifications\ApprovalNotification;

class UserController extends Controller
{
    public function create()
    {
        return view('user/create');
    }

    public function insert(Request $request)
    {
        $loc = MapUser::where('user_id',Auth::user()->id)->first();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type' => 'nullable'
        ]);
        if(Auth::user()->type == 'SU')
        {
            $location = $request->location;
        }
        else
        {
            $location = Auth::user()->location;
        }
        $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->type = 'New User';
            $user->location = $location;
            $user->save();

        return back()->with('message','User Created!');
    }

    public function view()
    {
        $users = User::where('id','!=',1)->where('type','Faculty')->get();
        $locations = Location::orderBy('location','ASC')->get();
        return view('user/view',['users'=>$users,'locations'=>$locations]);
    }

    public function mapuser(Request $request, $id)
    {
        $map = MapUser::where('user_id',$id)->first();
        $user = User::where('id',$id)->first();
        if($user->type == 'SU'){
            return back()->with('message',$user->name.' is Super User and cannot be mapped!');
        }
        else{
            if(isset($map))
            {
                return back()->with('message','Already Mapped! You can Transfer User!');
            }
            else
            {
                $mapuser = new MapUser;
                $mapuser->user_id = $id;
                $mapuser->college = $request->location;
                $mapuser->level = $request->level;
                $mapuser->save();
                $notice = [
                    'name' => $user->name
                ];
                $user->notify(new ApprovalNotification($notice));
                if($request->level == 1 || $request->level == 2 || $request->level == 3)
                {
                    $user->type = 'Faculty';
                    $user->save();
                }
                return back()->with('message','Mapped');
            }
        }
    }

    public function usertransfer(Request $request, $id)
    {
        $user = User::where('id',$id)->first();
        $map = MapUser::where('user_id',$id)->first();
        if(isset($map))
        {
            $map->college = $request->location;
            $map->level = $request->level;
            $map->save();
            if($request->level == 1 || $request->level == 2 || $request->level == 3)
            {
                $user->type = 'Faculty';
                $user->save();
            }
            else
            {
                $user->type = 'Student';
                $user->save();
            }
            return back()->with('message','User Transfer Successful!');
        }
        else
        {
            $mapuser = new MapUser;
            $mapuser->user_id = $id;
            $mapuser->college = $request->location;
            $mapuser->level = $request->level;
            $mapuser->save();
            if($request->level == 1 || $request->level == 2 || $request->level == 3)
            {
                $user->type = 'Faculty';
                $user->save();
            }
            else
            {
                $user->type = 'Student';
                $user->save();
            }
            return back()->with('message','Mapped');
        }
    }
}
