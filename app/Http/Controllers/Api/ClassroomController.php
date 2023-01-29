<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Http\Resources\ClassroomResource;
use App\Models\ClassroomTeacher;

class ClassroomController extends ApiController
{
    //Add Classrrom
    public function addClassroom(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
            try {
            $add_classroom = Classroom::create([
                'name' => $request->name,
            ]);
            $message = 'Classroom added successfully.';
            return $this->sendResponse(new ClassroomResource($add_classroom), $message);
        } catch (\Exception $e) {
            $message = 'An error occurred during the add process.';
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Update Classroom
    public function updateClassroom(Request $request ,$id){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
            try {
            $update_classroom = Classroom::where('id', $id)->update([
                'name' => $request->name,
            ]);
            $message = 'Classroom updated successfully.';
            return $this->sendResponse($update_classroom, $message);
        } catch (\Exception $e) {
            $message = 'classroom could not be updated.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Delete Classroom
    public function deleteClassroom($id){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
            try {
            $classroom_find = Classroom::find($id);
            $delete_classroom = $classroom_find->delete();
            $message = "Classroom Deleted.";
            return $this->sendResponse($delete_classroom, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Get Classroom
    public function getClassroom(){
        $get_classroom=Classroom::select('id','name')->get();
        $message ='list Classroom';
        return $this->sendResponse($get_classroom,$message);
    }
}
