<div class="d-grid gap-2">
<a href="{{url('quiz-create')}}" class="btn btn-info btn-sm ">Create Quiz</a>
<a href="{{url('map-quizmap')}}" class="btn btn-info btn-sm ">Map Quiz</a>
<a href="{{url('quiz-view')}}" class="btn btn-info btn-sm ">View/Share Quiz</a>
<a href="{{url('question-create')}}" class="btn btn-info btn-sm ">Create Question</a>
<a href="{{url('question-view')}}" class="btn btn-info btn-sm ">View Question</a>
<a href="{{url('user-create')}}" class="btn btn-success btn-sm ">Create User</a>
<a href="{{url('user-view')}}" class="btn btn-success btn-sm ">View/Map User</a>
<a href="{{url('map-databasemap')}}" class="btn btn-warning btn-sm ">Map Database Table</a>
<a href="{{url('student-selector')}}" class="btn btn-success btn-sm ">Exam Student Selector</a>
<a href="{{url('create-table')}}" class="btn btn-warning btn-sm ">Create Table</a>
<hr>
<a href="{{url('quiz-from-student')}}" class="btn btn-secondary btn-sm ">Quiz From Student</a>
<a href="{{url('result-view')}}" class="btn btn-primary btn-sm ">View Result</a>
<a href="{{url('contributor')}}" class="btn btn-primary btn-sm ">View Contributors</a>
<a href="{{url('report')}}" class="btn btn-dark btn-sm ">Generate Report</a>
@if(Auth::user()->type == 'SU')<a href="{{url('classroom')}}" class="btn btn-dark btn-sm ">Class Room</a>@endif
</div>

