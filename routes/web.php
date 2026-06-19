<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route to refresh CAPTCHA

Route::get('/test-notification/{email}', function ($email) {
    $user = App\Models\User::where('email', $email)->first();
    
    if (!$user) {
        return "User not found with email: {$email}";
    }
    
    try {
        $user->notify(new \Illuminate\Auth\Notifications\ResetPassword(
            \Illuminate\Support\Str::random(60)
        ));
        return "Reset password notification sent to {$email}";
    } catch (\Exception $e) {
        return "Failed: " . $e->getMessage();
    }
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/info', [FacultyController::class, 'showForm'])->name('faculty.form');
    Route::post('/faculty-submit', [FacultyController::class, 'submitForm'])->name('faculty.submit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('version/{id}',[App\Http\Controllers\HomeController::class, 'version']);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/changelocation', [App\Http\Controllers\HomeController::class, 'changelocation'])->name('changelocation');

Route::middleware('student')->group(function(){
    Route::get('/student-quizstart{id}', [App\Http\Controllers\StudentController::class, 'quizstart']);
    Route::get('/student/result/{id}', [App\Http\Controllers\StudentController::class, 'studentwise']);

});

Route::middleware('ladmin')->group(function(){
Route::post('/question-delete/{id}', [App\Http\Controllers\QuestionController::class, 'destroy'])->middleware('auth');

Route::post('/map-pub/{id}', [App\Http\Controllers\QuizMapController::class, 'pub'])->middleware('auth');
Route::post('/map-unpub/{id}', [App\Http\Controllers\QuizMapController::class, 'unpub'])->middleware('auth');

Route::get('/map-databasemap', [App\Http\Controllers\DatabaseMapController::class, 'map'])->middleware('auth');
Route::post('/map-maptable/{id}', [App\Http\Controllers\DatabaseMapController::class, 'maptable'])->middleware('auth');
Route::get('/create-table', [App\Http\Controllers\DatabaseMapController::class, 'databasetable'])->middleware('auth');
Route::post('/sendotp', [App\Http\Controllers\DatabaseMapController::class, 'sendotp'])->middleware('auth');
Route::post('/createdatabasetable', [App\Http\Controllers\DatabaseMapController::class, 'createdatabasetable'])->middleware('auth');


Route::get('result-view',[App\Http\Controllers\ResultController::class, 'view'])->middleware('auth');
Route::post('/result-quizwise{id}', [App\Http\Controllers\ResultController::class, 'quizwise'])->middleware('auth');
Route::post('/result-studentwise{id}', [App\Http\Controllers\ResultController::class, 'studentwise'])->middleware('auth');
Route::post('/quiz/share/{id}', [App\Http\Controllers\QuizController::class, 'share'])->middleware('auth');
Route::post('/quiz/remshare/{id}', [App\Http\Controllers\QuizController::class, 'remshare'])->middleware('auth');

Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->middleware('auth');
Route::get('/report-faculties', [App\Http\Controllers\ReportController::class, 'faculties'])->middleware('auth');
Route::get('/report-users', [App\Http\Controllers\ReportController::class, 'users'])->middleware('auth');
Route::get('/report-location', [App\Http\Controllers\ReportController::class, 'location'])->middleware('auth');
Route::post('/searchuser', [App\Http\Controllers\ReportController::class, 'searchuser'])->middleware('auth');
Route::post('/searchuserx', [App\Http\Controllers\ReportController::class, 'searchuserx'])->middleware('auth');
Route::get('/faculty-export', [App\Http\Controllers\ReportController::class, 'exportfaculty'])->middleware('auth');
Route::get('/user-export', [App\Http\Controllers\ReportController::class, 'exportuser'])->middleware('auth');
Route::get('/location-export', [App\Http\Controllers\ReportController::class, 'exportlocation'])->middleware('auth');

Route::prefix('report')->name('report.')->group(function () {
        Route::get('/faculty-info', [ReportController::class, 'facultyinfo'])->name('faculty-info');
        Route::get('/faculty/{id}', [ReportController::class, 'show'])->name('show');
        Route::get('/faculty/{id}/pdf', [ReportController::class, 'downloadPdf'])->name('pdf');
        Route::get('/export', [ExportController::class, 'exportAllFaculty'])->name('export');
    });

});

Route::middleware(['ladmin2'])->group(function(){
Route::get('/question-create', [App\Http\Controllers\QuestionController::class, 'create'])->middleware(['auth',]);
Route::post('/createques', [App\Http\Controllers\QuestionController::class, 'createques'])->middleware(['auth',]);
Route::post('/question-store', [App\Http\Controllers\QuestionController::class, 'store'])->middleware('auth');
Route::get('/question-view', [App\Http\Controllers\QuestionController::class, 'index'])->middleware('auth');
Route::get('/question/edit/{id}', [App\Http\Controllers\QuestionController::class, 'edit'])->middleware('auth');
Route::get('/question/show/{id}', [App\Http\Controllers\QuestionController::class, 'show'])->middleware('auth');
Route::post('/question/update/{id}', [App\Http\Controllers\QuestionController::class, 'update'])->middleware('auth');
Route::post('/question/delete/{id}', [App\Http\Controllers\QuestionController::class, 'destroy'])->middleware('auth');

Route::get('/quiz-create', [App\Http\Controllers\QuizController::class, 'create'])->middleware('auth');
Route::post('/quiz-store', [App\Http\Controllers\QuizController::class, 'store'])->middleware('auth');
Route::get('/quiz-view', [App\Http\Controllers\QuizController::class, 'index'])->middleware('auth');
Route::get('/quiz/edit/{id}', [App\Http\Controllers\QuizController::class, 'edit'])->middleware('auth');
Route::get('/quiz/show/{id}', [App\Http\Controllers\QuizController::class, 'show'])->middleware('auth');
Route::post('/quiz/update/{id}', [App\Http\Controllers\QuizController::class, 'update'])->middleware('auth');
Route::post('/quiz/delete/{id}', [App\Http\Controllers\QuizController::class, 'destroy'])->middleware('auth');
Route::post('/quizsearchresult', [App\Http\Controllers\QuizController::class, 'quizsearchresult'])->middleware('auth');

Route::get('/map-quizmap', [App\Http\Controllers\QuizMapController::class, 'map'])->middleware('auth');
Route::post('/map-store', [App\Http\Controllers\QuizMapController::class, 'store'])->middleware('auth');
Route::get('/dropdownrem/{id}', [App\Http\Controllers\QuizMapController::class, 'dropdownrem'])->middleware('auth');
Route::get('/dropdownadd/{id}', [App\Http\Controllers\QuizMapController::class, 'dropdownadd'])->middleware('auth');

Route::get('/user-create', [App\Http\Controllers\UserController::class, 'create'])->middleware('auth');
Route::post('/user-insert', [App\Http\Controllers\UserController::class, 'insert'])->middleware('auth');
Route::get('/user-view', [App\Http\Controllers\UserController::class, 'view'])->middleware('auth');
Route::post('/user/mapuser/{id}', [App\Http\Controllers\UserController::class, 'mapuser'])->middleware('auth');

Route::get('student-selector', [App\Http\Controllers\StudentSelectorController::class, 'selection'])->middleware('auth');
Route::get('student-selection', [App\Http\Controllers\StudentSelectorController::class, 'selection'])->middleware('auth');
Route::get('student-selector-demo', [App\Http\Controllers\StudentSelectorController::class, 'selectordemo'])->middleware('auth');
Route::get('preselectstudent/{id}', [App\Http\Controllers\StudentSelectorController::class, 'preselectstudent'])->middleware('auth');

Route::get('quiz-from-student', [App\Http\Controllers\QuizFromStudentController::class, 'studentquiz'])->middleware('auth');

Route::get('classroom', [App\Http\Controllers\ClassRoomController::class, 'classroom'])->middleware('auth');
Route::get('start', [App\Http\Controllers\ClassRoomController::class, 'index'])->middleware('auth');
Route::any('zoom-meeting-create', [App\Http\Controllers\ClassRoomController::class, 'index'])->middleware('auth');

Route::get('contributor', function () {
    return view('contributor/view');
})->middleware('auth');

});

Route::middleware(['sadmin'])->group(function(){
Route::post('/user/transfer/{id}', [App\Http\Controllers\UserController::class, 'usertransfer'])->middleware('auth');

});

require __DIR__.'/auth.php';
