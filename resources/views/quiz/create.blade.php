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
                        @if(Session::has('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          {{Session::get('message')}}
                          <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                          </button>
                        </div>
                        @endif
                        <div class="card">
                          <h5 class="card-header">Create Quiz</h5>
                          <div class="card-body">
                            <form method="post" action="{{url('quiz-store')}}">@csrf
                              <div class="form-group">
                                <label for="quiz_title">Quiz Name/Title/Subject</label>
                                <input type="text" name="quiz_category" class="form-control @error('quiz_category') is-invalid @enderror" id="quiz_title" >
                                @error('quiz_category')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                              <div class="form-group">
                                <label for="quiz_description">Quiz Description</label>
                                <textarea class="form-control @error('quiz_description') is-invalid @enderror" name="quiz_description" id="quiz_description" rows="3"></textarea>
                                @error('quiz_description')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                              <div class="form-group">
                                <label for="quiz_duration">Quiz Duration (in minutes)</label>
                                <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror" id="quiz_duration" >
                                @error('duration')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div><br>
                              <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                            </form>
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
