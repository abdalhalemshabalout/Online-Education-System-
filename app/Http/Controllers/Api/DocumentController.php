<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class DocumentController extends ApiController
{
    //Add Document To lesson content
    public function addDocument(Request $request){
        $user=auth()->user();
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
                $file->move(public_path('Contents/Documents/'), $document);
                $data['document']= 'Contents/Documents/'.$document;
                $document='Contents/Documents/' . $document;
                }
                else{
                    $document=null;
                }
            try{
                $add_document=Document::create([
                    'lesson_content_id'=>$request->lessonContentId,
                    'document' =>$document,
                ]);
                $message='New Document has been added to the lesson content.';
                return $this->sendResponse(new DocumentResource($add_document),$message);
            }catch(\Exception $e){
                $message='An error occurred during the add process.';
                return $this->sendError($message);
            }
        }
        return response()->json(['success'=>false]);
    }
    //Delete Document
    public function deleteDocument($id)
    {
        $user = auth()->user();
        if($user->tokenCan('Teacher')){
        try {
            $document = Document::find($id);
            $document_path = $document->document;
            if ($document_path != null) {
                $dnPath = public_path() . "/" . $document_path;
                if (File::exists($dnPath)) {
                    File::delete($dnPath);
                } 
            }
            $delete_document = $document->delete();
            $message = "Document Deleted.";
            return $this->sendResponse($delete_document, $message);
        } catch (\Exception $é) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Get Documents  By lesson Content Id
    public function getDocumentsLessonContent(Request $request){
        $get_documents=Document::Where('lesson_content_id','=',$request->id)
        ->join('lesson_contents','documents.lesson_content_id','lesson_contents.id')
        ->select(
            'lesson_contents.id as contentId',
            'documents.id as documentId',
            'documents.document as document')->get();
        $message='Texts';
        return $this->sendResponse($get_documents,$message);
    }
}
