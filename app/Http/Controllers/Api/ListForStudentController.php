<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassroomStudent;
use App\Models\LessonStudent;
use App\Models\Student;
use App\Models\User;
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
    //List Students By Class Id
    public function getStudentsByClassId(Request $request){
        $class_students=ClassroomStudent::where('classroom_students.classroom_id','=',$request->id)
        ->join('classrooms','classroom_students.classroom_id','classrooms.id')
        ->join('branches','classroom_students.branch_id','branches.id')
        ->join('students','classroom_students.student_id','students.id')
        ->select(
            'classroom_students.id',
            'classrooms.name as classId',
            'branches.name as branchId',
            Student::raw("CONCAT(students.name,' ',students.surname) as studentId")
            )->get();
        $message='class students';
        return $this->sendResponse($class_students,$message);
    }
    //List Students By Branch Id
    public function geStudentsByBranchId(Request $request){
        $branch_students=ClassroomStudent::where('classroom_students.branch_id','=',$request->id)
        ->join('classrooms','classroom_students.classroom_id','classrooms.id')
        ->join('branches','classroom_students.branch_id','branches.id')
        ->join('students','classroom_students.student_id','students.id')
        ->select(
            'classroom_students.id',
            'classrooms.name as classId',
            'branches.name as branchId',
            Student::raw("CONCAT(students.name,' ',students.surname) as studentId")
            )->get();
        $message='Branch students';
        return $this->sendResponse($branch_students,$message);
    }
    //List Students By Lesson id
    public function getStudentsByLessonId(Request $request){
        $students=LessonStudent::where('lesson_students.lesson_id','=',$request->id)
        ->join('lessons','lesson_students.lesson_id','lessons.id')
        ->join('students','lesson_students.student_id','students.id')
        ->select(
            'lessons.lesson_name as lessonId',
            Student::raw("CONCAT(students.name,' ',students.surname) as studentId")
        )->get();
        $message='';
        return $this->sendResponse($students,$message);
    }
    //Student lessons by teacher id
    public function getStudentLessons(Request $request){
        $student_lessons=User::where('users.id','=',$request->user()->id)
        ->join('lesson_students','users.user_id','lesson_students.student_id')
        ->join('lessons','lesson_students.lesson_id','lessons.id')
        ->join('classrooms','lessons.classroom_id','classrooms.id')
        ->join('branches','lessons.branch_id','branches.id')
        ->select(
            'lessons.id as lessonId',
            'classrooms.name as classId',
            'branches.name as branchId',
            'lessons.lesson_code as lessonCode',
            'lessons.lesson_name as lessonName',
            'lessons.lesson_time as lessonTime',
            )
        ->get();
        $message='Student Lessons';
        return $this->sendResponse($student_lessons,$message);
    }
}
