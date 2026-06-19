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
                          <h5 class="card-header">Results [All Quizzes]</h5>
                          <div class="card-body">
                            <table class="table table-sm text-xs">
                                <thead class="table-dark">
                                <tr>
                                    <th>Sl.No.</th>
                                    <th>Quiz</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @foreach($table as $key=>$tab)
                                @if(Auth::user()->type == 'SU')
                                <tr>
                                    <th>{{$key+1}}</th>
                                    <th>{{optional($tab->quizloc)->quiz_category}}</th>
                                    <th>{{optional($tab->quizloc)->loc->location}}</th>
                                    <th>
                                    <form method="post" action="{{url('result-quizwise'.optional($tab->quizloc)->id)}}">@csrf
                                        <button type="submit" class="badge bg-success text-decoration-none">View Result</button>
                                        </form>                                    </th>
                                </tr>
                                @elseif(optional($current_user->userlevel)->college == optional(optional($tab->quizloc)->loc)->id)
                                <tr>
                                    <th>{{$key+1}}</th>
                                    <th>{{optional($tab->quizloc)->quiz_category}}</th>
                                    <th>{{optional($tab->quizloc)->loc->location}}</th>
                                    <th>
                                      <form method="post" action="{{url('result-quizwise'.$tab->quizloc->id)}}">@csrf
                                        <button type="submit" class="badge bg-success text-decoration-none">View Result</button>
                                        </form>
                                    </th>
                                </tr>
                                @endif
                                @endforeach
                            </table>
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
