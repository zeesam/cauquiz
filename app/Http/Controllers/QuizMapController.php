<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use App\Models\QuizMap;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Location;
use Auth;

class QuizMapController extends Controller
{
    public function map()
    {
        $location = Location::orderBy('location','ASC')->get();
        if(Auth::user()->type == 'SU')
        {
            $maps = QuizMap::orderBy('id','DESC')->paginate(5);
            $user = User::where('id',Auth::user()->id)->first();
            $quizes = Quiz::all();
        }
        else
        {
            $user = User::where('id',Auth::user()->id)->first();
            $maps = QuizMap::orderBy('id','DESC')->where('location',$user->userlevel->college)->paginate(5);
            $quizes = Quiz::where('location',$user->userlevel->college)->get();
        }
        return view('map/quizmap',['maps'=>$maps,'quizes'=>$quizes,'user'=>$user,'location'=>$location]);
    }

    public function store(Request $request)
    {
        $map = QuizMap::where('category_id',$request->quiz_id)->first();
        if($map)
        {
            return back()->with('message','Already Mapped');
        }
        else
        {
            $data = $this->validate($request,[
                'quiz_id' => 'required',
                'quiz_type' => 'required'
            ]);
            $store = new QuizMap;
            $user = User::where('id',Auth::user()->id)->first();
            $store->category_id = $request->quiz_id;
            if(Auth::user()->type == 'SU'){
                $store->location = $request->location;
            }
            else{
                $store->location = $user->userlevel->college;
            }
            $store->quiz_type = $request->quiz_type;
            if(Auth::user()->type == 'SU')
            {
                $loc_up = Quiz::where('id',$request->quiz_id)->first();
                $loc_up->location = $request->location;
                $loc_up->save();
            }
            $store->save();
            return back()->with('message','Mapped');
        }
    }

    public function pub($id)
    {
        $map = QuizMap::findOrFail($id);
        if($map->category->shared_id == null)
        {
            $question_count = count(Question::where('quiz_id',$map->category_id)->get());
        }
        else
        {
            $question_count = count(Question::where('quiz_id',$map->category->shared_id)->get());
        }
        if($question_count == 0)
        {
            return back()->with('message','There is no Question added. You cannot publish it!');
        }
        else
        {
            $update = Quiz::findOrFail($map->category_id);
            $update->status = 1;
            $update->save();
            return back()->with('message',$update->quiz_category. ' Is Live Now!');
        }
        
    }
    public function unpub($id)
    {
        $map = QuizMap::findOrFail($id);
            $update = Quiz::findOrFail($map->category_id);
            $update->status = null;
            $update->save();
            return back()->with('message',$update->quiz_category. ' Is Unpublished Now!');
    }
    
    public function dropdownrem($id)
    {
        $user = User::where('id',Auth::user()->id)->first();
        if(Auth::user()->type == 'SU'){
            $update = Quiz::where('id',$id)->first();
        }
        else{
            $update = Quiz::where('id',$id)->where('location',$user->userlevel->college)->first();
        }
        if($update){
            $update->dropdown = 1;
            $update->save();
            return back()->with('message','Removed from Dropdown');
        }
        else{
            return back()->with('message','Unauthorized Access');
        }
    }
    
    public function dropdownadd($id)
    {
        $user = User::where('id',Auth::user()->id)->first();
        if(Auth::user()->type == 'SU'){
            $update = Quiz::where('id',$id)->first();
        }
        else{
            $update = Quiz::where('id',$id)->where('location',$user->userlevel->college)->first();
        }
        if($update){
            $update->dropdown = NULL;
            $update->save();
            return back()->with('message','Added to Dropdown');
        }
        else{
            return back()->with('message','Unauthorized Access');
        }
    }
}
