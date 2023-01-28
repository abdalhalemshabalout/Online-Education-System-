<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BranchAnnouncementResource;
use App\Models\BranchAnnouncement;
use Illuminate\Http\Request;

class BranchAnnouncementController extends ApiController
{
    //Add Announcement
    public function addAnnouncement(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') || $user->tokenCan('Teacher') ){
            try {
            $add_announcement = BranchAnnouncement::create([
                'classroom_id' =>$request->classroomId,
                'branch_id' =>$request->branchId,
                'head' => $request->head,
                'body' => $request->body,
            ]);
            $message = 'Announcement added successfully.';
            return $this->sendResponse(new BranchAnnouncementResource($add_announcement), $message);
        } catch (\Exception $e) {
            $message = 'An error occurred during the add process.';
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Update Announcement
    public function updateAnnouncement(Request $request ,$id){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') || $user->tokenCan('Teacher')){
            try {
            $update_announcement = BranchAnnouncement::where('id', $id)->update([
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
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') || $user->tokenCan('Teacher')){
        try {
            $announcement_find = BranchAnnouncement::find($id);
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
        $get_announcement=BranchAnnouncement::
        join('classrooms','branch_announcements.classroom_id','classrooms.id')
        ->join('branches','branch_announcements.branch_id','branches.id')
        ->select('branch_announcements.id',
        'classrooms.name as classId',
        'branches.name as branchId',
        'branch_announcements.head','branch_announcements.body')->get();
        $message ='list Announcement';
        return $this->sendResponse($get_announcement,$message);
    }
    //Get Announcement by id
    public function getAnnouncement(Request $request){
        $get_announcement=BranchAnnouncement::where('branch_announcements.id','=',$request->id)
        ->join('classrooms','branch_announcements.classroom_id','classrooms.id')
        ->join('branches','branch_announcements.branch_id','branches.id')
        ->select(
        'branch_announcements.id',
        'classrooms.name as classId',
        'branches.name as branchId',
        'branch_announcements.head','branch_announcements.body')
        ->get();
        $message ='Announcement';
        return $this->sendResponse($get_announcement,$message);
    }
}
