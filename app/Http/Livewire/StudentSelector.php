<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Quiz;
use Auth;
use App\Models\MapUser;
use App\Models\QuizTimer;
use App\Models\StudentQuizChoice;
use App\Models\StudentSelectedForExam;


class StudentSelector extends Component
{
    public $quiz_selected;

    public function render()
    {
        $user_loc = MapUser::where('user_id',Auth::user()->id)->first();
        $quizes = Quiz::where('status',1)->where('location',$user_loc->college)->get();
        $quiz_chosen = StudentQuizChoice::where('user_id',Auth::user()->id)->get();
        $activated = StudentSelectedForExam::where('user_id',Auth::user()->id)->first();
        return view('livewire.student-selector',['quizes'=>$quizes,'quiz_chosen'=>$quiz_chosen,'activated'=>$activated]);
    }

    public function choose()
    {
        //Check if already saved;
        $quiz_chosen = StudentQuizChoice::where('user_id',Auth::user()->id)->where('quiz_id',$this->quiz_selected)->first();
        if($quiz_chosen)
        {
            $this->reset();
            Session()->flash('message','Already there! You can add more!');
        }
        else
        {
            $choo = new StudentQuizChoice;
            $choo->user_id = Auth::user()->id;
            $choo->quiz_id = $this->quiz_selected;
            $choo->save();
            $this->reset();
            Session()->flash('message','Selection Saved! You can add more!');
        }
        
    }
    
    public function remove($quizid)
    {
        $quiz_set = QuizTimer::where('quiz_id',$quizid)->where('user_id',Auth::user()->id)->first();
        if($quiz_set == null)
        {
            $quiz_chosen = StudentQuizChoice::where('user_id',Auth::user()->id)->where('quiz_id',$quizid)->first();
            $quiz_chosen->delete();
            return redirect('home')->with('message','Quiz Removed');
        }
        else
        {
            return redirect('home')->with('message','Quiz Already started! You cannot remove it!');
        }
    }
}
