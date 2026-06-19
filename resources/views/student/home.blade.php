@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <div class="container">
                        <h2>Welcome {{Auth::user()->name}}!!</h2>
                        <p>You can opt for the following Quizzes from {{$user_loc->loc->location}}</p>
                        @livewire('student-selector')
                        <br>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Result</div>
                            </div>
                            <div class="card-body">
                                @foreach($quiz_chosen as $quiz)
                                    <a class="btn btn-info" href="student/result/{{$quiz->quiz_id}}">{{optional($quiz->quiz)->quiz_category}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
