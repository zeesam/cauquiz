<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use App\Models\TableMap;
use App\Models\User;
use App\Models\StudentQuizChoice;
use App\Models\Quiz;
use App\Models\Migration;
use Illuminate\Support\Facades\DB;

class LiveResultQuiz extends Component
{
    public $quid;
    public $search = "";
    public function render()
    {
        $user = User::where('name','LIKE','%'.$this->search.'%')->where('type','!=','SU')->first();
        $quiz = Quiz::findOrFail($this->quid);
        $students = StudentQuizChoice::where('quiz_id',$this->quid)->select('user_id')->distinct()->get();
        $students_fil = StudentQuizChoice::where('quiz_id',$this->quid)->where('user_id',$user->id)->first();
        $table_map = TableMap::where('quiz_id',$quiz->id)->first();
        $table_name = Migration::where('id',$table_map->table_id)->first();
        $table = substr($table_name->migration,25,-6);
            $data = DB::table($table)
            ->select('user_id')->distinct()->get();
        return view('livewire.live-result-quiz',['students'=>$students, 'students_fil'=>$students_fil,'quiz'=>$quiz,'table'=>$table,'user'=>$user]);
    }
}
