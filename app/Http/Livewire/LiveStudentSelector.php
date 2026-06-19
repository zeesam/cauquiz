<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\User;
use App\Models\MapUser;
use App\Models\StudentSelectedForExam;
use Illuminate\Support\Facades\DB;
use Auth;

class LiveStudentSelector extends Component
{
    public $search = '';
    public $quiz_id;
    
    public function mount(){
        $quiz_id = $this->quiz_id;
    }
    public function render()
    {
        $admin_id = Auth::user()->id;
        $admin_loc = MapUser::where('user_id',$admin_id)->first();
        //$users = MapUser::where('level',4)->where('college',$admin_loc->college)->get();
        $selected_students = StudentSelectedForExam::where('quiz_id',$this->quiz_id)->get();
        $users = DB::table('users')->select('users.name as user_name','users.id as id','map_users.college as user_loc')
                ->join('map_users', 'users.id', '=', 'map_users.user_id')
                //->join('student_selected_for_exams', 'map_users.user_id', '!=', 'student_selected_for_exams.user_id')
                ->where('map_users.college','=',$admin_loc->college)
                ->where('map_users.level','=',4)
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->get();
        //dd($users);
        return view('livewire.live-student-selector',[
            'users'=>$users,
            'selected_students'=>$selected_students,
        ]);
    }
    
    public function student_checked($data)
    {
        //check if exist
        $selected_students = StudentSelectedForExam::where('user_id',$data)->where('quiz_id',$this->quiz_id)->first();
        if($selected_students){
            $this->reset();
            Session()->flash('message','Already Selected');
        }
        else{
            $user_loc = MapUser::where('user_id',Auth::user()->id)->first();
            $add_student = new StudentSelectedForExam;
            $add_student->user_id = $data;
            $add_student->quiz_id = $this->quiz_id;
            $add_student->location = $user_loc->college;
            $add_student->added_by = Auth::user()->id;
            $add_student->save();
            //$this->reset();
        }
        Session()->flash('quiz_id',$this->quiz_id);
    }
    public function student_rem($data)
    {
        $selected_student= StudentSelectedForExam::where('user_id',$data)->where('quiz_id',$this->quiz_id)->first();
        $selected_student->delete();
        Session()->flash('message','Removed');
        Session()->flash('quiz_id',$this->quiz_id);
    }
}
