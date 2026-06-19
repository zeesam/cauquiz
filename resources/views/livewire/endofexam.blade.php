
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                  <div class="container">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card">
                            <h5 class="card-header">Exam Over</h5>
                            <div class="card-body">
                                <h5 class="card-title">Exam time is Over</h5>
                                <p class="text-success" style="font-size:20px">Dear {{Auth::user()->name}}<br>
                                Your Exam time has expired!</p>
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

