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
                          <h5 class="card-header">Create User</h5>
                          <div class="card-body">
                            <form method="post" action="{{url('user-insert')}}">@csrf
                                @if(Auth::user()->type == 'SU')
                                <div class="form-group">
                                <label for="quiz_title">Select a College</label>
                                    <select class="form-control" name="location">
                                        <option value="-1">Select a College</option>
                                        @foreach(App\Models\Location::all() as $loc)
                                            <option value="{{$loc->id}}">{{$loc->location}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                              <div class="form-group">
                                <label for="quiz_title">Name of the User</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="quiz_title" >
                                @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                              <div class="form-group">
                                <label for="quiz_description">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="quiz_title" >
                                @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                              <div class="form-group">
                                <label for="quiz_duration">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="quiz_duration" >
                                @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                              <div class="form-group">
                                <label for="quiz_duration">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="quiz_duration" >
                                @error('password_confirmation')
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
