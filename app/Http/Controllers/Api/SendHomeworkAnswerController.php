<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SendHomeworkResource;
use App\Models\SendHomework;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SendHomeworkAnswerController extends ApiController
{
   //Send Homework 
   public function sendHomework(Request $request)
   {
       $user = auth()->user();
       if($user->tokenCan('Student')){
       $validator = Validator::make($request->all(), [
               'document' => 'required|mimes:doc,docx,pdf,txt,csv',
           ]);
           if ($validator->fails()) {
   
               return response()->json(['error' => $validator->errors()], 401);
           }
           if (!empty($request->document)) {
               $file =$request->file('document');
               $extension = $file->getClientOriginalExtension();
               $document = time().'.' . $extension;
               $file->move(public_path('Student/Homeworks/'), $document);
               $data['document']= 'Student/Homeworks/'.$document;
               $document='Student/Homeworks/' . $document;
               }
               else{
                   $document=null;
               }
       try {
            $user = User::where('users.id','=',$request->user()->id)
                ->join('students','users.user_id','students.id')
                ->select('students.id as studentId')
                ->get();
                $userId = $user[0]['studentId'];
           $send_answer = SendHomework::create([
               'homework_id'=>$request->homeworkId,
               'student_id'=>$userId,
               'document' => $document,
            ]);
           $message = 'Homework Answer Sent Successfully.';
           return $this->sendResponse(new SendHomeworkResource($send_answer), $message);
       } catch (\Exception $e) {
           $message = 'An error occurred during the add process.';
           return $this->sendError($e->getMessage());
       }
   }
   return response()->json(['success'=>false]);
   }
   //Update Send Homework 
   public function updateSendHomework(Request $request, $id){
       $user = auth()->user();
       if($user->tokenCan('Student')){
       $Answer = SendHomework::where('id', $id)->first();
       $oldFilePath = $Answer->document;
       if (($request->document)!='') {
           $file =$request->file('document');
           $extension = $file->getClientOriginalExtension();
           $document = time().'.' . $extension;
           $file->move(public_path('Student/Homeworks/'), $document);
           $data['document']= 'Student/Homeworks/'.$document;
           $document='Student/Homeworks/' . $document;
       }
       else{
           $document=null;
       }
       try {
           $update_send_homework = SendHomework::where('id', $id)->update([
               'document' =>$document,
           ]);
           $message = 'Answer updated successfully.';
           return $this->sendResponse($update_send_homework, $message);
       } catch (\Exception $e) {

           $message = 'Answer could not be updated.';
           return $this->sendError($e->getMessage());
       }
   }
   return response()->json(['success'=>false]);
   }
   //Delete Homework Answer  
   public function deleteSendHomework($id)
   {
       $user = auth()->user();
       if($user->tokenCan('Student') ){
       try {
           $answer_find = SendHomework::find($id);
           $document = $answer_find->document;
           $delete_answer = $answer_find->delete();
           $message = "Answer Deleted.";
           return $this->sendResponse($delete_answer, $message);
       } catch (\Exception $e) {
           $message = "Something went wrong.";
           return $this->sendError($message);
       }
   }
   return response()->json(['success'=>false]);
   }
}
