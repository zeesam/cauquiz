<div>
    <div class="row">
                    @if(Session::has('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          {{Session::get('message')}}
                          <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                          </button>
                        </div>
                        @endif
        <div class="col-sm-6">
            <div class="card">
            <h5 class="card-header">Select Your Suitable Quiz</h5>
                <div class="card-body">
                    <form wire:submit.prevent="choose">
                        <div class="row">
                            <div class="col-8">
                                <select class="form-control" wire:model.live="quiz_selected">
                                    <option>-- Please Select a Quiz --</option>
                                    @foreach($quizes as $quiz)
                                    @if($activated)
                                        <option value="{{$quiz->id}}">{{$quiz->quiz_category}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <h5 class="card-header">My Selections</h5>
                <div class="card-body">
                    <div class="row">
                    @foreach($quiz_chosen as $quiz)
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalquiz{{$quiz->id}}" class="btn btn-primary text-decoration-none">{{optional($quiz->quiz)->quiz_category}}</a> 
                                <br> <a href="#" data-bs-toggle="modal" data-bs-target="#modalrem{{$quiz->id}}" class="badge bg-danger text-decoration-none">Remove</a>
                            </div>
                            <div class="modal fade" id="modalquiz{{$quiz->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                                    </div>
                                    <div class="modal-body">
                                        Do you wish to start the {{optional($quiz->quiz)->quiz_category}} quiz?
                                        <p>Once you click on start, a countdown timer will begin</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a href="{{url('student-quizstart'.optional($quiz->quiz)->id)}}" class="btn btn-primary">Start Quiz</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="modalrem{{$quiz->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Remove from Selection</h1>
                                    </div>
                                    <div class="modal-body">
                                        Do you wish to remove the {{optional($quiz->quiz)->quiz_category}} quiz?
                                        <p>Once you click on remove, it will be removed from your account</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a href="#" wire:click="remove({{optional($quiz->quiz)->id}})" class="btn btn-primary">Remove Quiz</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
