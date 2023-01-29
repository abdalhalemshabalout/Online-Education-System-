<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonStudentResource;
use App\Http\Resources\LessonTeacherResource;
use App\Models\LessonStudent;
use App\Models\LessonTeacher;
use Illuminate\Http\Request;

class PersonalController extends ApiController
{
    //Add Teacher To lesson
    public function AddTeacherToLesson(Request $request){
        $user= auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal')){
            try{
                $add_teacher_to_lesson=LessonTeacher::create([
                    'classroom_id'=>$request->classroomId,
                    'branch_id'=>$request->branchId,
                    'teacher_id'=>$request->teacherId,
                    'lesson_id'=>$request->lessonId,
                ]);
                $message='The teacher has been added to the lesson successfully.';
                return $this->sendResponse(new LessonTeacherResource($add_teacher_to_lesson),$message);
            }catch(\Exception $e){
                $message='An error occurred during the add process.';
                return $this->sendError($e->getMessage());
            }
        }
        return response()->json(['success'=>false]);
    }
    //Delete the teacher from the lesson
    public function deleteTeacherFromLesson($id){
        $user= auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal')){
            try {
                $teacher_find = LessonTeacher::find($id);
                $delete_teacher = $teacher_find->delete();
                $message = "The teacher has been removed from the lesson.";
                return $this->sendResponse($delete_teacher, $message);
            } catch (\Exception $e) {
                $message = "Something went wrong.";
                return $this->sendError($message);
            }
        }
        return response()->json(['success'=>false]);
    }
    //Add Student To lesson
    public function AddStudentToLesson(Request $request){
        $user= auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal')){
            try{
                $add_student_to_lesson=LessonStudent::create([
                    'classroom_id'=>$request->classroomId,
                    'branch_id'=>$request->branchId,
                    'student_id'=>$request->studentId,
                    'lesson_id'=>$request->lessonId,
                ]);
                $message='The student has been added to the lesson successfully';
                return $this->sendResponse(new LessonStudentResource($add_student_to_lesson),$message);
            }catch(\Exception $e){
                $message='An error occurred during the add process.';
                return $this->sendError($e->getMessage());
            }
        }
        return response()->json(['success'=>false]);
    }
    //Delete the student from the lesson
    public function deleteStudentFromLesson($id){
        $user= auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal')){
            try {
                $student_find = LessonStudent::find($id);
                $delete_student = $student_find->delete();
                $message = "The student has been removed from the lesson.";
                return $this->sendResponse($delete_student, $message);
            } catch (\Exception $e) {
                $message = "Something went wrong.";
                return $this->sendError($message);
            }
        }
        return response()->json(['success'=>false]);
    }
}
