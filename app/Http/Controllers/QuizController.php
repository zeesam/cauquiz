<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizMap;
use App\Models\Question;
use Auth;
use App\Models\User;
use App\Models\MapUser;
use App\Models\Location;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $location = Location::orderBy('location','ASC')->get();
        if(Auth::user()->type == 'SU')
        {
            $user = User::where('id',Auth::user()->id)->first();
            $quiz = Quiz::orderBy('id','DESC')->distinct('quiz_category')->paginate(10);
        }
        else
        {
            $user = User::where('id',Auth::user()->id)->first();
            $quiz = Quiz::orderBy('id','DESC')->where('location',$user->userlevel->college)->paginate(10);
        }
        return view('/quiz/view',['quiz'=>$quiz,'location'=>$location]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quiz/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check if already exist
        $data = Quiz::where('quiz_category', $request->quiz_category)->first();
        if($data)
        {
            return redirect('/quiz-create')->with('message','Quiz Topic/Category already exist');
        }
        else
        {
            $user = User::findOrFail(Auth::user()->id);
            $data = $this->ValidateForm($request);
            $quiz = new Quiz;
            $quiz->quiz_category = $request->quiz_category;
            $quiz->quiz_description = $request->quiz_description;
            $quiz->duration = $request->duration;
            $quiz->added_by = Auth::user()->id;
            if(Auth::user()->type == 'SU')
            {
                $quiz->location = 14;
            }
            else
            {
                $quiz->location = $user->userlevel->college;
            }
            $quiz->save();
            return redirect('/quiz-create')->with('message','Quiz Created!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quiz = Quiz::find($id);
        $user = User::where('id',Auth::user()->id)->first();
        $map_user = MapUser::where('user_id',Auth::user()->id)->first();
        $location = Location::orderBy('location','ASC')->get();
        if(Auth::user()->type == 'SU')
        {
            if($quiz->shared_id == null)
            {
                $questions = Question::where('quiz_id',$quiz->id)->paginate(5);
                $questions_p = Question::where('quiz_id',$quiz->id)->get();
            }
            else
            {
                $questions = Question::where('quiz_id',$quiz->shared_id)->paginate(5);
                $questions_p = Question::where('quiz_id',$quiz->shared_id)->get();
            }
        }
        else
        {
            if($quiz->shared_id == null)
            {
                $questions = Question::where('quiz_id',$quiz->id)->where('location',$map_user->college)->paginate(5);
                $questions_p = Question::where('quiz_id',$quiz->id)->where('location',$map_user->college)->get();
            }
            else
            {
                $questions = Question::where('quiz_id',$quiz->shared_id)->paginate(5);
                $questions_p = Question::where('quiz_id',$quiz->shared_id)->get();
            }
        }
        return view('/quiz/show',[
            'quiz'=>$quiz,
            'questions'=>$questions,
            'location'=>$location,
            'questions_p'=>$questions_p
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::find($id);
        if($quiz->added_by == Auth::user()->id)
        {
            return view('quiz/edit',['quiz'=>$quiz]);
        }
        else{
            return back()->with('message',"You cannot edit others's quiz!");
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
        $user = User::findOrFail(Auth::user()->id);
        $data = $this->ValidateForm($request,$id);
        $quiz = Quiz::findOrFail($id);
        $quiz->quiz_category = $request->quiz_category;
        $quiz->quiz_description = $request->quiz_description;
        $quiz->duration = $request->duration;
        $quiz->save();
        return redirect('/quiz-view')->with('message','Quiz Updated! ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        if($quiz->added_by == Auth::user()->id)
        {
            $quizmap = QuizMap::where('category_id',$id)->first();
            if($quizmap)
            {
                return redirect('/quiz-view')->with('message','Quiz Already Mapped! Cannot be Deleted');
            }
            else
            {
                $quiz->delete();
                return redirect('/quiz-view')->with('message','Quiz Deleted!');
            }
        }
        else{
            return back()->with('message',"You cannot delete others's quiz!");
        }
    }
    
    public function share(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quizmap = QuizMap::where('category_id',$id)->first();
        if($quizmap)
        {
            if($request->location == -1)
            {
                return back()->with('message','Select a value!');
            }
            else
            {
                if($loc_up = Quiz::where('quiz_category',$quiz->quiz_category)->where('location',$request->location)->first())
                {
                    return back()->with('message','Already Mapped with the Location!');
                }
                else
                {
                    if($quiz->shared_id == null)
                    {
                        $quiz->shared_id = $quiz->id;
                    }
                    $share = new Quiz;
                    $share->shared_id = $quiz->shared_id;
                    $share->quiz_category = $quiz->quiz_category;
                    $share->quiz_description = $quiz->quiz_description;
                    $share->duration = $quiz->duration;
                    $share->added_by = $quiz->added_by;
                    $share->location = $request->location;
                    $share->save();
                    return redirect('/quiz-view')->with('message','Quiz Shared');
                }
            }
        }
        else
        {
            return redirect('/quiz-view')->with('message','Quiz Not mapped yet!');
        }
        
    }
    
    public function remshare($id)
    {
        return back()->with('message','Removal is not allowed as of now! Contact HQ');
    }

    public function ValidateForm($request)
    {
        return $this->validate($request,[
          'quiz_category' => 'required|string',
          'quiz_description' => 'required|min:10|max:500',
          'duration' => 'required|integer'
        ]);
    }
    
    public function quizsearchresult(Request $request){
        return $this->validate($request,[
          'quiz_name' => 'required|string',
        ]);
    }
}
