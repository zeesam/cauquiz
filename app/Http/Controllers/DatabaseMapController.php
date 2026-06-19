<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use App\Models\QuizMap;
use App\Models\TableMap;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Location;
use App\Models\Migration;
use App\Models\Otp;
use Auth;
use App\Notifications\OtpNotification;

class DatabaseMapController extends Controller
{
    public function map()
    {
        $location = Location::orderBy('location','ASC')->get();
        $table_map = TableMap::pluck('table_id')->all();
        $tables = Migration::where('batch',10)->whereNotIn('id',$table_map)->get();
        //$current_user = User::where('id',Auth::user()->id)->first();
        if(Auth::user()->type == 'SU')
        {
            $maps = QuizMap::orderBy('id','DESC')->paginate(5);
            $user = User::where('id',Auth::user()->id)->first();
            $quizes = Quiz::all();
        }
        else
        {
            $user = User::where('id',Auth::user()->id)->first();
            $maps = QuizMap::orderBy('id','DESC')->where('location',$user->userlevel->college)->paginate(5);
            $quizes = Quiz::where('location',$user->userlevel->college)->get();
        }
        return view('map/databasemap',[
            'maps'=>$maps,
            'quizes'=>$quizes,
            'user'=>$user,
            'location'=>$location,
            'tables'=>$tables]);
    }

    public function maptable(Request $request, $id)
    {
        $map = QuizMap::where('category_id',$id)->first();
        if($map->category->shared_id == null)
        {
            $question_count = count(Question::where('quiz_id',$map->category_id)->get());
        }
        else
        {
            $question_count = count(Question::where('quiz_id',$map->category->shared_id)->get());
        }
        if($question_count == 0)
        {
            return back()->with('message','There is no Question added. You cannot Map it!');
        }
        else
        {
            $table = DB::table('migrations')->where('migration',$request->table_name)->first();
            $table_map = TableMap::where('table_id',$table->id)->first();
            if(isset($table_map))
            {
                return back()->with('message','There is no Question added. You cannot Map it!');
            }
            else
            {
                $map_table = new TableMap;
                $map_table->quiz_id = $map->category_id;
                $map_table->table_id = $table->id;
                $map_table->mapped_by = Auth::user()->id;
                $map_table->save();
                return back()->with('message','Mapping Successful!');
            }
        }
    }
    
    public function databasetable()
    {
        $table = DB::table('migrations')->paginate(10);
        $table_map = TableMap::all();
        return view('create-table',['table'=>$table]);
    }
    
    public function sendotp()
    {
        date_default_timezone_set("Asia/Calcutta");
        $otp = Otp::orderBy('id','DESC')->where('user_id',Auth::user()->id)->where('updated_at','!=','created_at')->first();
        if($otp){
            $date1 = strtotime(date('Y-m-d H:i:s'));
            $date2 = strtotime($otp->updated_at);
            
            // Formulate the Difference between two dates
            $diff = abs($date2 - $date1);
            
            // To get the year divide the resultant date into
            // total seconds in a year (365*60*60*24)
            $years = floor($diff / (365*60*60*24));
            
            // To get the month, subtract it with years and
            // divide the resultant date into
            // total seconds in a month (30*60*60*24)
            $months = floor(($diff - $years * 365*60*60*24)
            								/ (30*60*60*24));
            
            // To get the day, subtract it with years and
            // months and divide the resultant date into
            // total seconds in a days (60*60*24)
            $days = floor(($diff - $years * 365*60*60*24 -
            			$months*30*60*60*24)/ (60*60*24));
            
            // To get the hour, subtract it with years,
            // months & seconds and divide the resultant
            // date into total seconds in a hours (60*60)
            $hours = floor(($diff - $years * 365*60*60*24
            		- $months*30*60*60*24 - $days*60*60*24)
            									/ (60*60));
            
            // To get the minutes, subtract it with years,
            // months, seconds and hours and divide the
            // resultant date into total seconds i.e. 60
            $minutes = floor(($diff - $years * 365*60*60*24
            		- $months*30*60*60*24 - $days*60*60*24
            							- $hours*60*60)/ 60);
            
            // To get the minutes, subtract it with years,
            // months, seconds, hours and minutes
            $seconds = floor(($diff - $years * 365*60*60*24
            		- $months*30*60*60*24 - $days*60*60*24
            				- $hours*60*60 - $minutes*60));
            
            // Print the result
            if($minutes >= 5)
            {
                
            }
            else
            {
                if($otp)
                {
                    return back()->with('message', 'Wait for few minutes before you resend');
                }
            }
        }
        $otp = substr(str_shuffle(str_repeat($x='123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6/strlen($x)) )),1,6);
        $data = new Otp;
        $data->otp = $otp;
        $data->user_id = Auth::user()->id;
        $data->save();
        $user = User::findOrFail(Auth::user()->id);
        $notice = [
            'name' => $user->name,
            'otp' => $otp    
        ];
        $user->notify(new OtpNotification($notice));
        return back()->with('message', ' OTP sent to your registered email! Please wait for few minutes before you resend OTP');
    }
    
    public function createdatabasetable(Request $request)
    {
        $otp = Otp::orderBy('id','DESC')->where('user_id',Auth::user()->id)->where('user_otp',null)->first();
        if($otp == null)
        {
            return back()->with('message','Either OTP Expired or Not valid');
        }
        if($request->otp == $otp->otp)
        {
            $otp->user_otp = $request->otp;
            $otp->save();
            //check if already exist
            $data1 = Migration::where('batch',10)->get();
            $tab_count = count($data1);
            $num = $tab_count+1;
            $tab_name = date('Y_m_d').'_'.date('hms').'_create_quiz_answer'.$num.'s_table';
            $stor_tab = substr($tab_name,25,-6);
            $migration = new Migration;
            $migration->migration = $tab_name;
            $migration->batch = 10;
            $migration->save();
            Schema::create($stor_tab, function (Blueprint $table) {
                $table->id();
                $table->string('quiz_id');
                $table->string('quest_no');
                $table->string('quest_img')->nullable();
                $table->string('question');
                $table->string('optiona');
                $table->string('optionb');
                $table->string('optionc');
                $table->string('optiond');
                $table->string('user_ans')->nullable();
                $table->string('correct_ans');
                $table->bigInteger('user_id');
                $table->timestamps();
            });
            return back()->with('message','Database Table Created');
        }
        else
        {
            return back()->with('message','OTP verification failed!');
        }
    }
}
