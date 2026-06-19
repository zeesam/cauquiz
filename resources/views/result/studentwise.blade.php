@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}<form method="post" action="{{url('result-quizwise'.$table_map->quiz_id)}}">@csrf
                                        <button type="submit" class="badge bg-success text-decoration-none">Go Back</button>
                                        </form></div>

                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card">
                          <h5 class="card-header">Result - {{$user->name}} </h5>
                          <div class="card-body">
                          <h5 class="card-header">All Questions</h5>
                          <div class="card-body small">
                          <table class="table table-sm">
                              @foreach($data as $key=>$question)
                              <thead class="thead-dark">
                                <tr>
                                  <th scope="col" colspan="2">Question {{$key+1}}: {{$question->question}}</th>
                                  <th scope="col">Your Answer</th>
                                  <th scope="col">Correct Answer</th>
                                  <th scope="col">Result</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th scope="row">
                                      @if($question->quest_img)
                                      <img src="{{asset('question_image/'.$question->quest_img)}}" height="200px" width="300px"><br>
                                      @endif
                                      Answer:</th>
                                  <td>
                                    1. @if($question->correct_ans == 'optiona')
                                     <div class="badge text-bg-primary text-wrap">
                                      {{$question->optiona}}
                                     </div>
                                     @else
                                      {{$question->optiona}}
                                      @endif
                                     <br>
                                     2. @if($question->correct_ans == 'optionb')
                                      <div class="badge text-bg-primary text-wrap">
                                       {{$question->optionb}}
                                      </div>
                                      @else
                                       {{$question->optionb}}
                                       @endif
                                      <br>
                                      3. @if($question->correct_ans == 'optionc')
                                       <div class="badge text-bg-primary text-wrap">
                                        {{$question->optionc}}
                                       </div>
                                       @else
                                        {{$question->optionc}}
                                        @endif
                                       <br>
                                       4. @if($question->correct_ans == 'optiond')
                                        <div class="badge text-bg-primary text-wrap">
                                         {{$question->optiond}}
                                        </div>
                                        @else
                                         {{$question->optiond}}
                                         @endif
                                        <br>
                                  </td>
                                  <td>Your Answer:
                                    @if($question->user_ans == 'optiona')
                                        {{$question->optiona}}
                                        @elseif($question->user_ans == 'optionb')
                                        {{$question->optionb}}
                                        @elseif($question->user_ans == 'optionc')
                                        {{$question->optionc}}
                                        @elseif($question->user_ans == 'optiond')
                                        {{$question->optiond}}
                                    @endif
                                  </td>
                                  <td>Correct Answer:
                                    @if($question->correct_ans == 'optiona')
                                    {{$question->optiona}}
                                    @elseif($question->correct_ans == 'optionb')
                                    {{$question->optionb}}
                                    @elseif($question->correct_ans == 'optionc')
                                    {{$question->optionc}}
                                    @elseif($question->correct_ans == 'optiond')
                                    {{$question->optiond}}
                                    @endif
                                  </td>
                                  <td>
                                    @if($question->correct_ans == $question->user_ans)
                                    <div class="badge text-bg-success text-wrap">
                                       Correct
                                    </div>
                                    @else
                                    <div class="badge text-bg-danger text-wrap">
                                       Incorrect
                                    </div>
                                    @endif
                                  </td>
                                </tr>
                              </tbody>
                              @endforeach
                            </table>
                            Total score - 
                            @php 
                            echo $mark = count(DB::table($table)->where('user_id',$user->id)->where('user_ans',DB::raw('correct_ans'))->get()); 
                            @endphp
                            out of @php
                            echo $full_mark = count(DB::table($table)->where('user_id',$user->id)->get());
                            @endphp <br>
                            Percentage - 
                                @php
                                      $pc = ($mark * 100)/$full_mark;
                                      echo number_format((float)$pc, 2, '.', '');
                                    @endphp
                                %
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
</div>
@endsection
