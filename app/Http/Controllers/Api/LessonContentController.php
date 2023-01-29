<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonContentResource;
use App\Models\LessonContent;
use App\Models\LessonTeacher;
use App\Models\User;
use Illuminate\Http\Request;

class LessonContentController extends ApiController
{
    //Add Lesson Content
    public function addLessonContent(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
        try{      
            $add_content_lesson=LessonContent::create([
                'lesson_id'=>$request->lessonId,
                'content_name'=>$request->contentName
            ]);
            $message='New content has been added to the lesson';
            return $this->sendResponse(new LessonContentResource($add_content_lesson),$message);
        }catch(\Exception $e){
            $message='An error occurred during the add process.';
            return $this->sendError($message);
        }
    }
        return response()->json(['success'=>false]);
    }
    //Update Lesson Content
    public function updateLessonContent(Request $request ,$id){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
            $update_lesson_content = LessonContent::where('id', $id)->update([
                'content_name' => $request->contentName,
            ]);
            $message = 'Lesson content updated successfully.';
            return $this->sendResponse($update_lesson_content, $message);
        } catch (\Exception $e) {
            $message = 'Lesson content could not be updated.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Delete Lesson Content
    public function deleteLessonContent($id){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
            $lesson_content_find = LessonContent::find($id);
            $delete_lesson_content = $lesson_content_find->delete();
            $message = "Lesson Content Deleted.";
            return $this->sendResponse($delete_lesson_content, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }

    //list Contents by Lesson id
    public function getContentsByLessonId(Request $request){
        $teacher_id = User::where('id','=',$request->user()->id)->get();
        $academicianLessonContent =LessonTeacher::where('teacher_id','=',$teacher_id['0']['user_id'])
        ->join('lesson_contents','lesson_teachers.lesson_id','=','lesson_contents.lesson_id')
        ->where('lesson_contents.lesson_id','=',$request->input('lessonId'))
        ->select(
            'lesson_contents.id as contentId',
            'lesson_contents.lesson_id as lessonId',
            'lesson_contents.content_name as contentName',
            'lesson_contents.created_at as Date',
        )->get();
        $message = 'Lesson Contens';
        return $this->sendResponse($academicianLessonContent, $message);
    }
}
