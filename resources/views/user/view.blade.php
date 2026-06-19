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
                          <h5 class="card-header">All Users</h5>
                          <div class="card-body small">
                            @livewire('live-search-user',['lazy'=>true])
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
<script>
      window.addEventListener('close-modal', event => {
          $('#transferuser').modal('hide');
          $('#mapnewuser').modal('hide');
      });
    </script>
@endsection
