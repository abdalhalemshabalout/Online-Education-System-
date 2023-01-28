<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomAnnouncementResource;
use App\Models\ClassroomAnnouncement;
use Illuminate\Http\Request;

class ClassroomAnnouncementController extends ApiController
{
    //Add Announcement
    public function addAnnouncement(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Personal') ){
            try {
            $add_announcement = ClassroomAnnouncement::create([
                'classroom_id' =>$request->classroomId,
                'head' => $request->head,
                'body' => $request->body,
            ]);
            $message = 'Announcement added successfully.';
            return $this->sendResponse(new ClassroomAnnouncementResource($add_announcement), $message);
        } catch (\Exception $e) {
            $message = 'An error occurred during the add process.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Update Announcement
    public function updateAnnouncement(Request $request ,$id){
        $user = auth()->user();
        if($user->tokenCan('Personal') ){
            try {
            $update_announcement = ClassroomAnnouncement::where('id', $id)->update([
                'head' => $request->head,
                'body' => $request->body,
            ]);
            $message = 'Announcement updated successfully.';
            return $this->sendResponse($update_announcement, $message);
        } catch (\Exception $e) {
            $message = 'Announcement could not be updated.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Delete Announcement
    public function deleteAnnouncement($id){
        $user = auth()->user();
        if($user->tokenCan('Personal') ){
            try {
            $announcement_find = ClassroomAnnouncement::find($id);
            $delete_announcement = $announcement_find->delete();
            $message = "Announcement Deleted.";
            return $this->sendResponse($delete_announcement, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Get Announcements
    public function getAnnouncements(){
        $get_announcement=ClassroomAnnouncement::
        join('classrooms','classroom_announcements.classroom_id','classrooms.id')
        ->select('classroom_announcements.id',
        'classrooms.name as classId',
        'classroom_announcements.head','classroom_announcements.body')->get();
        $message ='list Announcement';
        return $this->sendResponse($get_announcement,$message);
    }
    //Get Announcement by id
    public function getAnnouncement(Request $request){
        $get_announcement=ClassroomAnnouncement::where('classroom_announcements.id','=',$request->id)
        ->join('classrooms','classroom_announcements.classroom_id','classrooms.id')
        ->select(
        'classroom_announcements.id',
        'classrooms.name as classId',
        'classroom_announcements.head','classroom_announcements.body')
        ->get();
        $message ='Announcement';
        return $this->sendResponse($get_announcement,$message);
    }
}
