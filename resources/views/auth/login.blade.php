@extends('layouts.newuser')
@section('content')
<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">Sign in</h3>
            <form method="post" action="{{route('login')}}">@csrf
                <div class="form-outline mb-2">
                @error('email') {{$message}} @enderror
                <input type="email" id="typeEmailX-2" name="email" class="form-control" />
                <label class="form-label" for="typeEmailX-2">Email</label>
                </div>

                <div class="form-outline mb-2">
                @error('password') {{$message}} @enderror
                <input type="password" id="typePasswordX-2" name="password" class="form-control" />
                <label class="form-label" for="typePasswordX-2">Password</label>
                </div>

                <div class="form-outline mb-2">
                    <div class="form-group refereshrecapcha">
                        {!! captcha_img('flat') !!}
                    </div>
                <input type="text" id="pass-2" name="captcha" class="form-control" placeholder="Verify Captcha [Case Sensitive]" />
                @error('captcha') {{$message}} @enderror
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            </form>
            <hr class="my-4">

            <a class="btn btn-lg btn-block btn-primary" href="{{url('googlelogin')}}" style="background-color: #dd4b39;"
              ><i class="fab fa-google me-2"></i> Sign in with Google</a><br><br>
              <a href="{{url('forgot-password')}}">Forgot Password?</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
