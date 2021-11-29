@extends('layouts.app')

@section('content')
<div style="background: #007bff;
  background: linear-gradient(to right, #0062E6, #33AEFF);">
<div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto mt-5">
        <div class="card flex-row my-7 border-0 shadow rounded-3 overflow-hidden" style="border-radius:1.5%">
          <div class="card-img-left d-none d-md-flex" style="width: 40%; background:url('https://kjpp-frr.co.id/assets/images/layanan/20190331203706.jpg')">
          </div>
          <div class="card-body p-4 p-sm-5">
              <div class="mb-5 text-center">
                <h5 class="fw-light fs-5"><strong>Register</strong></h5>
              </div>
            <form method="POST" name="register" action="{{ route('register') }}">
              @csrf
              <div class="form-floating mb-3">
                <label for="floatingInputUsername">Full Name</label>
                <input id="userName" type="text" class="form-control" name="userName" required autocomplete="userName" autofocus>         
                <span id="error_name"></span>  
              </div>

              <div class="form-floating mb-3">
                <label for="floatingInputEmail">Email address</label>
                <input id="userEmail" type="email" class="form-control" name="userEmail" required autocomplete="userEmail">
                <span id="error_email"></span>
              </div>

              <div class="form-floating mb-3">
                <label for="floatingInputBirthdate">Birthdate</label>
                <input id="userBirthdate" type="date" class="form-control" name="userBirthdate" required autocomplete="userBirthdate" autofocus>
                <span id="error_birthdate"></span>         
              </div>

              <div class="form-floating mb-3">
                <label for="floatingInputAddress">Address</label>
                <input id="userAddress" type="text" class="form-control" name="userAddress" required autocomplete="userAddress" autofocus>
                    <span id="error_address"></span>          
              </div>

              <div class="form-floating mb-3">
                <label for="floatingInputPhone">Phone Number</label>
                <input id="userPhone" type="tel" class="form-control" name="userPhone" required autocomplete="userPhone" autofocus>          
                <span id="error_phone"></span>
              </div>

              <div class="form-floating mb-3">
                <label for="floatingInputBusinessName">Business Name</label>
                <input id="userBusinessName" type="text" class="form-control" name="userBusinessName" required autocomplete="userBusinessName" autofocus>
                <span id="error_business_name"></span>             
              </div>

              <div class="form-floating mb-3">
                <label for="floatingInputBusinessCategory">Business Category</label>
                <input id="userBusinessCategory" type="text" class="form-control" name="userBusinessCategory" required autocomplete="userBusinessCategory" autofocus>
                <span id="error_business_category"></span>
              </div>

              <hr>

              <div class="form-floating mb-3">
                <label for="floatingPassword">Password</label>
                <input id="userPassword" type="password" class="form-control" name="userPassword" required autocomplete="userPassword">
                <span id="error_password"></span>
              </div>

              <div class="form-floating mb-3">
                <label for="floatingPasswordConfirm">Confirm Password</label>
                <input id="userPasswordConfirm" type="password" class="form-control" name="password_confirmation" required autocomplete="userPasswordConfirm">
                <span id="error_password_confirm"></span>
              </div>


              <div class="d-grid mb-2">
                <button type="submit" class="btn btn-primary btn-block" id="register" style="disabled:false;">
                    {{ __('Sign Up') }}
                </button>
              </div>

              <a class="d-block text-center mt-2" href="{{ route('login') }}">Have an account? Sign In</a>

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
</div>

<!-- java script -->
<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    $(document).ready(function(){
          //check email availability, formats, and existence
                $('#userEmail').blur(function() {
                    var error_email='';
                    var email =  $('#userEmail').val();
                    console.log(email);
                    var filter =/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    if(email==''){
                        $('#error_email').html('<label class="text-danger">Email must be filled</label>');
                        $('#userEmail').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else{
                            if(!filter.test(String(email).toLowerCase())){   
                                $('#error_email').html('<label class="text-danger">Invalid Email Format</label>');
                                $('#userEmail').addClass('has-error');
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
                                                $('#userEmail').removeClass('has-error');
                                                $('#register').attr('disabled', false);
                                            }else{
                                                $('#error_email').html('<label class="text-danger">Email already exist</label>');
                                                $('#userEmail').addClass('has-error');
                                                $('#register').attr('disabled', 'disabled');
                                            }
                                        }
                                    })
                                }
                        }
                    })

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

        //check birthdate availability
            $('#userBirthdate').blur(function(){
                    var error_birthdate='';
                    var birthdate =  $('#userBirthdate').val();
                    if(birthdate==''){
                        $('#error_birthdate').html('<label class="text-danger">Birthdate must be filled</label>');
                        $('#userBirthdate').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else{
                            $('#error_birthdate').html('');
                            $('#userBirthdate').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        }
                });

        //check phone number availability
            $('#userPhone').blur(function(){
                    var error_phone='';
                    var phone =  $('#userPhone').val();
                    if(phone==''){
                        $('#error_phone').html('<label class="text-danger">Phone number must be filled</label>');
                        $('#userPhone').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else{
                            $('#error_phone').html('');
                            $('#userPhone').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        }
                });
        //check business name availability
            $('#userBusinessName').blur(function(){
                    var error_business_name='';
                    var business_name =  $('#userBusinessName').val();
                    if(business_name==''){
                        $('#error_business_name').html('<label class="text-danger">Business Name must be filled</label>');
                        $('#userBusinessName').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else{
                            $('#error_business_name').html('');
                            $('#userBusinessName').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        }
                });

        //check business category availability
            $('#userBusinessCategory').blur(function(){
                    var error_business_category='';
                    var business_category =  $('#userBusinessCategory').val();
                    if(business_category==''){
                        $('#error_business_category').html('<label class="text-danger">Business Category must be filled</label>');
                        $('#userBusinessCategory').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else{
                            $('#error_business_category').html('');
                            $('#userBusinessCategory').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        }
                });
         //check password availability
              $('#userPassword').blur(function(){
                    var error_password='';
                    var password =  $('#userPassword').val();
                    if(password==''){
                        $('#error_password').html('<label class="text-danger">Password must be filled</label>');
                        $('#userPassword').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else{
                            $('#error_password').html('');
                            $('#userPassword').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        }
                });

         //check password confirm availability
              $('#userPasswordConfirm').blur(function(){
                    var error_password_confirm='';
                    var password_confirm =  $('#userPasswordConfirm').val();
                    var password =  $('#userPassword').val();
                    if(password_confirm==''){
                        $('#error_password_confirm').html('<label class="text-danger">Confirm Password must be filled</label>');
                        $('#userPasswordConfirm').addClass('has-error');
                        $('#register').attr('disabled', 'disabled');
                    }else if(password_confirm.localeCompare(password)==0){
                            $('#error_password_confirm').html('');
                            $('#userPasswordConfirm').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        }else{
                          $('#error_password_confirm').html('<label class="text-danger">Confirm Password must be same as Password</label>');
                          $('#userPasswordConfirm').addClass('has-error');
                          $('#register').attr('disabled', 'disabled');
                        }
                });
        });
    </script>


@endsection
