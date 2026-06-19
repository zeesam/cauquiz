<div>

<input type="text" wire:model.live="search" class="form-control" name="search" /><br>
        
            @if(isset($students_fil))
            Search Result:
            <table class="table table-sm text-xs">
            <thead class="table-dark">
            <tr>
                <th>Sl.No.</th>
                <th>Student Name</th>
                <th>Mark Obtained</th>
                <th>Full Mark</th>
                <th>Percentage</th>
                <th>Action</th>
            </tr>
            </thead>
                <tr>
                    <td>{{1}}</td>
                    <td>{{$students_fil->username->name}}</td>
                    <td>
                    @php
                        echo $mark = count(DB::table($table)->where('user_id',$students_fil->user_id)->where('user_ans',DB::raw('correct_ans'))->get());
                    @endphp
                    </td>
                    <td>
                    @php
                        echo $full_mark = count(DB::table($table)->where('user_id',$students_fil->user_id)->get());
                    @endphp
                    </td>
                    <td>
                    @php
                        $pc = ($mark * 100)/$full_mark;
                        echo number_format((float)$pc, 2, '.', '');;
                    @endphp
                    </td>
                    <td>
                        <form method="post" action="{{url('result-studentwise'.$students_fil->user_id)}}">@csrf
                            <input type="hidden" value="{{$quiz->id}}" name="quiz_id"/>
                        <button type="submit" class="badge bg-success text-decoration-none">View Result</button>
                        </form>
                        </td>
                </tr>
        </table>
        @endif
    <table class="table table-sm text-xs">
        <thead class="table-dark">
        <tr>
            <th>Sl.No.</th>
            <th>Student Name</th>
            <th>Mark Obtained</th>
            <th>Full Mark</th>
            <th>Percentage</th>
            <th>Action</th>
        </tr>
        </thead>
        @foreach($students as $key=>$stud)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$stud->username->name}}</td>
            <td>
            @php
                echo $mark = count(DB::table($table)->where('user_id',$stud->user_id)->where('user_ans',DB::raw('correct_ans'))->get());
            @endphp
            </td>
            <td>
            @php
                echo $full_mark = count(DB::table($table)->where('user_id',$stud->user_id)->get());
            @endphp
            </td>
            <td>
            @php
                $pc = ($mark * 100)/$full_mark;
                echo number_format((float)$pc, 2, '.', '');;
            @endphp
            </td>
            <td>
                <form method="post" action="{{url('result-studentwise'.$stud->user_id)}}">@csrf
                    <input type="hidden" value="{{$quiz->id}}" name="quiz_id"/>
                <button type="submit" class="badge bg-success text-decoration-none">View Result</button>
                </form>
                </td>
        </tr>
        @endforeach
    </table>
</div>
