<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;

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

    public function uploadProfilePhoto(Request $request, $id){

        $user=User::where('id',$id)->first();
        if($request->hasfile('userImage')){
            $imageString = '../assets/profile/'.$user->userName.'_'.$id.'.'.$request->file('userImage')->extension();
            $image=$request->userImage;
            $img = Image::make($image->path());

            if($user->userImage!='../assets/img/user.jpg'){
                File::delete($user->userImage);
            }
            $img->resize(1500, 1500)->save('assets/profile/'.$user->userName.'_'.$id.'.'.$request->file('userImage')->extension());
        }
        $updtPhoto = User::where('id',$id)->update([
            'userImage'=>$imageString,
        ]);
        return 'success';
    }

    protected function editProfile(Request $data, $id)
    {
        $updateUser=User::where('id',$id)->update([
            'userName' => $data->userName,
            'email' => $data->email,
            'userAddress'=> $data->userAddress,
            'userPhone'=> $data->userPhone,
            'userBirthdate'=> $data->userBirthdate,
            'userBusinessName'=> $data->userBusinessName,
            'userBusinessCategory'=> $data->userBusinessCategory,
        ]);
        return $updateUser;
    }
}
