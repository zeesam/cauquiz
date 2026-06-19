<div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="card-body">
        <div class="container">
            <div class="text-sm py-3 text-center">
                <div class="row justify-content-center gx-5">
                    <div class="col-2 bg-warning p-3">Current Question</div> 
                    <div class="col-2 bg-danger p-3">Un-answered Question</div>
                    <div class="col-2 bg-success p-3">Answered Question</div>
                    <div class="col-3"></div>
                    <div class="col-3">
                    <div class="text-right">
                    <h4 id="demo" class="text-right text-info px-4" align="right"></h4>
                    </div>
                        <script>
                        var x = "<?php echo $quiz_timer->date_time; ?>"; 
                        document.write(x);
                        var countDownDate = new Date(x).getTime();

                        // Update the count down every 1 second
                        var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();
                            
                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;
                            
                        // Time calculations for days, hours, minutes and seconds
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            
                        // Output the result in an element with id="demo"
                        document.getElementById("demo").innerHTML = hours + "h "
                        + minutes + "m " + seconds + "s ";
                            
                        // If the count down is over, write some text 
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("demo").innerHTML="EXPIRED";
                            $(document).ready(function(){
                                  $("#staticBackdrop").modal("show");
                                });
                        }
                        }, 1000);
                        </script>
                        
                    </div>
                </div>
            </div>
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Oops!</h5>
                      </div>
                      <div class="modal-body">
                        Exam time is over! You data is saved! You will be redirected to Dashboard
                      </div>
                      <div class="modal-footer">
                            <form wire:submit.prevent="final_sub">
                                 <button class="btn btn-danger">Understood</button>
                            </form>
                      </div>
                    </div>
                  </div>
                </div> 
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                <h5 class="card-header">Question</h5>
                <div class="card-body">
                    <?php $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    $page_no = substr($actual_link,63);
                    $ques = count($all_ques);
                    if($page_no == null || $page_no == 0){
                        $page_no = 1;
                    }
                    elseif($page_no == 10){
                        $page_no = $ques;
                        
                    }
                    else{
                    $page_no = substr($actual_link,63);
                    }
                    ?>
                    <div class="row">
                        <div class="col">
                    @foreach($questions as $key=>$question)
                    <h5 class="card-title">Question {{$question->quest_no}}: {{$question->question}}</h5>
                    @if($question->quest_img == null)
                    <form>
                        <ol type="A">
                            <li><input type="radio" name="cor" wire:model.defer="correct_ans" value="optiona"> {{$question->optiona}} </li>
                            <li><input type="radio" name="cor" wire:model.defer="correct_ans" value="optionb"> {{$question->optionb}} </li>
                            <li><input type="radio" name="cor" wire:model.defer="correct_ans" value="optionc"> {{$question->optionc}} </li>
                            <li><input type="radio" name="cor" wire:model.defer="correct_ans" value="optiond"> {{$question->optiond}} </li>
                        </ol>
                        <button wire:click.prevent="answer({{$question->id}})" class="btn btn-sm btn-success">Save</button>
                    </form>
                    @else
                    <div class="row">
                        <div class="col-6">
                            <form>
                                <ol type="A">
                                    <li><input type="radio" name="cor" wire:model.defer="correct_ans" value="optiona"> {{$question->optiona}} </li>
                                    <li><input type="radio" name="cor" wire:model.defer="correct_ans" value="optionb"> {{$question->optionb}} </li>
                                    <li><input type="radio" name="cor" wire:model.defer="correct_ans" value="optionc"> {{$question->optionc}} </li>
                                    <li><input type="radio" name="cor" wire:model.defer="correct_ans" value="optiond"> {{$question->optiond}} </li>
                                </ol>
                                <button wire:click.prevent="answer({{$question->id}})" class="btn btn-sm btn-success">Save</button>
                            </form>
                        </div>
                        <div class="col-6">
                            <img src="{{asset('question_image/'.$question->quest_img)}}" height="200px" width="200px">
                        </div>
                    </div>
                    @endif
                    <br>
                    Your Answer: 
                            @if($question->user_ans == 'optiona')
                                Option A
                            @elseif($question->user_ans == 'optionb')
                                Option B
                            @elseif($question->user_ans == 'optionc')
                                Option C
                            @elseif($question->user_ans == 'optiond')
                                Option D
                            @else
                                Not Submitted
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row text-center">
                        <div class="col">
                            <a href="https://cauimphal.online/quizapp/public/student-quizstart{{$question->quiz_id}}?page={{$question->quest_no-1}}" class="btn btn-info">Previous Question</a> 
                        </div>          
                        <div class="col pull-right">
                            @if($ques != $question->quest_no)
                            <a href="https://cauimphal.online/quizapp/public/student-quizstart{{$question->quiz_id}}?page={{$question->quest_no+1}}" class="btn btn-info">Next Question</a> 
                            @endif
                        </div>
                    </div>
                    @if($ques == $question->quest_no)
                    <br><hr>
                    <div class="row text-center">
                        <div class="col">
                             <form wire:submit.prevent="final_sub">
                                 <button class="btn btn-danger">Final Submit</button>
                             </form>
                         </div>
                     </div>
                    @endif
                    @endforeach
                </div>
                </div><br>
                @if(Session::has('message'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{Session::get('message')}}
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                    @endif
            </div>
            <div class="col-sm-6">
                <div class="card">
                <h5 class="card-header">All Questions</h5>
                    <div class="card-body text-center">
                        <div class="row">
                            @foreach($all_ques as $key=>$que)
                            <a href="https://cauimphal.online/quizapp/public/student-quizstart{{$question->quiz_id}}?page={{$key+1}}"
                             class="col-2 mx-1 my-1 p-2 border border-primary text-decoration-none text-white
                             @if($question->quest_no == $que->quest_no) bg-warning @elseif($que->user_ans) bg-success @else bg-danger @endif
                             "> 
                            <div>{{$key+1}}</div></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <script type='text/javascript'>

        (function()
        {
        if( window.localStorage )
        {
            if( !localStorage.getItem('firstLoad') )
            {
            localStorage['firstLoad'] = true;
            window.location.reload();
            }  
            else
            localStorage.removeItem('firstLoad');
        }
        })();

        </script>
</div>
