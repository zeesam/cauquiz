@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quiz: {{$quiz->quiz_category}}</div>
                @livewire('live-student-question',['stid'=>$quiz->id])
            </div>
        </div>
    </div>
</div>
@endsection
