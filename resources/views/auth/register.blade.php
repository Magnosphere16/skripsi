@extends('layouts.app')

@section('content')
<div class="container-fluid ps-md-0">
    <div class="row g-0">
    <div class="d-none d-md-flex col-md-4 col-lg-5 ml-auto bg-image">
            <img class="img-fluid rounded-circle" src="assets/img/register.jpg" alt="">
        </div>
        <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-lg-8 mx-auto">
                            <h3 class="login-heading mb-4 text-center">Sign Up</h3>

                            <!-- Sign In Form -->
                            <form method="POST" action="/registerUser">
                                @csrf
                                <div class="personal_sect">
                                    <div class="form-group">
                                      <strong>Fullname</strong>
                                      <input id="userName" type="text" class="form-control" name="userName" autocomplete="userName" autofocus>         
                                      <span id="error_name"></span>  
                                  </div>

                                  <div class="form-group">
                                      <strong>Email Address</strong>
                                      <input id="userEmail" type="email" class="form-control" name="userEmail" autocomplete="userEmail">
                                      <span id="error_email"></span>  
                                  </div>

                                    <div class="form-group">
                                      <strong>Birthdate</strong>
                                      <input id="userBirthdate" type="date" class="form-control" name="userBirthdate" autocomplete="userBirthdate" autofocus>
                                      <span id="error_birthdate"></span>         
                                    </div>

                                    <div class="form-group">
                                    <strong>Address</strong>
                                      <input id="userAddress" type="text" class="form-control" name="userAddress" autocomplete="userAddress" autofocus>
                                          <span id="error_address"></span>          
                                    </div>

                                    <div class="form-group">
                                    <strong>Phone Number</strong>
                                      <input id="userPhone" type="tel" class="form-control" name="userPhone" autocomplete="userPhone" autofocus>          
                                      <span id="error_phone"></span>
                                    </div>

                                    <button class="btn btn-primary" type="button" id="next_1_btn">Next</button>
                                </div>

                                <div class="business_sect" style="display:none;">
                                    <div class="form-group">
                                    <strong>Business Name</strong>
                                      <input id="userBusinessName" type="text" class="form-control" name="userBusinessName" autocomplete="userBusinessName" autofocus>
                                      <span id="error_business_name"></span>             
                                    </div>

                                    <div class="form-group">
                                    <strong>Business Category</strong>
                                      <input id="userBusinessCategory" type="text" class="form-control" name="userBusinessCategory" autocomplete="userBusinessCategory" autofocus>
                                      <span id="error_business_category"></span>
                                    </div>

                                    <button class="btn btn-secondary" type="button" id="back_2_btn">Back</button>
                                    <button class="btn btn-primary" type="button" id="next_2_btn">Next</button>
                                </div>

                                <div class="password_sect" style="display:none;">
                                    <div class="form-group">
                                    <strong>Password</strong>
                                      <input id="userPassword" type="password" class="form-control" name="userPassword" autocomplete="userPassword">
                                      <span id="error_password"></span>
                                    </div>

                                    <div class="form-group">
                                    <strong>Confirm Password</strong>
                                      <input id="userPasswordConfirm" type="password" class="form-control" name="password_confirmation" autocomplete="userPasswordConfirm">
                                      <span id="error_password_confirm"></span>
                                    </div>

                                    <button class="btn btn-secondary" type="button" id="back_3_btn">Back</button>

                                    <div class="form-group">
                                        <div class="col-md-4 offset-md-4">
                                          <button type="submit" class="btn btn-primary btn-lg btn-block" id="register" disabled>
                                            Sign Up
                                        </button>
                                      </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="py-5 bg-black">
            <div class="container px-5"><p class="m-0 text-center text-white small">Copyright &copy; KassaKu 2021</p></div>
</footer>
<!-- java script -->
<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>

    $(document).ready(function(){
      //Change register section
          $('#next_1_btn').click(function(){
              $(".personal_sect").hide();
              $(".business_sect").show();
          });

          $('#back_2_btn').click(function(){
              $(".personal_sect").show();
              $(".business_sect").hide();
          });

          $('#next_2_btn').click(function(){
              $(".business_sect").hide();
              $(".password_sect").show();
          });

          $('#back_3_btn').click(function(){
              $(".business_sect").show();
              $(".password_sect").hide();
          });


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
