<div wire:ignore.self class="modal fade" id="transferuser" tabindex="-1" aria-labelledby="transferuser" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="transferuser">Transfer User</h5>
        </div>
        <form method="post" wire:submit.prevent="transferusersave">@csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-4">{{$this->name}}</div>
                <div class="col-4">
                    <select wire:model="location" class="form-control">
                        @foreach($locations as $loc)
                        <option value="{{$loc->id}}">{{$loc->location}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <select wire:model="level" class="form-control">
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
            <button type="button" class="btn btn-sm btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-sm btn-primary">Proceed</button>
        </div>
        </div>
        </form>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="mapnewuser" tabindex="-1" aria-labelledby="mapnewuser" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="mapnewuser">Map User</h5>
        </div>
        <form method="post" wire:submit.prevent="newusersave">@csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-4">{{$this->name}}</div>
                <div class="col-4">
                    <select wire:model="location" class="form-control">
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
                    <select wire:model="level" class="form-control">
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