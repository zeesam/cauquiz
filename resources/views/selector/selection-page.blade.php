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
                          <h5 class="card-header">Quiz Selection Page</h5>
                          <div class="card-body">
                              @if(Session::has('message'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                  {{Session::get('message')}}
                                  <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                  </button>
                                </div>
                                @endif
                              <div class="row">
                                @foreach($table as $quiz)
                                @if(App\Models\Quiz::where('added_by',Auth::user()->id)->where('id',$quiz->category_id)->first())
                                    <div class="col-4"><a href="{{url('preselectstudent/'.$quiz->category_id)}}" class="btn btn-success d-grid gap-4 my-2">{{$quiz->category->quiz_category}}</a></div>
                                @endif
                                @endforeach
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
