@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body small">
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
                          <h5 class="card-header">Map Database</h5>
                          <div class="card-body">
                            <table class="table table-bordered table-stripped px-1 table-sm text-sm">
                              <thead class="table-dark">
                                <tr>
                                    <th>Quiz Name/Catgeory</th>
                                    <th>Quiz Type</th>
                                    <th>Mapped Location</th>
                                    <th>Map Table</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                @foreach($maps as $map)
                                @if(Auth::user()->type == 'SU')
                                <tr>
                                    <td>{{optional($map->category)->quiz_category}}</td>
                                    <td>{{$map->quiz_type}}</td>
                                    <td>{{optional(optional($map->category)->loc)->location}}</td>
                                    <form method="post" action="{{url('map-maptable/'.optional($map->category)->id)}}">@csrf
                                    <td>
                                        @if(optional($map->tablemap)->id)
                                            <?php echo substr(optional($map->tablemap)->tablename->migration,25,-6); ?>
                                        @else
                                        <select name="table_name" class="form-control">
                                            <option>Select a Table</option>
                                            @foreach($tables as $table)
                                            <option value="{{$table->migration}}">{{$table->migration}}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="badge text-bg-warning">Map Table</button>
                                        @endif
                                    </td>
                                    </form>
                                    <td>@if(optional($map->category)->status == 1) <span class="text-success">Active</span>
                                    @else <span class="text-danger">In-Active</span> @endif
                                    <br>
                                    @if(optional($map->tablemap)->id)
                                      <a href="#" data-bs-toggle="modal" data-bs-target="#pub{{$map->id}}" class="badge text-bg-warning text-decoration-none">Publish</a>
                                      <a href="#" data-bs-toggle="modal" data-bs-target="#unpub{{$map->id}}" class="badge text-bg-danger text-decoration-none">Un-Publish</a>
                                    @endif
                                    </td>
                                </tr>
                                @elseif(optional($user->userlevel)->college == optional($map->category)->location)
                                <tr>
                                    <td>{{optional($map->category)->quiz_category}}</td>
                                    <td>{{$map->quiz_type}}</td>
                                    <td>{{optional(optional($map->category)->loc)->location}}</td>
                                    <form method="post" action="{{url('map-maptable/'.optional($map->category)->id)}}">@csrf
                                    <td>
                                        @if(optional($map->tablemap)->id)
                                            <?php echo substr(optional($map->tablemap)->tablename->migration,25,-6); ?>
                                        @else
                                        <select name="table_name" class="form-control">
                                            <option>Select a Table</option>
                                            @foreach($tables as $table)
                                            <option value="{{$table->migration}}">{{$table->migration}}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="badge text-bg-warning">Map Table</button>
                                        @endif
                                    </td>
                                    </form>
                                    <td>@if(optional($map->category)->status == 1) <span class="text-success">Active</span>
                                    @else <span class="text-danger">In-Active</span> @endif
                                    <br>
                                    @if(optional($map->tablemap)->id)
                                      <a href="#" data-bs-toggle="modal" data-bs-target="#pub{{$map->id}}" class="badge text-bg-warning text-decoration-none">Publish</a>
                                      <a href="#" data-bs-toggle="modal" data-bs-target="#unpub{{$map->id}}" class="badge text-bg-danger text-decoration-none">Un-Publish</a>
                                    @endif
                                    </td>
                                </tr>
                                @endif
                                <div class="modal fade" id="pub{{$map->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                      </div>
                                      <div class="modal-body">
                                        <p class="fs-2">Are you Sure? Want to Publish?</p>
                                        <p>
                                          There are <?php
                                          if($map->category->shared_id == null){
                                            echo count(\App\Models\Question::where('quiz_id',$map->category_id)->get());
                                          }
                                          else{
                                            echo count(\App\Models\Question::where('quiz_id',$map->category->shared_id)->get());
                                          }
                                          ?> 
                                        Questions under this Quiz</p>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form method="post" action="{{url('/map-pub/'.$map->id)}}">@csrf
                                          <button type="submit" class="btn btn-sm btn-primary">Yes! Publish</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal fade" id="unpub{{$map->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                      </div>
                                      <div class="modal-body">
                                        <p class="fs-2">Are you Sure? Taking down the Quiz?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form method="post" action="{{url('/map-unpub/'.$map->id)}}">@csrf
                                          <button type="submit" class="btn btn-sm btn-primary">Yes! Un-Publish</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endforeach
                            </table>
                            {{$maps->links()}}
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
