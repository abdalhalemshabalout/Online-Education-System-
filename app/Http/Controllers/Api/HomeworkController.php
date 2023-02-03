<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeworkResource;
use App\Models\Homework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class HomeworkController extends ApiController
{
    //Add Homework To Lesson Content
    public function addHomework(Request $request)
    {
        $user = auth()->user();
        if($user->tokenCan('Teacher')){
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
                $file->move(public_path('Contents/Homeworks/'), $document);
                $data['document']= 'Contents/Homeworks/'.$document;
                $document='Contents/Homeworks/' . $document;
                }
                else{
                    $document=null;
                }
        try {
            $add_homework = Homework::create([
                'lesson_content_id'=>$request->lessonContentId,
                'name' => $request->name,
                'description' => $request->description,
                'document' => $document,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
            ]);
            $message = 'New Homework has been added to the lesson content.';
            return $this->sendResponse(new HomeworkResource($add_homework), $message);
        } catch (\Exception $e) {
            $message = 'An error occurred during the add process.';
            return $this->sendError($e->getMessage());
        }
    }
    return response()->json(['success'=>false]);
    }
    //Update Homework To Lesson Content
    public function updateHomework(Request $request, $id){
        $user = auth()->user();
        if($user->tokenCan('Teacher')){
        // $documentName = '';
        $homework = Homework::where('id', $id)->first();
        $oldFilePath = $homework->document;

        if ($oldFilePath != null) {

            $dnPath = public_path() . '/' . $oldFilePath;
            if (File::exists($dnPath)) {
                File::delete($dnPath);
            }
        }
        if (($request->document)!='') {
            $file =$request->file('document');
            $extension = $file->getClientOriginalExtension();
            $document = time().'.' . $extension;
            $file->move(public_path('Contents/Homeworks/'), $document);
            $data['document']= 'Contents/Homeworks/'.$document;
            $document='Contents/Homeworks/' . $document;
        }
        else{
            $document=null;
        }
        try {
            $update_homework = Homework::where('id', $id)->update([
                'name' => $request->name,
                'document' =>$document,
                'description' => $request->description,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
            ]);
            $message = 'Homework updated successfully.';
            return $this->sendResponse($update_homework, $message);
        } catch (\Exception $e) {

            $message = 'Homework could not be updated.';
            return $this->sendError($e->getMessage());
        }
    }
    return response()->json(['success'=>false]);
    }
    //Delete Homework To Lesson Content  
    public function deleteHomework($id)
    {
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
        try {
            $homework_find = Homework::find($id);
            $document = $homework_find->document;
            if ($document != null) {
                $dnPath = public_path() . "/" . $document;
                if (File::exists($dnPath)) {
                    File::delete($dnPath);
                }
            }
            $delete_homework = $homework_find->delete();
            $message = "Homework Deleted.";
            return $this->sendResponse($delete_homework, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
    }
    return response()->json(['success'=>false]);
    }
    //Get Homeworks  By lesson Content Id
    public function getHomeworksLessonContent(Request $request){
        $get_homeworks=Homework::Where('lesson_content_id','=',$request->id)
        ->join('lesson_contents','homework.lesson_content_id','lesson_contents.id')
        ->select(
            'lesson_contents.id as contentId',
            'homework.id as homeworkId',
            'homework.name',
            'homework.description',
            'homework.document',
            'homework.start_date as startDate',
            'homework.end_date as endDate',
            )->get();
        $message='Homeworks';
        return $this->sendResponse($get_homeworks,$message);
    }
}
