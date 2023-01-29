<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Models\Branch;
use App\Models\Lesson;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LessonController extends ApiController
{
    //Add Lesson
    public function addLesson(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
            try {
            $add_lesson = Lesson::create([
                'classroom_id' => $request->classroomId,
                'branch_id' => $request->branchId,
                'lesson_code' => $request->lessonCode,
                'lesson_name' => $request->lessonName,
                'lesson_time' => $request->lessonTime,            
            ]);
            $message = 'Lesson added successfully.';
            return $this->sendResponse(new LessonResource($add_lesson), $message);
        } catch (\Exception $e) {
            $message = 'An error occurred during the add process.';
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Update Lesson
    public function updateLesson(Request $request ,$id){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
            try {
            $update_lesson = Lesson::where('id', $id)->update([
                'lesson_code' => $request->lessonCode,
                'lesson_name' => $request->lessonName,
                'lesson_time' => $request->lessonTime,
            ]);
            $message = 'Lesson updated successfully.';
            return $this->sendResponse($update_lesson, $message);
        } catch (\Exception $e) {
            $message = 'Lesson could not be updated.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Delete Lesson
    public function deleteLesson($id){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
            try {
            $lesson_find = Lesson::find($id);
            $delete_lesson = $lesson_find->delete();
            $message = "Lesson Deleted.";
            return $this->sendResponse($delete_lesson, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //All Lessons
    public function getAllLessons(){
        $all_lessons=Lesson::join('classrooms','lessons.classroom_id','classrooms.id')
        ->join('branches','lessons.branch_id','branches.id')
        ->select('classrooms.name as ClassName',
                    'branches.name as BranchName',
                    'lessons.lesson_code as lessonCode',
                    'lessons.lesson_name as lessonName',
                    'lessons.lesson_time as lessonTime')->get();
        $message='All Lessons';
        return $this->sendResponse($all_lessons,$message);  
    }
    //Lessons By Class Id
    public function getlessonsByClassroom(Request $request){
        $classroom_lessons=Classroom::where('classrooms.id','=',$request->input('classroomId'))
        ->join('branches','classrooms.id','branches.classroom_id')
        ->join('lessons','classrooms.id','lessons.classroom_id')
        ->select('classrooms.name as ClassName',
                    'branches.name as BranchName',
                    'lessons.lesson_code as lessonCode',
                    'lessons.lesson_name as lessonName',
                    'lessons.lesson_time as lessonTime')->get();
        $message='Classroom Lessons';
        return $this->sendResponse($classroom_lessons,$message); 
    }
    //Lessons By Branch Id
    public function getLessonsByBranch(Request $request){
        $branch_lessons=Branch::where('branches.id','=',$request->input('brnachId'))
        ->join('classrooms','branches.classroom_id','classrooms.id')
        ->join('lessons','branches.id','lessons.branch_id')
        ->select(
                    'classrooms.name as ClassName',
                    'branches.name as BranchName',
                    'lessons.lesson_code as lessonCode',
                    'lessons.lesson_name as lessonName',
                    'lessons.lesson_time as lessonTime')->get();
        $message='Branch Lessons';
        return $this->sendResponse($branch_lessons,$message); 
    }
}
