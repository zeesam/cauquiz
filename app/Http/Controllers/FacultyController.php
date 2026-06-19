<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacultyInfo;
use App\Models\User;
use App\Mail\FacultyInfoMail;
use Illuminate\Support\Facades\Mail;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showForm(Request $request)
    {       
        // Get user's faculty info
        $facultyInfo = FacultyInfo::where('user_id', Auth::id())->first();
        $user = User::where('id', Auth::id())->first();
        return view('info/index', [
            'facultyInfo' => $facultyInfo,
            'user'=>$user
        ]);
    }
    
    public function submitForm(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'name_of_faculty' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'department' => 'required|string|max:255',
            'college' => 'required|string|max:255',
        ]);
        
        // Check if user already has faculty info
        $facultyInfo = FacultyInfo::where('user_id', Auth::id())->first();
        
        if ($facultyInfo) {
            // Update existing
            $facultyInfo->update([
                'name_of_faculty' => $validated['name_of_faculty'],
                'email' => $validated['email'],
                'department' => $validated['department'],
                'college' => $validated['college']
            ]);
            $message = 'Your information has been updated successfully!';
        } else {
            // Create new
            $validated['user_id'] = Auth::id();
            $facultyInfo = FacultyInfo::create($validated);
            $message = 'Your information has been submitted successfully!';
        }
        
        return redirect()->route('faculty.form');
    }
}