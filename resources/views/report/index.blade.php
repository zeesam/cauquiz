@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Generate Report') }}</div>

                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-3">
                        @include('layouts.sidebar')
                      </div>
                      <div class="col-sm-9">
                        <div class="card">
                          <div class="card-body">
                            <div class="row text-center">
                              <div class="col-4 d-grid gap-2">
                                <a href="{{url('report-users')}}" class="p-2 btn btn-info">Students Registered</a>
                              </div> 
                              <div class="col-4 d-grid gap-2">
                                <a href="{{url('report-faculties')}}" class="p-2 btn btn-info">Faculties Registered</a>
                              </div>
                              <div class="col-4 d-grid gap-2">
                                <div class="p-2 btn btn-info">All Quizzes</div>
                              </div>
                            </div>
                            <br>
                            <div class="row text-center">
                              <div class="col-4 d-grid gap-2">
                                <div class="p-2 btn btn-info">All Questions</div>
                              </div> 
                              <div class="col-4 d-grid gap-2">
                                <div class="p-2 btn btn-info">Quiz Exam Conducted</div>
                              </div>
                              <div class="col-4 d-grid gap-2">
                                <div class="p-2 btn btn-info">Overall Consolidated Report</div>
                              </div>
                            </div>
                            <br>
                            <div class="row text-center">
                              <div class="col-4 d-grid gap-2">
                                <a href="{{url('report-location')}}" class="p-2 btn btn-info">All Locations</a>
                              </div> 
                              <div class="col-4 d-grid gap-2">
                                <div class="p-2 btn btn-info">Shared Quiz</div>
                              </div>
                              <div class="col-4 d-grid gap-2">
                                <a href="{{route('report.faculty-info')}}" class="p-2 btn btn-info">Faculty Info</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
