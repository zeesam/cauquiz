<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizMap;
use Auth;
use App\Models\User;
use Livewire\WithFileUploads;

class LiveQuestion extends Component
{
    use WithFileUploads;
    
    public $ques_image;
    
    public $quiz_id;
    public $question;
    public $correct_ans;
    public $optiona;
    public $optionb;
    public $optionc;
    public $optiond;
    public $added_by;
    public $location;

    public function mount()
    {
        $this->quiz_id = 1;
        $user = User::where('id',Auth::user()->id)->first();
        $this->location = optional($user->userlevel)->college;
        //$this->added_by = Auth::user()->id;
    }
    public function render()
    {
        if(Auth::user()->type == 'SU')
        {
            $user = User::where('id',Auth::user()->id)->first();
            $quizes = Quiz::all();
        }
        else
        {
            $user = User::where('id',Auth::user()->id)->first();
            $quizes = Quiz::where('location',$user->userlevel->college)->get();
        }
        $map = QuizMap::where('category_id',$this->quiz_id)->first();
        return view('livewire.live-question',['quizes'=>$quizes,'map'=>$map]);
    }

    public function create()
    {
        //dd("?");
        $quiz = Quiz::where('id',$this->quiz_id)->first();
        $question = new Question;
        $question->quiz_id = $this->quiz_id;
        $question->question = $this->question;
        $question->optiona = $this->optiona;
        $question->optionb = $this->optionb;
        $question->optionc = $this->optionc;
        $question->optiond = $this->optiond;
        $question->correct_ans = $this->correct_ans;
        $question->added_by = Auth::user()->id;
        $question->location = $quiz->location;
        if(!empty($this->ques_image))
        {
            $img_ext = $this->ques_image->getClientOriginalExtension();
            $img_name = Auth::user()->id.'-'.time().'.'.$img_ext;
            $this->ques_image->storeAs('public',$img_name);
            $question->quest_img = $img_name;
        }
        $question->save();
        $this->reset();
        return redirect('question-create')->with('message','Question Inserted!');
    }
    
}
