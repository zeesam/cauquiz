<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\QuizMap;
use App\Models\MapUser;
use App\Models\Quiz;

class StudentSelectorController extends Controller
{
    public function selector(){
        return view('under-const');
    }
    public function selection(){
        $user_loc = MapUser::where('user_id',Auth::user()->id)->first();
        if(isset($user_loc->college)){
            $table = QuizMap::where('location',$user_loc->college)->get();
            return view('selector/selection-page',[
                'table'=>$table,    
            ]);
        }
        else{
            return back()->with('message','No College Allocated!');
        }
    }
    public function selectordemo(){
        return view('selector/selector');
    }
    
    public function preselectstudent($quiz_id){
        //Checker
        $my_quiz = Quiz::where('id',$quiz_id)->where('added_by',Auth::user()->id)->first();
        if(!$my_quiz){
            return back()->with('message','Error Encountered');
        }
        else{
            return redirect('student-selector-demo')->with(['quiz_id'=>$quiz_id,'my_quiz'=>$my_quiz]);
        }
    }
}
