<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Classroom;
use App\Http\Resources\BranchResource;
class BranchController extends ApiController
{
     //Add Branch
     public function addBranch(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
            try {
            $add_branch = Branch::create([
                'classroom_id'=>$request->classroomId,
                'name' => $request->name,
            ]);
            $message = 'Branch added successfully.';
            return $this->sendResponse(new BranchResource($add_branch), $message);
        } catch (\Exception $e) {
            $message = 'An error occurred during the add process.';
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Update Branch
    public function updateBranch(Request $request ,$id){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
            try {
            $update_branch = Branch::where('id', $id)->update([
                'name' => $request->name,
            ]);
            $message = 'Branch updated successfully.';
            return $this->sendResponse($update_branch, $message);
        } catch (\Exception $e) {
            $message = 'Branch could not be updated.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Delete Branch
    public function deleteBranch($id){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal') ){
            try {
            $branch_find = Branch::find($id);
            $delete_branch = $branch_find->delete();
            $message = "Branch Deleted.";
            return $this->sendResponse($delete_branch, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Get Branch
    public function getBranch(){
        $get_branch=Branch::select('id','classroom_id as classroomId','name')->get();
        $message ='list Branch';
        return $this->sendResponse($get_branch,$message);
    }
    //Get Branch
    public function getBranchByClassroomId(Request $request){
        $get_branch=Classroom::where('classrooms.id','=',$request->input('classroomId'))
        ->join('branches','classrooms.id','branches.classroom_id')
        ->select('branches.id','branches.classroom_id as classroomId','branches.name')->get();
        $message ='list Branch';
        return $this->sendResponse($get_branch,$message);
    }
}
