<div>
    <style>
#row1 {
  background: #4CAF50;
  color: white;
  padding: 15px;
  width: 50%;
  height: 500px;
  overflow: scroll;
  border: 1px solid #ccc;
}

#row2 {
  background: green;
  color: white;
  padding: 15px;
  width: 50%;
  height: 500px;
  overflow: scroll;
  border: 1px solid #ccc;
}
</style>
 @if(Session::has('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          {{Session::get('message')}}
                          <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                          </button>
                        </div>
                        @endif
    <div class="row">
        <div class="col-6" id="row1">
            Select the Student
            <input type="text" wire:model.live="search" class="form-control">
            <table class="table">
                <!--
                <tr>
                    <td></td><td><input type="checkbox" onclick="toggle(this);" /> Select all</td>
                </tr>
                -->
            @foreach($users as $key=>$user)
            @if(App\Models\StudentSelectedForExam::where('user_id',$user->id)->where('quiz_id',$quiz_id)->first() == null)
            <tr>
                <td>{{$user->user_name}}</td><td><input type="checkbox" wire:click="student_checked({{$user->id}})"></td>
            </tr>
            @endif
            @endforeach
            </table>
            <script>
                function toggle(source) {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i] != source)
                            checkboxes[i].checked = source.checked;
                    }
                }
            </script>
        </div>
        <div class="col-6" id="row2">
            Selected Students List<hr>
            <table class="table text-white">
                @foreach($selected_students as $key=>$user)
                <tr>
                    <td><a class="text-white text-decoration-none" href="#" wire:click="student_rem({{$user->user_id}})">{{$user->users->name}}</a></td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
