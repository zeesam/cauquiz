@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Generate Report - Faculties Registered') }}</div>

                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-3">
                        @include('layouts.sidebar')
                      </div>
                      <div class="col-sm-9">
                        <div class="card">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-9">
                                  <form method="post" action="{{url('searchuserx')}}">@csrf
                                    <div class="row">
                                      <div class="col-8">
                                        <input type="text" placeholder="Search User by Name or Email" class="form-control" name="search"/>
                                      </div>
                                      <div class="col-4 d-grid">
                                          <button type="submit" class="btn btn-success">Search <i class="fa-solid fa-magnifying-glass"></i></button>
                                      </div>
                                    </div>
                                  </form>
                                  </div>
                                    <div class="col-3 d-grid">
                                      <a href="{{url('user-export')}}" class="btn btn-success">Export to Excel <i class="fa-solid fa-table"></i></a>
                                  </div>
                                  </div>
                              <br>
                            <table class="table table-sm text-xs">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key=>$user)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{optional(optional($user->userlevel)->loc)->location}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$users->links()}}
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
