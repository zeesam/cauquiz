@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                  <div class="container">
                      @if(($map_user) && $map_user->level == 4)
                      <div class="row">
                      <div class="col-sm-12">
                        <div class="card">
                          <h5 class="card-header">Welcome</h5>
                          <div class="card-body">
                            <h5 class="card-title">{{Auth::user()->name}}</h5>
                           @include('profile.partials.update-profile-information-form')
                           @include('profile.partials.update-password-form')

                            @include('profile.partials.delete-user-form')
                          </div>
                        </div>
                      </div>
                    </div>
                      @elseif(Auth::user()->type == 'SU' || $map_user->level != 4)
                    <div class="row">
                      <div class="col-sm-3">
                        @include('layouts.sidebar')
                      </div>
                      <div class="col-sm-9">
                        <div class="card">
                          <h5 class="card-header">Welcome</h5>
                          <div class="card-body">
                            <h5 class="card-title">{{Auth::user()->name}}</h5>
                           @include('profile.partials.update-profile-information-form')
                           @include('profile.partials.update-password-form')

                            @include('profile.partials.delete-user-form')
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection