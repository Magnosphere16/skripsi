@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto mt-5">
        <div class="card flex-row my-7 border-0 shadow rounded-3 overflow-hidden">
          <div class="card-img-left d-none d-md-flex">
          </div>
          <div class="card-body p-4 p-sm-5">
              <div class="mb-5">
                <h5 class="fw-light fs-5"><strong>Register</strong></h5>
              </div>
            <form>
              <div class="form-floating mb-3">
                <label for="floatingInputUsername">Username</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror              
                </div>

              <div class="form-floating mb-3">
                <label for="floatingInputEmail">Email address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

                <div class="form-floating mb-3">
                <label for="floatingInputUsername">Birthdate</label>
                <input id="name" type="date" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror              
                </div>

                <div class="form-floating mb-3">
                <label for="floatingInputUsername">Address</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror              
                </div>

                <div class="form-floating mb-3">
                <label for="floatingInputUsername">Phone Number</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror              
                </div>

                <div class="form-floating mb-3">
                <label for="floatingInputUsername">Business Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror              
                </div>

                <div class="form-floating mb-3">
                <label for="floatingInputUsername">Business Category</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror              
                </div>

              <hr>

              <div class="form-floating mb-3">
                <label for="floatingPassword">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-floating mb-3">
                <label for="floatingPasswordConfirm">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
              </div>


              <div class="d-grid mb-2">
                <button type="submit" class="btn btn-primary">
                    {{ __('Sign Up') }}
                </button>
              </div>

              <a class="d-block text-center mt-2 small" href="{{ route('login') }}">Have an account? Sign In</a>

              <!-- <hr class="my-4">

              <div class="d-grid mb-2">
                <button class="btn btn-lg btn-google btn-login fw-bold text-uppercase" type="submit">
                  <i class="fab fa-google me-2"></i> Sign up with Google
                </button>
              </div>

              <div class="d-grid">
                <button class="btn btn-lg btn-facebook btn-login fw-bold text-uppercase" type="submit">
                  <i class="fab fa-facebook-f me-2"></i> Sign up with Facebook
                </button>
              </div> -->

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
