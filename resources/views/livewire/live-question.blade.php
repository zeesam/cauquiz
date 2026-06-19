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
                <form method="post" wire:submit.prevent="create">@csrf
                <label for="exampleFormControlSelect1">Select a Quiz Category</label>
                <select wire:model="quiz_id" class="form-control" id="exampleFormControlSelect1">
                    <option>Select a Quiz Category</option>
                    @foreach($quizes as $quiz)
                    <option value="{{$quiz->id}}">{{$quiz->quiz_category}}</option>
                    @endforeach
                </select>
                </div>
                    <div class="form-group">
                    <label for="question">Question</label>
                    <input type="text" wire:model="question" class="form-control @error('question') is-invalid @enderror" id="question" >
                    @error('question')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="ques_image">Upload a diagram/Image (Optional)</label>
                        <input type="file" wire:model="ques_image" class="form-control @error('ques_image') is-invalid @enderror" id="ques_image" >
                        @error('ques_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    Answer:<br>
                    <div class="container">
                    <div class="row">
                        <div class="col-sm">
                        <input type="text" wire:model="optiona" class="form-control @error('optiona') is-invalid @enderror" placeholder="Option A" >
                        </div>
                        <div class="col-sm">
                        <input type="radio" value="optiona" wire:model="correct_ans" class="@error('correct_ans') is-invalid @enderror"> Correct Answer
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm">
                        <input type="text" wire:model="optionb" class="form-control @error('optionb') is-invalid @enderror" placeholder="Option B" >
                        </div>
                        <div class="col-sm">
                        <input type="radio" value="optionb" wire:model="correct_ans" class="@error('correct_ans') is-invalid @enderror"> Correct Answer
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm">
                        <input type="text"  wire:model="optionc" class="form-control @error('optionc') is-invalid @enderror" placeholder="Option C" >
                        </div>
                        <div class="col-sm">
                        <input type="radio" value="optionc" wire:model="correct_ans" class="@error('correct_ans') is-invalid @enderror"> Correct Answer
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm">
                        <input type="text" wire:model="optiond" class="form-control @error('optiond') is-invalid @enderror" placeholder="Option D" >
                        </div>
                        <div class="col-sm">
                        <input type="radio" value="optiond" wire:model="correct_ans" class="@error('correct_ans') is-invalid @enderror"> Correct Answer
                        </div>
                    </div>
                    @error('correct_ans')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div><br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
</div>
