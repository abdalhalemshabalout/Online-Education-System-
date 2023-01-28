<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class ListForStudentController extends ApiController
{
    //List All Students
    public function getAllStudents(){
        $teachers=Student::
        join('classrooms','students.classroom_id','classrooms.id')
        ->join('branches','students.branch_id','branches.id')
        ->select(
            'classrooms.name as classId',
            'branches.name as branchId',
            'students.id','students.name','students.surname','students.telephone',
            'students.email','students.image as img',
            'students.identity_number as identityNumber','students.country_id as countryId',
            'students.mother_name as motherName','students.father_name as fatherName',
            'students.gender','students.place_of_birth as placeOfBirth',
            'students.birth_date as birthDate','students.address','students.start_date as startDate',
        )->get();
        $message='';
        return $this->sendResponse($teachers,$message);
    }
}
