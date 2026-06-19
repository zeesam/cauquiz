<?php

namespace App\Http\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\User;
use App\Models\Location;
use App\Models\MapUser;
use App\Notifications\ApprovalNotification;
use Auth;
use Livewire\WithPagination;

class LiveSearchUser extends Component
{
    use WithPagination;
    public $search = '';
    public $search_fac = '';
    public $name = "User Map Success";
    public $location;
    public $level = '4';
    public $user_id;
    public $stat;
    protected $paginationTheme = 'bootstrap';
    
    public function mount()
    {
        $this->stat = false;
        if(Auth::user()->type == 'SU'){
            $this->location = 9;
        }
        else{
            $this->location = Auth::user()->location;
        }
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $current_user = User::where('id',Auth::user()->id)->first();
        if(Auth::user()->type == 'SU')
        {
            $users = User::where(function ($query){
            $query->where('name','LIKE','%'.$this->search.'%')
            ->where('id','!=',1)
            ->orWhere('email','LIKE','%'.$this->search.'%');
        })
        ->orderBy('id','DESC')
        ->paginate(20);
        }
        else{
        $users = User::where(function ($query){
            $query->where('name','LIKE','%'.$this->search.'%')
            ->where('id','!=',1)
            ->where('location',Auth::user()->location);
            //->orWhere('email','LIKE','%'.$this->search.'%');
        })
        ->orderBy('id','DESC')
        ->paginate(20);
        }
        $users_fac = User::orderBy('id','DESC')->where([
            ['name','LIKE','%'.$this->search_fac.'%'],
            ['id','!=',1],
            ['type','=','Faculty']])
            ->orWhere('email','LIKE','%'.$this->search_fac.'%')
        ->paginate(5);
        $locations = Location::orderBy('location','ASC')->get();
        $user_type = MapUser::where('user_id',Auth::user()->id)->first();
        return view('livewire.live-search-user', [
            'users' => $users,
            'locations'=> $locations,
            'current_user' => $current_user,
            'users_fac'=>$users_fac,
            'user_type'=>$user_type
        ]);
    }
    
    public function transferuser($id){
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->user_id = $user->id;
        //Check if exist
        if(MapUser::where('user_id',$id)->first() == null)
        {
            $this->stat = false;
        }
        else
        {
            $this->stat = true;
        }
    }
    
    public function mapnewuser($id){
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->user_id = $user->id;
        if(MapUser::where('user_id',$id)->first() == null)
        {
            $this->stat = false;
        }
        else
        {
            $this->stat = true;
        }
    }
    public function newusersave(){
        if($this->stat == true)
        {
            Session()->flash('message','User already Mapped!');
        }
        else{
            $user = User::where('id',$this->user_id)->first();
            $notice = [
                    'name' => $user->name
                ];
            $saver = new MapUser;
            $saver->user_id = $this->user_id;
            $saver->college = $this->location;
            $saver->level = $this->level;
            $saver->save();
            if($this->level != 4)
            {
                $user->type = 'Faculty';
            }
            $user->save();
            $user->notify(new ApprovalNotification($notice));
            Session()->flash('message','User Mapped!');
        }
        $this->stat = false;
        //$this->reset();
        $this->dispatchBrowserEvent('close-modal');
    }
    public function transferusersave(){
        //sleep(5);
        $user = User::where('id',$this->user_id)->first();
        $notice = [
                    'name' => $user->name
                ];
        if($this->stat == false){
                $saver = new MapUser;
                $saver->user_id = $this->user_id;
                $saver->college = $this->location;
                $saver->level = $this->level;
                $user->location = $this->location;
                if($this->level != 4)
                {
                    $user->type = 'Faculty';
                }
                $user->save();
                $saver->save();
                $user->notify(new ApprovalNotification($notice));
                Session()->flash('message','User Mapped!');
            }
            else{
                $saver = MapUser::where('user_id',$this->user_id)->first();
                $saver->user_id = $this->user_id;
                $saver->college = $this->location;
                $saver->level = $this->level;
                $user->location = $this->location;
                if($this->level != 4)
                {
                    $user->type = 'Faculty';
                }
                $user->save();
                $saver->save();
                $user->notify(new ApprovalNotification($notice));
                Session()->flash('message','User Transferred!');
            }
        $this->stat = false;
        //$this->reset();
        $this->dispatchBrowserEvent('close-modal');
    }
    public function closeModal()
    {
        //$this->reset();
    }
}
