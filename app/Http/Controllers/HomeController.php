<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quiz;
use App\Models\MapUser;
use App\Models\StudentQuizChoice;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $admins = User::where('type','Faculty')->where('id',Auth::user()->id)->first();
        if($admins || Auth::user()->type == 'SU')
        {
            return view('home',['admins'=>$admins]);
        }
        else
        {
            $user_loc = MapUser::where('level',4)->where('user_id',Auth::user()->id)->first();
            if($user_loc)
            {
                //$quizes = Quiz::where('status',1)->where('location',$user_loc->college)->get();
                $quiz_chosen = StudentQuizChoice::where('user_id',Auth::user()->id)->get();
                return view('student/home',['user_loc'=>$user_loc,'quiz_chosen'=>$quiz_chosen]);
            }
            else
            {
                $admins = User::where('location', Auth::user()->location)
                ->whereHas('userMap', function ($query) {
                    $query->where('level', 1)
                        ->where('college', Auth::user()->location);
                })
                ->get();
                return view('student/pending',compact('admins'));
            }
        }
    }
    
    public function changelocation(Request $request){
        $user = User::findorFail(Auth::user()->id);
        $user->location = $request->location;
        $user->save();
        return back()->with('message','Location is updated!');
    }
    
    public function version($id)
    {
        return view('versions',['id'=>$id]);
    }
}
