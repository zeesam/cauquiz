<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuizMap;
use App\Models\MapUser;
use App\Models\User;
use App\Models\Quiz;
use Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->type == 'SU')
        {
            $user = User::where('id',Auth::user()->id)->first();
            $question = Question::orderBy('id','DESC')->paginate(10);
        }
        else
        {
            $user = User::where('id',Auth::user()->id)->first();
            $question = Question::where('added_by',Auth::user()->id)->paginate(10);
        }
        return view('question/view',['question'=>$question]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->type == 'SU')
        {
            $user = User::where('id',Auth::user()->id)->first();
            $quizes = Quiz::all()->unique('quiz_category');
        }
        else
        {
            $user = User::where('id',Auth::user()->id)->first();
            $quizes = Quiz::where('location',$user->userlevel->college)->where('dropdown',NULL)->get();
        }
        //$map = QuizMap::where('category_id',$this->quiz_id)->first();
        return view('question/create',['quizes'=>$quizes]);
    }


    public function createques(Request $request)
    {
        //dd("?");
        $quiz = Quiz::where('id',$request->quiz_id)->first();
        $question = new Question;
        $request->validate([
            'question' => 'required',
            'optiona' => 'required',
            'optionb' => 'required',
            'optionc' => 'required',
            'optiond' => 'required',
            'correct_ans' => 'required',
            'ques_image' => 'nullable|mimes:jpg,png,jpeg|max:100|min:15'
        ]);
        if($quiz->shared_id != null)
        {
            $question->quiz_id = $quiz->shared_id;
        }
        else
        {
            $question->quiz_id = $request->quiz_id;
        }
        $question->question = $request->question;
        $question->optiona = $request->optiona;
        $question->optionb = $request->optionb;
        $question->optionc = $request->optionc;
        $question->optiond = $request->optiond;
        $question->correct_ans = $request->correct_ans;
        $question->added_by = Auth::user()->id;
        $question->location = $quiz->location;
        if($request->ques_image)
        {
            $file = $request->file('ques_image');
            $img_ext = $file->getClientOriginalExtension();
            $img_name = Auth::user()->id.'-'.time().'.'.$img_ext;
            $destination = public_path('question_image');
            $file->move($destination,$img_name);
            $question->quest_img = $img_name;
        }
        $question->save();
        return redirect('question-create')->with('message','Question Inserted!');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->FormValidate($request);
        $question = (new Question)->questionstore($data);
        return redirect('/question/create')->with('message','Question Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        $map_user = MapUser::where('user_id',Auth::user()->id)->first();
        if(Auth::user()->type == 'SU'){
            return view('question/show',['question'=>$question]);
        }
        else{
            if(Auth::user()->id == $question->added_by)
            {
                return view('question/show',['question'=>$question]);
            }
            else
            {
                return back()->with('message', "Unauthorized Access!");
            }   
        
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        $map_user = MapUser::where('user_id',Auth::user()->id)->first();
        if(Auth::user()->type == 'SU'){
            return view('question/edit',['question'=>$question]);
        }
        else{
            if($map_user->college == $question->location && $map_user->user_id == $question->added_by)
            {
                return view('question/edit',['question'=>$question]);
            }
            else
            {
                return back()->with('message', "Unauthorized Access!");
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->FormValidate($request,$id);
        $question = (new Question)->questionupdate($data,$id);
        return redirect('/question-view')->with('message','Question Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        if(Auth::user()->type == 'SU'){
            $ques = Question::find($id);
        }
        else{
            $ques = Question::where('id',$id)->where('added_by',Auth::user()->id)->first();
        }
        if($ques){
            $quiz = Quiz::where('id',optional($ques->quizer)->id)->first();
        }
        else{
            return back()->with('message', 'The question does not belong to your College!');
        }
        if($quiz->status == 1)
        {
            return back()->with('message', 'The question is in an active Quiz, It cannot be deleted!');
        }
        else
        {
            $question->delete();
            return back()->with('message','Question Deleted!');
        }
    }
    public function FormValidate($request)
    {
        return $this->validate($request,[
          'quiz_id' => 'required',
          'question' => 'required|string',
          'optiona' => 'required',
          'optionb' => 'required',
          'optionc' => 'required',
          'optiond' => 'required',
          'correct_ans' => 'required'
        ]);
    }
}
