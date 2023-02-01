<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class LinkController extends ApiController
{
    //Add link ot lesson Content
    public function addLink(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Teacher')){
            try{
                $add_link=Link::create([
                    'lesson_content_id'=>$request->lessonContentId,
                    'url'=>$request->url
                ]);
                $message='New Link has been added to the lesson content';
                return $this->sendResponse(new LinkResource($add_link),$message);
            }catch(\Exception $e){
                $message='An error occurred during the add process.';
                return $this->sendError($message);
            }
        }
        return response()->json(['success'=>false]);
    }
    //Update link Lesson Content
    public function updateLink(Request $request ,$id){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
            $update_link = Link::where('id', $id)->update([
                'url'=>$request->url
            ]);
            $message = 'Link updated successfully.';
            return $this->sendResponse($update_link, $message);
        } catch (\Exception $e) {
            $message = 'Link could not be updated.';
            return $this->sendError($e->getMessage());
        }
        }
        return response()->json(['success'=>false]);
    }
    //Delete link Lesson Content
    public function deleteLink($id){
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
            $link_find = Link::find($id);
            $delete_link = $link_find->delete();
            $message = "Link Deleted.";
            return $this->sendResponse($delete_link, $message);
        } catch (\Exception $e) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Get links  By lesson Content Id
    public function getLinksLessonContent(Request $request){
        $get_links=Link::Where('lesson_content_id','=',$request->id)
        ->join('lesson_contents','links.lesson_content_id','lesson_contents.id')
        ->select(
            'lesson_contents.id as contentId',
            'links.id as linkId',
            'links.url')->get();
        $message='Links';
        return $this->sendResponse($get_links,$message);
    }
}
