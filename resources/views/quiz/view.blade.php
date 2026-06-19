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
                          <h5 class="card-header">All Quizzes</h5>
                          @error('quiz_name') <span class="d-block"> {{$message}} </span>@enderror
                          <form method="post" action="quizsearchresult" name="quiz_name" class="d-flex p-2">@csrf
                            <input type="text" placeholder="Search by Quiz Name" class="form-control p-2"/> <button class="btn btn-success p-2">Search</button>
                          </form>
                          <div class="card-body small">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">Sl. No.</th>
                                  <th scope="col">Quiz ID</th>
                                  <th scope="col">Quiz Topic</th>
                                  <th scope="col">Description</th>
                                  <th scope="col">Shared Location</th>
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($quiz as $key=>$qu)
                                <tr>
                                  <th scope="row">{{$key+1}}</th>
                                  <td>{{$qu->id}}</td>
                                  <td>
                                    <a href="{{url('/quiz/show/'.$qu->id)}}" class="text-decoration-none "><div class="badge text-bg-primary text-wrap">
                                   {{$qu->quiz_category}}
                                  </div></a></td>
                                  <td>{{$qu->quiz_description}}</td>
                                  <td style="font-size:9px">@foreach(\App\Models\Quiz::where('quiz_category',$qu->quiz_category)->get() as $loc)
                                      <a href="#" data-bs-toggle="modal" data-bs-target="#remshare{{$loc->id}}">{{optional($loc->loc)->location}}</a><br>
                                      <div class="modal fade" id="remshare{{$loc->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Remove Share Quiz</h5>
                                              </div>
                                                  <div class="modal-body" style="font-size:12px">
                                                    Remove sharing from {{optional($loc->loc)->location}}?
                                                  </div>
                                                  <form method="post" action="{{url('quiz/remshare/'.$loc->id)}}">@csrf
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                      <button type="submit" class="btn btn-sm btn-primary">Yes! Remove</button>
                                                  </div>
                                                 </form>
                                            </div>
                                          </div>
                                        </div>
                                      @endforeach
                                  </td>
                                  <td>
                                    <a href="{{url('/quiz/edit/'.$qu->id)}}" class="text-decoration-none badge text-bg-info">Edit</a>
                                    <a href="#" class="badge text-decoration-none text-bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{$qu->id}}">Delete</a>
                                    <a href="#" class="badge text-decoration-none text-bg-warning" data-bs-toggle="modal" data-bs-target="#share{{$qu->id}}">Share</a>
                                  </td>
                                </tr>               
                                
                                <div class="modal fade" id="exampleModal{{$qu->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <form method="post" action="{{url('quiz/delete/'.$qu->id)}}">@csrf
                                          <button type="submit" class="btn btn-sm btn-primary">Yes! Delete</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="modal fade" id="share{{$qu->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Share Quiz</h5>
                                      </div>
                                         <form method="post" action="{{url('quiz/share/'.$qu->id)}}">@csrf
                                          <div class="modal-body">
                                            <select name="location" class="form-control" id="exampleFormControlSelect1">
                                              <option value="-1">Select a Location</option>
                                              @foreach($location as $loc)
                                              <option value="{{$loc->id}}">{{$loc->location}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-sm btn-primary">Yes! Share</button>
                                          </div>
                                         </form>
                                    </div>
                                  </div>
                                </div>
                                @endforeach
                              </tbody>
                            </table>
                            {{ $quiz->links() }}
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
