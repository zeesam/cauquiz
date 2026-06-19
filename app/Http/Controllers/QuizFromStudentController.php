<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizFromStudentController extends Controller
{
    public function studentquiz(){
        return view('under-const');
    }
}
