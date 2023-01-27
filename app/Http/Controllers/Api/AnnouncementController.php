<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Http\Request;

class AnnouncementController extends ApiController
{
    //Add Announcement
    public function addAnnouncement(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Personal') ){
            try {
            $user = User::where('users.id','=',$request->user()->id)
            ->join('personals','.user_id','personals.id')->select('personals.id')->get('personals.id');
            $userId =$user[0]['id'];
            $add_announcement = Announcement::create([
                'personal_id' => $userId,
                'head' => $request->head,
                'body' => $request->body,
            ]);
            $message = 'Announcement added successfully.';
            return $this->sendResponse(new AnnouncementResource($add_announcement), $message);
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
            $user = User::where('users.id','=',$request->user()->id)
            ->join('personals','.user_id','personals.id')->select('personals.id')->get('personals.id');
            $userId =$user[0]['id'];
            $update_announcement = Announcement::where('id', $id)->update([
                'personal_id' => $userId,
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
    public function deleteAnnouncement(Request $request,$id){
        $user = auth()->user();
        if($user->tokenCan('Personal') ){
            try {
            $announcement_find = Announcement::find($id);
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
        $get_announcement=Announcement::
        join('personals','announcements.personal_id','personals.id')
        ->select('announcements.id',
        Personal::raw("CONCAT(personals.name,' ',personals.surname) as personalId"),
        'announcements.head','announcements.body')->get();
        $message ='list Announcement';
        return $this->sendResponse($get_announcement,$message);
    }
    //Get Announcement by id
    public function getAnnouncement(Request $request){
        $get_announcement=Announcement::where('announcements.id','=',$request->id)
        ->join('personals','announcements.personal_id','personals.id')
        ->select(
        'announcements.id',
        Personal::raw("CONCAT(personals.name,' ',personals.surname) as personalId"),
        'announcements.head','announcements.body')
        ->get();
        $message ='Announcement';
        return $this->sendResponse($get_announcement,$message);
    }
}
