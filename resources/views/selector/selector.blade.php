@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-3">
                        @include('layouts.sidebar')
                      </div>
                      <div class="col-sm-9">
                        <div class="card">
                          <h5 class="card-header">Student Selector - @php $id = session()->get('my_quiz'); echo $id->quiz_category @endphp</h5>
                          <div class="card-body">
                              <marquee><p class="text-danger">Do not reload/refresh this Page</p></marquee>
                              <?php
                              $quiz_id = session()->get('quiz_id');
                              ?>
                            @livewire('live-student-selector',['quiz_id'=>$quiz_id])
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
