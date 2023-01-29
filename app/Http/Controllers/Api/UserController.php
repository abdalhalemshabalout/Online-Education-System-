<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassroomStudent;
use App\Models\Personal;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /*********************Personal************************/
    //Add Personal
    public function CreatePersonal(Request $request)
    {
        $user = auth()->user();
        if($user->tokenCan('Admin')){
        $messages = [
            'email.required' => 'Email field cannot be left blank.',
            'email.unique' => 'There is a record of the e-mail you entered..',
            'name.required' => 'Name field cannot be left blank.',
            'name.min' => 'Name cannot be less than 3 characters.',
            'surname.required' => 'Surname field cannot be left blank.',
            'password.required' => 'Please enter your password.',
            'c_password.required' => 'Please re-enter password.',
            'c_password.same' => 'Password repeat does not match.',
            'password.min' => 'Password cannot be less than 6 characters.',
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
            return $this->sendError('validation error.', $validator->errors());
        }
        if (!empty($request->img)) {
            $file =$request->file('img');
            $extension = $file->getClientOriginalExtension();
            $img = time().'.' . $extension;
            $file->move(public_path('images/profile/personals/'), $img);
            $data['image']= 'images/profile/personals/'.$img;
            $img='images/profile/personals/' . $img;
            }
            else{
                $img=null;
            }
        $personal = Personal::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'identity_number' => $request->identityNumber,
            'image' =>$img,
            'country_id'=>$request->countryId,
            'mother_name'=>$request->motherName,
            'father_name'=>$request->fatherName,
            'gender'=>$request->gender,
            'place_of_birth'=>$request->placeOfBirth,
            'birth_date'=>$request->birthDate,
            'address'=>$request->address,
            'department_graduated'=>$request->departmentGraduated,
        ]);
        $user = Personal::find($personal->id);
        User::create([
            'user_id'=>$user->id,
            'email'=> $user->email,
            'password'=>$user->password,
            'role_id'=>2
        ]);
        $message = 'Personal added successfully';
        return $this->sendResponse($personal, $message);
        }
        return response()->json(['success'=>false]);
    }
    //Delete Personal
    public function deletePersonal($id)
    {
        $user = auth()->user();
        if($user->tokenCan('Admin')){
        try {
            $personalId =Personal::leftJoin('users','personals.id', '=','users.user_id')
                ->where('personals.id', $id); 
                $user_id=User::where('user_id', $id)->delete();                           
                $delete_personal=$personalId->delete();
                $message = "Personal Deleted.";
            return $this->sendResponse($delete_personal, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    /*********************Teacher************************/
    //Add Teacher
    public function CreateTeacher(Request $request)
    {
       $user = auth()->user();
       if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
       $messages = [
            'email.required' => 'Email field cannot be left blank.',
            'email.unique' => 'There is a record of the e-mail you entered..',
            'name.required' => 'Name field cannot be left blank.',
            'name.min' => 'Name cannot be less than 3 characters.',
            'surname.required' => 'Surname field cannot be left blank.',
            'password.required' => 'Please enter your password.',
            'c_password.required' => 'Please re-enter password.',
            'c_password.same' => 'Password repeat does not match.',
            'password.min' => 'Password cannot be less than 6 characters.',
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
           return $this->sendError('validation error.', $validator->errors());
       }
       if (!empty($request->img)) {
          $file =$request->file('img');
          $extension = $file->getClientOriginalExtension();
          $img = time().'.' . $extension;
          $file->move(public_path('images/profile/teachers/'), $img);
          $data['image']= 'images/profile/teachers/'.$img;
          $img='images/profile/teachers/' . $img;
          }
          else{
              $img=null;
          }
       $teacher = Teacher::create([
           'name' => $request->name,
           'surname' => $request->surname,
           'telephone' => $request->telephone,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'image' => $img,
           'identity_number' => $request->identityNumber,
           'country_id'=>$request->countryId,
           'mother_name'=>$request->motherName,
           'father_name'=>$request->fatherName,
           'gender'=>$request->gender,
           'place_of_birth'=>$request->placeOfBirth,
           'birth_date'=>$request->birthDate,
           'address'=>$request->address,
           'department_graduated'=>$request->departmentGraduated,
       ]);
       $user = Teacher::find($teacher->id);
       User::create([
          'user_id'=>$user->id,
          'email'=> $user->email,
          'password'=>$user->password,
          'role_id'=>3
       ]);
       $message = 'Teacher added successfully';
           return $this->sendResponse($teacher, $message);
       }
           return response()->json(['success'=>false]);
    } 
    //Delete Teacher
    public function deleteTeacher($id)
    {
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
        try {
            $teacherId =Teacher::leftJoin('users','teachers.id', '=','users.user_id')
                ->where('teachers.id', $id); 
                $userId=User::where('user_id', $id)->delete();                           
                $deleteTeacher=$teacherId->delete();
                $message = "Teacher Deleted.";
            return $this->sendResponse($deleteTeacher, $message);
        } catch (\Exception $é) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    /*********************Student************************/
    //Add Student
    public function CreateStudent(Request $request)
    {
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal')){
            $messages = [
                'email.required' => 'Email field cannot be left blank.',
                'email.unique' => 'There is a record of the e-mail you entered..',
                'name.required' => 'Name field cannot be left blank.',
                'name.min' => 'Name cannot be less than 3 characters.',
                'surname.required' => 'Surname field cannot be left blank.',
                'password.required' => 'Please enter your password.',
                'c_password.required' => 'Please re-enter password.',
                'c_password.same' => 'Password repeat does not match.',
                'password.min' => 'Password cannot be less than 6 characters.',
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
                return $this->sendError('validation error.', $validator->errors());
            }
            if (!empty($request->img)) {
                $file =$request->file('img');
                $extension = $file->getClientOriginalExtension();
                $img = time().'.' . $extension;
                $file->move(public_path('images/profile/students/'), $img);
                $data['image']= 'images/profile/students/'.$img;
                $img='images/profile/students/' . $img;
                }
                else{
                    $img=null;
                }
            $student = Student::create([
                'classroom_id'=>$request->classroomId,
                'branch_id'=>$request->branchId,
                'name' => $request->name,
                'surname' => $request->surname,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'identity_number' => $request->identityNumber,
                'country_id'=>$request->countryId,
                'mother_name'=>$request->motherName,
                'father_name'=>$request->fatherName,
                'gender'=>$request->gender,
                'image' => $img,
                'place_of_birth'=>$request->placeOfBirth,
                'birth_date'=>$request->birthDate,
                'address'=>$request->address,
                'start_date'=>$request->startDate,
            ]);
            $user = Student::find($student->id);
            User::create([
                'user_id'=>$user->id,
                'email'=> $user->email,
                'password'=>$user->password,
                'role_id'=>4
            ]);
            ClassroomStudent::create([
                'student_id'=>$user->id,
                'classroom_id'=> $user->classroom_id,
                'branch_id'=>$user->branch_id,
            ]);
            $message = 'Student added successfully';
            return $this->sendResponse($student, $message);
        }
        return response()->json(['success'=>false]);
       
    }
    //Delete Student
    public function deleteStudent($id)
    {
        try {
            $studentId =Student::leftJoin('users','students.id', '=','users.user_id')
                ->where('students.id', $id); 
                $userId=User::where('user_id', $id)->delete();                           
                $delete_student=$studentId->delete();
                $message = "Student Deleted.";
            return $this->sendResponse($delete_student, $message);

        } catch (\Exception $é) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
    }
}
