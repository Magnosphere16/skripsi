<?php

namespace App\Http\Controllers;
use App\Http\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function checkEmail(Request $request){
        if($request->get('email')){//if email from ajax request not null
            $email = $request->get('email');
            $user_email = User::Where('email',$email)->count();//check how many inputed email exist in database
            if($user_email>0){//sends responds back to register page ajax request
                echo 'not_unique';
            }else{
                echo 'unique';
            }
        }
    }
}
