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
                <label for="floatingInputUsername">Full Name</label>
                <input id="userName" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>         
                <span id="error_name"></span>  
              </div>

              <div class="form-floating mb-3">
                <label for="floatingInputEmail">Email address</label>
                <input id="user_email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                <span id="error_email"></span>
              </div>

                <div class="form-floating mb-3">
                <label for="floatingInputBirthddate">Birthdate</label>
                <input id="name" type="date" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror              
                </div>

                <div class="form-floating mb-3">
                <label for="floatingInputAddress">Address</label>
                <input id="userAddress" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    <span id="error_address"></span>          
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
                <button type="submit" class="btn btn-primary" id="register" style="disabled:false;">
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
  <script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    $(document).ready(function(){

            //check email availability, formats, and existence
                $('#user_email').blur(function() {
                    var error_email='';
                    var email =  $('#user_email').val();
                    var filter =/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    if(email==''){
                        $('#error_email').html('<label class="text-danger">Email must be filled</label>');
                        $('#user_email').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else{
                            if(!filter.test(String(email).toLowerCase())){   
                                $('#error_email').html('<label class="text-danger">Invalid Email Format</label>');
                                $('#user_email').addClass('has-error');
                                $('#register').attr('disabled', 'disabled');
                            }
                            else{
                                $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                        url:"/CheckEmail",
                                        method: "POST",
                                        data:{email:email},
                                        success:function(result){
                                            if(result=='unique'){
                                                $('#error_email').html('<label class="text-success">Email Available</label>');
                                                $('#user_email').removeClass('has-error');
                                                $('#register').attr('disabled', false);
                                            }else{
                                                $('#error_email').html('<label class="text-danger">Email already exist</label>');
                                                $('#user_email').addClass('has-error');
                                                $('#register').attr('disabled', 'disabled');
                                            }
                                        }
                                    })
                                }
                        }
                    })

        //check address availability
            $('#userAddress').blur(function(){
                    var error_address='';
                    var address =  $('#userAddress').val();
                    if(address==''){
                        $('#error_address').html('<label class="text-danger">Address must be filled</label>');
                        $('#userAddress').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else{
                            $('#error_address').html('');
                            $('#userAddress').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        }
                });
        //Check user Full Name Availability
                $('#userName').blur(function(){
                    var error_name='';
                    var name =  $('#userName').val();
                    if(name==''){
                        $('#error_name').html('<label class="text-danger">Full name must be filled</label>');
                        $('#userName').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else{
                            $('#error_name').html('');
                            $('#userName').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        }
                });

        // //check school availability
        //     $('#school_name').blur(function(){
        //             var error_school='';
        //             var school =  $('#school_name').val();
        //             if(school==''){
        //                 $('#error_school').html('<label class="text-danger">School name must be filled</label>');
        //                 $('#school_name').addClass('has-error');
        //                 $('#register').attr('disabled', 'disabled');
        //             }else{
        //                     $('#error_school').html('');
        //                     $('#school_name').removeClass('has-error');
        //                     $('#register').attr('disabled', false);
        //                 }
        //         });
        // //check province availability
        //     $('#province_id').blur(function(){
        //         var error_province='';
        //         var province =  $('#province_id').val();
        //         if(province==''){
        //             $('#error_province').html('<label class="text-danger">Province must be filled</label>');
        //             $('#province_id').addClass('has-error');
        //             $('#register').attr('disabled', 'disabled');
        //         }else{
        //                     $('#error_province').html('');
        //                     $('#province_id').removeClass('has-error');
        //                     $('#register').attr('disabled', false);
        //                 }
        //     });
        // //check education level
        //     $('#educ_level_id').blur(function(){
        //         var error_educ_level='';
        //         var educ_level =  $('#educ_level_id').val();
        //         if(educ_level==''){
        //             $('#error_educ_level').html('<label class="text-danger">Education Level must be filled</label>');
        //             $('#educ_level_id').addClass('has-error');
        //             $('#register').attr('disabled', 'disabled');
        //         }else{
        //                     $('#error_educ_level').html('');
        //                     $('#educ_level_id').removeClass('has-error');
        //                     $('#register').attr('disabled', false);
        //                 }
        //     });
                
        //   //check scholar status availability
        //     $('#scholar_status').blur(function(){
        //             var error_status='';
        //             var status =  $('#scholar_status').val();
        //             if(status==''){
        //                 $('#error_status').html('<label class="text-danger">Scholar status must be filled</label>');
        //                 $('#scholar_status').addClass('has-error');
        //                 $('#register').attr('disabled', 'disabled');
        //             }else{
        //                     $('#error_status').html('');
        //                     $('#scholar_status').removeClass('has-error');
        //                     $('#register').attr('disabled', false);
        //                 }
        //         });
        //     //check birthdate
        //     $('#birthdate').blur(function(){
        //             var error_birthdate='';
        //             var birthdate =  $('#birthdate').val();
        //             if(birthdate==''){
        //                 $('#error_birthdate').html('<label class="text-danger">Birthdate must be filled</label>');
        //                 $('#birthdate').addClass('has-error');
        //                 $('#register').attr('disabled', 'disabled');
        //             }else{
        //                     $('#error_birthdate').html('');
        //                     $('#birthdate').removeClass('has-error');
        //                     $('#register').attr('disabled', false);
        //                 }
        //         });

        //     //check password availability
        //     $('#password').blur(function(){
        //             var error_password='';
        //             var password =  $('#password').val();
        //             if(password==''){
        //                 $('#error_password').html('<label class="text-danger">Password must be filled</label>');
        //                 $('#password').addClass('has-error');
        //                 $('#register').attr('disabled', 'disabled');
        //             }else{
        //                     $('#error_password').html('');
        //                     $('#password').removeClass('has-error');
        //                     $('#register').attr('disabled', false);
        //                 }
        //         });
        //     //check password confirm availability
        //     $('#password-confirm').blur(function(){
        //             var error_confirm='';
        //             var confirm =  $('#password-confirm').val();
        //             if(confirm==''){
        //                 $('#error_confirm').html('<label class="text-danger">Confirm your password</label>');
        //                 $('#password-confirm').addClass('has-error');
        //                 $('#register').attr('disabled', 'disabled');
        //             }else{
        //                 $('#error_confirm').html('');
        //                 $('#password-confirm').removeClass('has-error');
        //                 $('#register').attr('disabled', false);
        //                 }
        //         });

        //     //check username availability and existence
        //         $('#name').blur(function(){
        //             var error_name='';
        //             var name =  $('#name').val();
        //             if(name==''){
        //                 $('#error_name').html('<label class="text-danger">Username must be filled</label>');
        //                 $('#name').addClass('has-error');
        //                 $('#register').attr('disabled', 'disabled');
        //             }else{
        //                     $('#error_name').html('<label class="text-success">Username Available</label>');
        //                     $('#name').removeClass('has-error');
        //                     $('#register').attr('disabled', false);
        //                 }
        //             });

        //     //check email availability and formats
        //         $('#user_email').blur(function() {
        //             var error_email='';
        //             var email =  $('#user_email').val();
        //             var filter =/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        //             if(email==''){
        //                 $('#error_email').html('<label class="text-danger">Email must be filled</label>');
        //                 $('#user_email').addClass('has-error');
        //                 $('#register').attr('disabled', 'disabled');
        //             }else{
        //                     if(!filter.test(String(email).toLowerCase())){   
        //                         $('#error_email').html('<label class="text-danger">Invalid Email Format</label>');
        //                         $('#user_email').addClass('has-error');
        //                         $('#register').attr('disabled', 'disabled');
        //                     }
        //                     else{
        //                         $.ajaxSetup({
        //                         headers: {
        //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                             }
        //                         });
        //                         $.ajax({
        //                                 url:"/CheckEmail",
        //                                 method: "POST",
        //                                 data:{email:email},
        //                                 success:function(result){
        //                                     if(result=='unique'){
        //                                         $('#error_email').html('<label class="text-success">Email Available</label>');
        //                                         $('#user_email').removeClass('has-error');
        //                                         $('#register').attr('disabled', false);
        //                                     }else{
        //                                         $('#error_email').html('<label class="text-danger">Email already exist</label>');
        //                                         $('#user_email').addClass('has-error');
        //                                         $('#register').attr('disabled', 'disabled');
        //                                     }
        //                                 }
        //                             })
        //                         }
        //                 }
        //             })
                });
    </script>


@endsection
