<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\TableMap;
use App\Models\User;
use App\Models\StudentQuizChoice;
use App\Models\Quiz;
use App\Models\Migration;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function view()
    {
        $table = TableMap::paginate(20);
        $current_user = User::where('id',Auth::user()->id)->first();
        return view('result/view',['table'=>$table,'current_user'=>$current_user]);
    }

    public function quizwise($id)
    {
        $quiz = Quiz::findOrFail($id);
        $table_map = TableMap::where('quiz_id',$quiz->id)->first();
        $table_name = Migration::where('id',$table_map->table_id)->first();
        $table = substr($table_name->migration,25,-6);
        $data = DB::table($table)->select('user_id')->distinct()->get();
        return view('result/quizwise',['table_map'=>$table_map,'quiz'=>$quiz]);
    }

    public function studentwise(Request $request, $id)
    {
        $student = StudentQuizChoice::where('user_id',$id)->where('quiz_id',$request->quiz_id)->first();
        $table_map = TableMap::where('quiz_id',$student->quiz_id)->first();
        $table_name = Migration::where('id',$table_map->table_id)->first();
        $table = substr($table_name->migration,25,-6);
        $data = DB::table($table)->where('user_id',$id)->get();
        $user = User::where('id',$id)->first();
        return view('result/studentwise',['data'=>$data,'user'=>$user,'table'=>$table,'table_map'=>$table_map]);
    }
    
}
