<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamController extends ApiController
{
    //Add Exam
    public function addExam(Request $request)
    {
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
        try {
            $add_exam = Exam::create([
                'lesson_content_id'=>$request->lessonContentId,
                'exam_name' => $request->examName,
                'question_number' => $request->questionNumber,
                'exam_time' => $request->examTime,
                'success_grade' => $request->successGrade,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
            ]);
            $message = 'New Exam has been added to the lesson content.';
            return $this->sendResponse(new ExamResource($add_exam), $message);
        } catch (\Exception $e) {
            $message = 'An error occurred during the add process.';
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]); 
    }
    //Update Exam 
    public function updateExam(Request $request, $id)
    {
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
        try {
            $update_exam = Exam::where('id', $id)->update([
                'exam_name' => $request->examName,
                'question_number' => $request->questionNumber,
                'exam_time' => $request->examTime,
                'success_grade' => $request->successGrade,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
            ]);
            $message = 'Exam updated successfully.';
            return $this->sendResponse($update_exam, $message);
        } catch (\Exception $e) {
            $message = 'Exam could not be updated.';
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]); 
    }
    //Delete Exam
    public function deleteExam(Request $request, $id)
    {
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
        try {
            $find_exam = Exam::find($id);
            $delete_exam = $find_exam->delete();
            $message = "Exam Deleted.";
            return $this->sendResponse($delete_exam, $message);
        } catch (\Exception $é) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]); 
    }
    //Get Exams  By lesson Content Id
    public function getExamsLessonContent(Request $request){
        $get_exams=Exam::Where('lesson_content_id','=',$request->id)
        ->join('lesson_contents','exams.lesson_content_id','lesson_contents.id')
        ->select(
            'lesson_contents.id as contentId',
            'exams.id as examId',
            'exams.exam_name as examName',
            'exams.question_number as questionNumber',
            'exams.exam_time as examTime',
            'exams.success_grade as successGrade',
            'exams.start_date as startDate',
            'exams.end_date as endDate',
            )->get();
        $message='Exams';
        return $this->sendResponse($get_exams,$message);
    }
}