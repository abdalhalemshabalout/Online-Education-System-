<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Admin;
use App\Models\Personal;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentInfo;

class AuthController extends ApiController
{
    public function register(Request $request)
    {
        $messages = [
            'email.required' => 'E-mail alanı boş bırakılamaz.',
            'email.unique' => 'Girdiğiniz E-maile ait kayıt bulunmaktadır.',
            'name.required' => 'İsim alanı boş bırakılamaz.',
            'name.min' => 'İsim 3 karakterden küçük olamaz.',
            'surname.required' => 'Soyad alanı boş bırakılamaz.',
            'password.required' => 'Lütfen şifrenizi giriniz.',
            'c_password.required' => 'Lütfen şifre tekrarı giriniz.',
            'c_password.same' => 'Şifre tekrarı eşleşmiyor.',
            'password.min' => 'Şifre 6 karakterden küçük olamaz.',
            'telephone.digits' => 'Telefon numaranızı (5xxxxxxxxx) olarak giriniz.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|numeric',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',

        ], $messages);
        if ($validator->fails()) {
            return $this->sendError('Doğrulama hatası.', $validator->errors());
        }
        $img = 'images/profile/admins/';
        if (($request->img)!='') {
            $file =$request->file('img');
            $extension = $file->getClientOriginalExtension();
            $img = time().'.' . $extension;
            $file->move(public_path('images/profile/admins/'), $img);
            $data['image']= 'images/profile/admins/'.$img;
            $img = 'images/profile/admins/' . $img;
        }
        else if(($request->img)==''&&$request->gender=='bay'){
            $img='01.png';
        }
        else if(($request->img)==''&&$request->gender=='bayan'){
            $img='01.png';
        }
        $admin = Admin::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'image' => $img,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);
        $user = Admin::find($admin->id);
        $newAdmin=User::create([
            'user_id'=>$user->id,
            'email'=> $user->email,
            'password'=>$user->password,
            'role_id'=>1
        ]);
        $message = 'Created Successfully';
        return $this->sendResponse($newAdmin, $message);
    }
    /****LogIn Function*****/
    public function login(Request $request)
    {        
        $validator = Validator::make($request->all(), [
             'email' => 'required|email',
             'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Lütfen e-mail ve parola kontrol ediniz.');
        }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            if ($auth->role_id == 1) {
                $auth['token'] = $auth->createToken('Admin', ['Admin'])->plainTextToken;
                $auth->role_id = 'Admin';
                $fullname=Admin::where('email','=',$request->email)->select('name as firstName','surname as lastName','image')->get();
            }
            else if ($auth->role_id == 2) {
                $auth['token'] = $auth->createToken('Personal', ['Personal'])->plainTextToken;
                $auth->role_id = 'Personal';
                $fullname=Personal::where('email','=',$request->email)->select('name as firstName','surname as lastName','image')->get();
            } 
            else if ($auth->role_id == 3) {
                $auth['token'] = $auth->createToken('Teacher', ['Teacher'])->plainTextToken;
                $auth->role_id = 'Teacher';
                $fullname=Teacher::where('email','=',$request->email)->select('name as firstName','surname as lastName','image')->get();
            } 
            else if ($auth->role_id == 4) {
                $auth['token'] = $auth->createToken('Student', ['Student'])->plainTextToken;
                $auth->role_id = 'Student';
                $fullname=Student::where('email','=',$request->email)->select('name as firstName','surname as lastName','image')->get();
            }
            else if ($auth->role_id == 5) {
                $auth['token'] = $auth->createToken('Parent', ['Parent'])->plainTextToken;
                $auth->role_id = 'Student';
                $fullname=ParentInfo::where('email','=',$request->email)->select('name as firstName','surname as lastName','image')->get();
            }
            $n1=[] ;
            $img='https://www.education-system.com/';
            if ($fullname['0']['image']==null) {
                $img=null;
            }
            $n2=$n1+['firstName'=>$fullname['0']['firstName'],
            'lastName'=>$fullname['0']['lastName'],
            'img'=>$img . $fullname['0']['image'],
            'id'=>$auth['id'],
            'userId'=>$auth['user_id'],
            'roleId'=>$auth['role_id'],
            'token'=>$auth['token'],
            'password'=>$auth['password'],
            'username'=>$auth['email'],
            ] ;
            $message = 'Giriş başarılı';

            return $this->sendResponse($n2, $message);
        } else {
            return $this->sendError('Giriş başarısız.');
        }
    }
    /****LogOut Function*****/
    public function logOut(Request $request){
        try{
            $request->user()->tokens()->delete();
            return response()->json(['status'=>'true','message'=>"Çıkış Yapıldı",'data'=>[]]);
        } catch(\Exception $e){
            return response()->json(['status'=>'false','message'=>$e->getMessage(),'data'=>[]],500);
        }
    }

}
