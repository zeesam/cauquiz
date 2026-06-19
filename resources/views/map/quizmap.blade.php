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
                          <h5 class="card-header">Map Quiz</h5>
                          <div class="card-body">
                            <form method="post" action="{{url('map-store')}}">@csrf
                              <div class="form-group">
                                <label for="exampleFormControlSelect1">Select a Quiz Category</label>
                                <select name="quiz_id" class="form-control" id="exampleFormControlSelect1">
                                  <option>Select a Quiz Category</option>
                                  @foreach($quizes as $quiz)
                                  @if(empty(optional($quiz->map)->id))
                                  <option value="{{$quiz->id}}">{{$quiz->quiz_category}} - {{optional($quiz->loc)->location}}</option>
                                  @endif
                                  @endforeach
                                </select>
                              </div>
                              Type of Quiz:<br>
                                <div class="row">
                                  <div class="col-sm">
                                    <select name="quiz_type" class="form-control" id="exampleFormControlSelect1">
                                      <option>Select a Quiz Category</option>
                                      <!--<option value="2 Options Objective Type">2 Options Objective Type</option>-->
                                      <option value="4 Options Objective Type">4 Options Objective Type</option>
                                      <!-- <option value="5 Options Objective Type">5 Options Objective Type</option>
                                      <option value="Descriptive Type">Descriptive Type</option>
                                      <option value="Mixed Type">Mixed Type</option> -->
                                    </select>
                                  </div>
                                </div>
                                @if(Auth::user()->type == 'SU')
                                Select a Location:<br>
                                <div class="row">
                                  <div class="col-sm">
                                    <select name="location" class="form-control" id="exampleFormControlSelect1">
                                      <option>Select a Location</option>
                                      @foreach($location as $loc)
                                      <option value="{{$loc->id}}">{{$loc->location}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div><br>
                                @error('correct_ans')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              @endif<br>
                              <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form><br>
                            <table class="table table-bordered table-stripped table-sm" style="font-size:12px">
                              <thead class="table-dark">
                                <tr>
                                    <th>Quiz Name/Catgeory</th>
                                    <th>Quiz Type</th>
                                    <th>Mapped Location</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @foreach($maps as $map)
                                <tr>
                                    <td>{{optional($map->category)->quiz_category}}</td>
                                    <td>{{$map->quiz_type}}</td>
                                    <td>{{optional(optional($map->category)->loc)->location}}</td>
                                    <td>
                                        @if(optional($map->category)->status == 1) <span class="text-success">Active</span> 
                                        @else <span class="text-info">Inactive</span>  @endif<br>
                                        @if(optional($map->category)->dropdown != 1) <span class="text-warning">In Dropdown</span> 
                                        @else <span class="text-danger">Not in Dropdown</span>  @endif
                                    
                                    </td>
                                    <td>
                                        @if(optional($map->category)->dropdown == null)
                                        <a href="{{url('dropdownrem/'.optional($map->category)->id)}}" class="badge bg-danger text-decoration-none">Remove from Dropdown</a>
                                        @else
                                        <a href="{{url('dropdownadd/'.optional($map->category)->id)}}" class="badge bg-success text-decoration-none">Add to Dropdown</a>
                                        @endif
                                    </td>
                                </tr>
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
</div>
@endsection
