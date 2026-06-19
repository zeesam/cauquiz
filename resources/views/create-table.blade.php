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
                          <h5 class="card-header">Create Table for Quiz</h5>
                          <div class="card-body">
                            <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" align="right">Send OTP</a>
                            
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">OTP</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Are you sure?<br>
                                    You will receive an OTP on the registered email.
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form method="post" action="{{url('sendotp')}}">@csrf
                                        <button type="submit" class="btn btn-primary">Send OTP!</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <br><br>
                            <form method="post" action="{{url('createdatabasetable')}}">@csrf
                                <input type="text" name="otp" class="form-control-lg" placeholder="Enter OTP here">
                                @error('otp') {{$message}} @enderror
                                <button type="submit" class="btn btn-danger btn-lg">Verify OTP & Create a Database</button>
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
