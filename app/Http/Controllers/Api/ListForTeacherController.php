<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ListForTeacherController extends ApiController
{
    //List All Teachers
    public function getAllTeachers(){
        $teachers=Teacher::select(
            'id','name','surname','telephone',
            'email','image as img','identity_number as identityNumber','country_id as countryId',
            'mother_name as motherName','father_name as fatherName',
            'gender','place_of_birth as placeOfBirth','birth_date as birthDate','address',
            'department_graduated as departmentGraduated','created_at as createdAt',
        )->get();
        $message='';
        return $this->sendResponse($teachers,$message);
    }
}
