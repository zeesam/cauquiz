<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;
use Auth;
use Livewire\Component;
use App\Models\User;
use App\Models\MapUser;
use App\Models\Quiz;
use App\Models\QuizMap;
use App\Models\Question;
use App\Models\QuizTimer;
use App\Models\Status;
use App\Models\TableMap;
use Livewire\WithPagination;
use App\Models\StudentQuizChoice;


class LiveStudentQuestion extends Component
{
    use WithPagination;
    public $quiz_id;
    public $stid;
    public $correct_ans;
    public $pagenumber;
    
    public function mount()
    {
        $this->correct_ans = false;
        //$this->quiz_id = $quiz->id;
        
    }
    public function render()
    {
        $status = Status::where('user_id',Auth::user()->id)->where('quiz_id',$this->stid)->first();
        $quiz_timer = QuizTimer::where('user_id',Auth::user()->id)->where('quiz_id',$this->stid)->first();
        $quiz = Quiz::where('id',$this->stid)->first();
        $table_map = TableMap::where('quiz_id',$this->stid)->first();
        $table = substr(optional($table_map->tablename)->migration,25,-6);
        $questions = DB::table($table)->where('quiz_id',$this->stid)->where('user_id',Auth::user()->id)->paginate(1);
        $all_ques = DB::table($table)->where('quiz_id',$this->stid)->where('user_id',Auth::user()->id)->get();
        if($quiz->shared_id == null)
        {
            $org_questions = Question::inRandomOrder()->where('quiz_id',$this->stid)->get();
        }
        else
        {
            $org_questions = Question::inRandomOrder()->where('quiz_id',$quiz->shared_id)->get();
        }
        $choice = StudentQuizChoice::where('quiz_id',$this->stid)->first();
        //$choice2 = StudentQuizChoice::where('quiz_id',$page_no2)->first();
       // dd($page_no2);
        date_default_timezone_set("Asia/Calcutta");
        if($quiz_timer != null)
        {
            $end_time = date('Y-m-d H:i:s',strtotime($quiz_timer->date_time));
            $current_time = date('Y-m-d H:i:s');
            if($status || $current_time > $end_time)
            {
                session()->flash('message', 'Exam Time is over');
                return view('livewire.endofexam');
                //return redirect('home')->with('message','Exam Time is over');
            }
        }
        if($choice)
        {
            if(DB::table($table)->where('user_id',Auth::user()->id)->first() != null)
            {
            
            }
            else
            {
                $quiz = Quiz::where('id',$this->stid)->first();
                date_default_timezone_set("Asia/Calcutta");
                $today = date('Y-m-d H:i:s');
                $currentDate = strtotime($today);
                $futureDate = $currentDate+(60*$quiz->duration);
                $end_time = date("Y-m-d H:i:s", $futureDate);
                $quiz_timer = new QuizTimer;
                $quiz_timer->user_id = Auth::user()->id;
                $quiz_timer->quiz_id = $this->stid;
                $quiz_timer->date_time = $end_time;
                $quiz_timer->save();
                foreach($org_questions as $key=>$ques)
                {
                    //$i = 0;
                    DB::table($table)->insert([
                        'quiz_id' => $this->stid,
                        'quest_no' => $key+1,
                        'question' => $ques->question,
                        'quest_img' => $ques->quest_img,
                        'optiona' => $ques->optiona,
                        'optionb' => $ques->optionb,
                        'optionc' => $ques->optionc,
                        'optiond' => $ques->optiond,
                        'correct_ans' => $ques->correct_ans,
                        'user_id' => Auth::user()->id,
                    ]);
                }
            }
            return view('livewire.live-student-question',['questions'=>$questions,'all_ques'=>$all_ques,'quiz_timer'=>$quiz_timer]);
        }
        else
        {
            Session()->flash('message','Unauthorized Access!');
        }
        
    }

    public function answer($new_id)
    {
        if($this->correct_ans != false)
        {
            $table_map = TableMap::where('quiz_id',$this->stid)->first();
            $table = substr(optional($table_map->tablename)->migration,25,-6);
            $ins = DB::table($table)->where('id',$new_id)->update(['user_ans'=>$this->correct_ans]);
            Session()->flash('message','Record Saved!');
            
        }
        else
        {
            Session()->flash('message','No answer selected!');
        }
    }
    
    public function final_sub()
    {
        $stat = new Status;
        $stat->status = 1;
        $stat->quiz_id = $this->stid;
        $stat->user_id = Auth::user()->id;
        $stat->save();
        return redirect('home')->with('message','Quiz is now completed for you!');
    }
}
