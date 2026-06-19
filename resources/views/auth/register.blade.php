@extends('layouts.newuser')
@section('content')
<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">Register a New Account</h3>
            <form method="post" action="{{route('register')}}">@csrf
            <div class="form-outline mb-2">
                @error('location') {{$message}} @enderror
                <select class="form-control" name="location">
                    <option value="-1">Select a College</option>
                    @foreach(App\Models\Location::all() as $loc)
                        <option value="{{$loc->id}}">{{$loc->location}}</option>
                    @endforeach
                </select>
                <label class="form-label" for="name-2">Select a College</label>
                </div>
            <div class="form-outline mb-2">
                @error('name') {{$message}} @enderror
                <input type="text" id="name-2" name="name" class="form-control" />
                <label class="form-label" for="name-2">Full Name</label>
                </div>
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
                @error('password_confirmation') {{$message}} @enderror
                <input type="password" id="pass-2" name="password_confirmation" class="form-control" />
                <label class="form-label" for="pass-2">Confirm Password</label>
                </div>
                <div class="form-outline mb-2">
               
                {!! captcha_img('flat') !!}
                <input type="text" id="pass-2" name="captcha" class="form-control" placeholder="Verify Captcha [Case Sensitive]" />
                @error('captcha') {{$message}} @enderror
                </div>
                <button class="btn btn-primary btn-lg btn-block" type="submit">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
