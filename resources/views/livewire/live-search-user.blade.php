<div>
    @if(Session::has('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          {{Session::get('message')}}
                          <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                          </button>
                        </div>
                        @endif
    <input type="text" wire:model.live="search" class="form-control" placeholder="Search User by Name OR Email Here"><br>
    @include('livewire.usermodal')
        <table class="table text-xs table-sm table-striped" style="font-size:10px">
            <thead class="table-dark">
            <tr>
                <th scope="col">Sl. No.</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">User College Mapped</th>
                <th scope="col">User Level</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $key=>$user)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                {{optional(optional($user->userlevel)->loc)->location}}
                </div></a></td>
                <td>@if(optional($user->userlevel)->level == 1) Local Admin
                    @elseif(optional($user->userlevel)->level == 2) Local Admin Level 2
                    @elseif(optional($user->userlevel)->level == 3) Local Admin Level 3
                    @elseif(optional($user->userlevel)->level == 4) Student
                    @else Not Set @endif
                </td>
                <td>
                <a href="#" data-bs-toggle="modal" wire:click="mapnewuser({{$user->id}})" data-bs-target="#mapnewuser" class="badge text-bg-success text-decoration-none">Map</a>
                @if(Auth::user()->type == 'SU' || $user_type->level == '1')
                <a href="#" data-bs-toggle="modal" wire:click="transferuser({{$user->id}})" data-bs-target="#transferuser" class="badge text-bg-warning text-decoration-none">Transfer</a>
                @endif
                </td>
            </tr>
            
                <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Map User</h5>
                        </div>
                        <form method="post" action="{{url('user/mapuser/'.$user->id)}}">@csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-4">{{$user->name}}</div>
                                <div class="col-4">
                                    <select name="location" class="form-control">
                                        @if(Auth::user()->type == 'SU')
                                        @foreach($locations as $loc)
                                        <option value="{{$loc->id}}">{{$loc->location}}</option>
                                        @endforeach
                                        @else
                                        <option value="{{$current_user->userlevel->college}}">{{$current_user->userlevel->loc->location}}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="level" class="form-control">
                                        @if(Auth::user()->type == 'SU')
                                        <option value="4">Student</option>
                                        <option value="1">Local Admin</option>
                                        <option value="2">Local Admin Level 2</option>
                                        <option value="3">Local Admin Level 3</option>
                                        @else
                                        <option value="4">Student</option>
                                        <option value="2">Local Admin Level 2</option>
                                        <option value="3">Local Admin Level 3</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                        </div>
                        </div>
                        </form>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
        {{$users->links()}}
</div>