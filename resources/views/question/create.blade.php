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
                        <div class="col-9">
                            @if(Session::has('message'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{Session::get('message')}}
                                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                            @endif
                            <div class="card">
                                <h5 class="card-header">Create Question</h5>
                                <div class="card-body">
                                    <div class="form-group">
                                    <form method="post" enctype="multipart/form-data" action="{{url('createques')}}">@csrf
                                    <label for="exampleFormControlSelect1">Select a Quiz Category</label>
                                    <select name="quiz_id" class="form-control" id="exampleFormControlSelect1">
                                        <option>Select a Quiz Category</option>
                                        @foreach($quizes as $quiz)
                                        <option value="@if($quiz->shared_id == null){{$quiz->id}}@else{{$quiz->shared_id}}@endif">{{$quiz->quiz_category}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                        <div class="form-group">
                                        <label for="question">Question</label>
                                        <input type="text" name="question" class="form-control" id="question" >
                                        @error('question')
                                                <strong>{{ $message }}</strong>
                                        @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                            <div class="form-group">
                                                <label for="ques_image">Upload a diagram/Image (Optional)</label>
                                                <input type="file" name="ques_image" class="form-control" accept="image/*" id="ques_image" >
                                                @error('ques_image')
                                                        <strong style="color:red">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            </div>
                                            <div class="col-sm">
                                                <ul>
                                                    <li>Will accept only image</li>
                                                    <li>Size limit is only 100KB</li>
                                                </ul>
                                            </div>
                                        </div>
                                        Answer:<br>
                                        <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                            <input type="text" name="optiona" class="form-control" placeholder="Option A" >
                                                @error('optiona')
                                                        <strong>{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-sm">
                                            <input type="radio" value="optiona" name="correct_ans" class="@error('correct_ans') is-invalid @enderror"> Correct Answer
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-sm">
                                            <input type="text" name="optionb" class="form-control" placeholder="Option B" >
                                                @error('optionb')
                                                        <strong>{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-sm">
                                            <input type="radio" value="optionb" name="correct_ans" class="@error('correct_ans') is-invalid @enderror"> Correct Answer
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-sm">
                                            <input type="text"  name="optionc" class="form-control" placeholder="Option C" >
                                                @error('optionc')
                                                        <strong>{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-sm">
                                            <input type="radio" value="optionc" name="correct_ans" class="@error('correct_ans') is-invalid @enderror"> Correct Answer
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-sm">
                                            <input type="text" name="optiond" class="form-control" placeholder="Option D" >
                                                @error('optiond')
                                                        <strong>{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-sm">
                                            <input type="radio" value="optiond" name="correct_ans" class="@error('correct_ans') is-invalid @enderror"> Correct Answer
                                            </div>
                                        </div>
                                        @error('correct_ans')
                                            <span class="bg-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div><br>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
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
