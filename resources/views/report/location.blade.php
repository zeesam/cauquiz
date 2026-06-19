@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Generate Report - Location Wise') }}</div>

                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-3">
                        @include('layouts.sidebar')
                      </div>
                      <div class="col-sm-9">
                        <div class="card">
                          <div class="card-body">
                              <a href="{{url('location-export')}}" class="btn btn-success">Export to Excel <i class="fa-solid fa-table"></i></a><br><br>
                            <table class="table table-sm text-xs" style="font-size:12px">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name of Location</th>
                                        <th>Quizzes Created</th>
                                        <th>Questions Created</th>
                                        <th>Administrators</th>
                                        <th>Contributors</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($location as $key=>$loc)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$loc->location}}</td>
                                        <td>{{count($loc->quizcreated)}}</td>
                                        <td>{{count($loc->questioncreated)}}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1{{$loc->id}}">
                                            {{count($loc->usermap)}}
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal2{{$loc->id}}">
                                                {{count($loc->questioncreated->unique('added_by'))}}
                                            </button>
                                        </td>
                                    </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal1{{$loc->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Administrators</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                <h5>Administrators for {{$loc->location}}</h5>
                                                <div class="row">
                                                    <div class="col-3">User ID</div>
                                                    <div class="col-6">Name</div>
                                                    <div class="col-3">Admin Level</div>
                                                </div>
                                                @foreach(App\Models\MapUser::where('college',$loc->id)->where('level','!=','4')->get() as $user)
                                                <br>
                                                <div class="row">
                                                    <div class="col-3">{{optional($user->user)->id}}</div>
                                                    <div class="col-6">{{optional($user->user)->name}}</div>
                                                    <div class="col-3">{{$user->level}}</div>
                                                </div>
                                                @endforeach
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal fade" id="exampleModal2{{$loc->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Contributors</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                <h5>Contributors for {{$loc->location}}</h5>
                                                <div class="row">
                                                    <div class="col-6">Name</div>
                                                    <div class="col-3">Quiz Added</div>
                                                    <div class="col-3">Questions Added</div>
                                                </div>
                                                @foreach(App\Models\Question::where('location',$loc->id)->select('added_by')->distinct()->get() as $user)
                                                <br>
                                                <div class="row">
                                                    <div class="col-6">{{$user->user->name}}</div>
                                                    <div class="col-3">{{count(App\Models\Quiz::where('added_by',$user->user->id)->get())}}</div>
                                                    <div class="col-3">{{count(App\Models\Question::where('added_by',$user->user->id)->get())}}</div>
                                                </div>
                                                @endforeach
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    @endforeach
                                </tbody>
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
