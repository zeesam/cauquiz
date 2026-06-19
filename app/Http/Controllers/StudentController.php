<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MapUser;
use App\Models\TableMap;
use App\Models\Migration;
use App\Models\Quiz;
use App\Models\Status;
use App\Models\QuizMap;
use App\Models\Question;
use App\Models\StudentQuizChoice;
use Auth;
use DB;

class StudentController extends Controller
{
    //

    public function quizstart($id)
    {
        $quiz = Quiz::findOrFail($id);
        $choice = StudentQuizChoice::where('user_id',Auth::user()->id)->where('quiz_id',$quiz->id)->first();
        
        if($choice)
        {
            return view('student/quizstart',['quiz'=>$quiz]);
        }
        else
        {
            return redirect('home')->with('message','Unauthtorized Access');
        }
    }
    
    public function studentwise($id)
    {   $status = Status::where('user_id',Auth::user()->id)->where('quiz_id',$id)->first();
        if($status == null)
        {
            return back()->with('message','Quiz is not Completed yet');
        }
        else
        {
            $student = StudentQuizChoice::where('user_id',Auth::user()->id)->where('quiz_id',$id)->first();
            if(!$student)
            {
                return back()->with('message','Unknown Page');
            }
            $table_map = TableMap::where('quiz_id',$student->quiz_id)->first();
            $table_name = Migration::where('id',$table_map->table_id)->first();
            $table = substr($table_name->migration,25,-6);
            $data = DB::table($table)->where('user_id',Auth::user()->id)->get();
            $user = User::where('id',Auth::user()->id)->first();
            return view('student/result',['data'=>$data,'user'=>$user,'table'=>$table,'table_map'=>$table_map,'status'=>$status]);
        }
    }
}
