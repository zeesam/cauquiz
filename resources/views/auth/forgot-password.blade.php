@extends('layouts.newuser')
@section('content')
<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
                    @if(Session::has('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          {{Session::get('message')}}
                          <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                          </button>
                        </div>
                        @endif
            <h3 class="mb-5">Password - Reset</h3>
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            <form method="post" action="{{route('password.email')}}">@csrf
                <div class="form-outline mb-2">
                @error('email') {{$message}} @enderror
                <input type="email" id="typeEmailX-2" name="email" class="form-control" />
                <label class="form-label" for="typeEmailX-2">Email</label>
                </div>
                <div class="form-outline mb-2">
                    <div class="form-group refereshrecapcha">
                        {!! captcha_img('flat') !!}
                    </div>
                <input type="text" id="pass-2" name="captcha" class="form-control" placeholder="Verify Captcha [Case Sensitive]" />
                @error('captcha') {{$message}} @enderror
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit">Send Link</button>
            </form>
            <hr class="my-4">
              <a href="{{url('login')}}">Back to Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

