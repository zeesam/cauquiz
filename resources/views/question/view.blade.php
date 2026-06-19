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
                          <h5 class="card-header">All Questions</h5>
                          <div class="card-body small">
                            <table class="table table-sm text-xs" style="font-size:12px">
                              <thead>
                                <tr>
                                  <th scope="col">Sl. No.</th>
                                  <th scope="col">Quiz Topic</th>
                                  <th scope="col">Question</th>
                                  <th scope="col">Added By</th>
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($question as $key=>$ques)
                                <tr>
                                  <th scope="row">{{$key+1}}</th>
                                  <td>{{optional($ques->quizer)->quiz_category}}</td>
                                  <td>{{$ques->question}}</td>
                                  <td>{{optional($ques->user)->name}}</td>
                                  <td>
                                    <a href="{{url('/question/show/'.$ques->id)}}" class="badge text-bg-success text-decoration-none">Show</a>
                                    @if($ques->added_by == Auth::user()->id)
                                    <a href="{{url('/question/edit/'.$ques->id)}}" class="badge text-bg-warning text-decoration-none">Edit</a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{$ques->id}}" class="badge text-bg-danger text-decoration-none">Delete</a>
                                    @endif
                                  </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{$ques->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                      </div>
                                      <div class="modal-body">
                                        <p class="fs-2">Are you Sure?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form method="post" action="{{url('/question/delete/'.$ques->id)}}">@csrf
                                          <button type="submit" class="btn btn-sm btn-primary">Yes! Delete</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endforeach
                              </tbody>
                            </table>
                            {{ $question->links() }}
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
