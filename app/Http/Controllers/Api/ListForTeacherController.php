<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassroomTeacher;
use App\Models\LessonTeacher;
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
    //Teachers By Branch Id
    public function getTeachersByClassId(Request $request){
        $class_teacher=ClassroomTeacher::where('classroom_teachers.classroom_id','=',$request->id)
        ->join('classrooms','classroom_teachers.classroom_id','classrooms.id')
        ->join('branches','classroom_teachers.branch_id','branches.id')
        ->join('teachers','classroom_teachers.teacher_id','teachers.id')
        ->select(
            'classroom_teachers.id',
            'classrooms.name as classId',
            'branches.name as branchId',
            Teacher::raw("CONCAT(teachers.name,' ',teachers.surname) as teacherId")
            )->get();
        $message='class teachers';
        return $this->sendResponse($class_teacher,$message);
    }
    //Teachers By Branch id
    public function geTeachersByBranchId(Request $request){
        $branch_students=ClassroomTeacher::where('classroom_teachers.branch_id','=',$request->id)
        ->join('classrooms','classroom_teachers.classroom_id','classrooms.id')
        ->join('branches','classroom_teachers.branch_id','branches.id')
        ->join('teachers','classroom_teachers.teacher_id','teachers.id')
        ->select(
            'classroom_teachers.id',
            'classrooms.name as classId',
            'branches.name as branchId',
            Teacher::raw("CONCAT(teachers.name,' ',teachers.surname) as teacherId")
            )->get();
        $message='Branch teachers';
        return $this->sendResponse($branch_students,$message);
    }
    //Teachers By Lesson id
    public function getTeachersByLessonId(Request $request){
        $teachers=LessonTeacher::where('lesson_teachers.lesson_id','=',$request->id)
        ->join('lessons','lesson_teachers.lesson_id','lessons.id')
        ->join('teachers','lesson_teachers.teacher_id','teachers.id')
        ->select(
            'lessons.lesson_name as lessonId',
            Teacher::raw("CONCAT(teachers.name,' ',teachers.surname) as teacherId")
        )->get();
        $message='lesson Teachers';
        return $this->sendResponse($teachers,$message);
    }
}
