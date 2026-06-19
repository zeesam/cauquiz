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
                          <h5 class="card-header">Welcome</h5>
                          <div class="card-body">
                            <h5 class="card-title">{{Auth::user()->name}}</h5>
                            @if(Auth::user()->type == 'SU')

                            @elseif(optional($admins->userlevel)->level == 2)
                            <p class="card-text">Your Admin Level 2</p>
                            <div class="row text-center">
                              <div class="col-4">
                                <div class="p-2 bg-info">Accessible to you</div>
                              </div>
                              <div class="col-4">
                                <div class="p-2 bg-success">Accessible to Local Admin</div>
                              </div>
                              <div class="col-4">
                                <div class="p-2 bg-warning">Accessible to Super Admin</div>
                              </div>
                            </div>
                            <p>You can create and map quiz and create questions</p>
                            @elseif(optional($admins->userlevel)->level == 1)
                            <p class="card-text">Your Admin Level 1</p>
                            <div class="row text-center">
                              <div class="col-4">
                                <div class="p-2 bg-info">Accessible to you</div>
                              </div>
                              <div class="col-4">
                                <div class="p-2 bg-success">Accessible to You</div>
                              </div>
                              <div class="col-4">
                                <div class="p-2 bg-warning">Accessible to Super Admin</div>
                              </div>
                            @endif<br><hr>
                            <div class="text-right">
                              <a href="{{asset('files/manual_admin.docx')}}" align="right" class="btn btn-success">Download User Manual</a>
                          </div>
                          </div>
                          <div class="text-success blink">
                              <br>
                              <h2>What's New:</h2>
                              <ul>
                                  <li>We have introduced a new Module where only the selected students can appear in examination</li>
                                  <li>Only the respective quiz uploader can choose their students who will be appearing in the exam</li>
                                  <li>User manual has also been updated with the new module addition. Check it out.</li>
                              </ul>
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
