<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonAnnouncementResource;
use App\Models\LessonAnnouncement;
use App\Models\User;
use Illuminate\Http\Request;

class LessonAnnouncementController extends ApiController
{
    //Add Lesson Announcement
    public function addLessonAnnouncement(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
            $add_announcement = LessonAnnouncement::create([
                'lesson_id' =>$request->lessonId,
                'head' => $request->head,
                'body' => $request->body,
            ]);
            $message = 'Lesson Announcement added successfully.';
            return $this->sendResponse(new LessonAnnouncementResource($add_announcement), $message);
        } catch (\Exception $e) {
            $message = 'An error occurred during the add process.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Update Lesson Announcement
    public function updateLessonAnnouncement(Request $request ,$id){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
            $update_announcement = LessonAnnouncement::where('id', $id)->update([
                'head' => $request->head,
                'body' => $request->body,
            ]);
            $message = 'Lesson Announcement updated successfully.';
            return $this->sendResponse($update_announcement, $message);
        } catch (\Exception $e) {
            $message = 'Lesson Announcement could not be updated.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Delete Lesson Announcement
    public function deleteLessonAnnouncement(Request $request,$id){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
            $announcement_find = LessonAnnouncement::find($id);
            $delete_announcement = $announcement_find->delete();
            $message = "Lesson Announcement Deleted.";
            return $this->sendResponse($delete_announcement, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Get Announcements  By lesson Id
    public function getLessonAnnouncements(Request $request){
        $get_lesson_announcements=LessonAnnouncement::Where('lesson_id','=',$request->id)
        ->join('lessons','lesson_announcements.lesson_id','lessons.id')
        ->select(
            'lessons.id as lessonId',
            'lessons.lesson_name as lessonName',
            'lesson_announcements.id as announcementId',
            'lesson_announcements.head as head',
            'lesson_announcements.body as body')->get();
        $message='lesson Announcements';
        return $this->sendResponse($get_lesson_announcements,$message);
    }
    //Get Announcement by id
     public function getLessonAnnouncement(Request $request){
        $get_announcement=LessonAnnouncement::where('id','=',$request->id)
        ->select('id','head','body')->get();
        $message ='Announcement';
        return $this->sendResponse($get_announcement,$message);
    }
}
