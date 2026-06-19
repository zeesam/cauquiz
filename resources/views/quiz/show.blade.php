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
                            <div class="card-header d-flex justify-content-between"
                                <h5>All "{{$quiz->quiz_category}}" Questions</h5>
                                <button class="btn btn-success" onclick="printDiv('printableArea')"><i class="fa-solid fa-print"></i></button>
                            </div>
                          <div class="card-body small">
                            <table class="table table-sm">
                              @foreach($questions as $key=>$question)
                              <thead class="thead-dark">
                                <tr>
                                  <th scope="col" colspan="2">Question {{$key+1}}: {{$question->question}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    @if($question->quest_img != null)
                                  <th><img src="{{asset('question_image/'.$question->quest_img)}}" height="200px" width="200px"><br>
                                  @endif
                                  </th>
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
                                </tr>
                                  <tr>
                                  <td colspan="2">Correct Answer:
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
                                </tr>
                              </tbody>
                              @endforeach
                            </table>
                            {{$questions->links()}}
                          </div>

                          <div id="printableArea" style="display: none;">
                                <h4 align="center">{{$quiz->loc->location}}</h4>
                                <h6 align="center">Central Agricultural University Imphal</h6>
                                <hr style="border:3px solid black;">
                                <h5>All "{{$quiz->quiz_category}}" Questions</h5>
                                <h6>Prepared by:<br>
                                @foreach($questions_p->unique('added_by') as $question)
                                    &emsp;{{$question->user->name}}<br>
                                @endforeach
                                </h6>
                          <div class="card-body small">
                            <table class="table table-sm">
                              @foreach($questions_p as $key=>$question)
                                <tr>
                                  <th scope="col" colspan="2">Question {{$key+1}}: {{$question->question}}</th>
                                </tr>
                                <tr>
                                    @if($question->quest_img != null)
                                  <th><img src="{{asset('question_image/'.$question->quest_img)}}" height="200px" width="200px"><br>
                                  @endif
                                  </th>
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
                                </tr>
                                  <tr>
                                  <td colspan="2">Correct Answer:
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
                                </tr>
                              @endforeach
                            </table>
                          </div>
                          <p style="font-size:11px" align="right">Printed by: {{Auth::user()->name}} IP Address: {{$_SERVER['REMOTE_ADDR']}} Date & Time: <?php
                                date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
                            echo date('d-m-Y H:i:s');
                            ?></p>
                          </div>
                            <script>
                                function printDiv(divId) {
                                        document.getElementById("printableArea").style.display="block"
                                     var printContents = document.getElementById(divId).innerHTML;
                                     var originalContents = document.body.innerHTML;
                                
                                     document.body.innerHTML = printContents;
                                
                                     window.print();
                                
                                     document.body.innerHTML = originalContents;
                                     document.getElementById("printableArea").style.display="none"
                                }
                            </script>
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
