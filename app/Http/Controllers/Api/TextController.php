<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TextResource;
use App\Models\Text;
use Illuminate\Http\Request;

class TextController extends ApiController
{
    //Add Text To Lesson Content
    public function addText(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
        try{      
            $add_text=Text::create([
                'lesson_content_id'=>$request->lessonContentId,
                'description'=>$request->description
            ]);
            $message='New Text has been added to the lesson content';
            return $this->sendResponse(new TextResource($add_text),$message);
        }catch(\Exception $e){
            $message='An error occurred during the add process.';
            return $this->sendError($message);
        }
    }
        return response()->json(['success'=>false]);
    }
    //Update Text Lesson Content
    public function updateText(Request $request ,$id){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
            $update_text = Text::where('id', $id)->update([
                'description'=>$request->description
            ]);
            $message = 'Text updated successfully.';
            return $this->sendResponse($update_text, $message);
        } catch (\Exception $e) {
            $message = 'Text could not be updated.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Delete Text Lesson Content
    public function deleteText($id){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
            $text_find = Text::find($id);
            $delete_text = $text_find->delete();
            $message = "Text Deleted.";
            return $this->sendResponse($delete_text, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
}
