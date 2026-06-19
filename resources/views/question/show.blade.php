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
                          <h5 class="card-header">All Questions</h5>
                          <div class="card-body small">
                            <table class="table">
                              <thead class="thead-dark">
                                <tr>
                                  <th scope="col" colspan="2">Question: {{$question->question}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    @if($question->quest_img != null)
                                  <th><img src="{{asset('question_image/'.$question->quest_img)}}" height="200px" width="200px"><br>
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
                            </table>
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
