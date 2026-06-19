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
                            <div class="col-sm-8">
                                <div class="card">
                                    <h5 class="card-header">Approval Pending</h5>
                                    @if(Session::has('message'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        {{Session::get('message')}}
                                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                        </div>
                                    @endif
                                        <div class="card-body">
                                            <h5 class="card-title">Pending</h5>
                                            <p class="text-success" style="font-size:20px">Welcome {{Auth::user()->name}}!!</p>
                                            <p class="text-danger">You account is not approved yet! Approach your College Admin for Approval!</p>
                                            <p class="text-danger">Location you have selected is -> {{optional(Auth::user()->loc)->location}}! 
                                            <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                Click Here to change Location
                                                </button>
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Change Location</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="post" action="changelocation">@csrf
                                                    <div class="modal-body">
                                                            <select class="form-control" name="location">
                                                                <option value="-1">Select a College</option>
                                                                @foreach(App\Models\Location::all() as $loc)
                                                                    <option value="{{$loc->id}}">{{$loc->location}}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </p>
                                            <p></p>
                                        </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                Your admins are
                                <ol>
                                    @foreach($admins as $admin)
                                    <li>{{$admin->name}}</li>
                                    @endforeach
                                </ol>
                                <h4>Ask them to approve your account</h4>
                            </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
