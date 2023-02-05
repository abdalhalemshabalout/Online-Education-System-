<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestQuestionResource;
use App\Models\TestQuestion;
use Illuminate\Http\Request;

class TestQuestionExam extends ApiController
{
    //Add Test Question
    public function addTestQuestion(Request $request)
    {
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
            try {
                $add_test_question = TestQuestion::create([
                    'exam_id'=> $request->examId,
                    'question_number'=> $request->questionNumber,
                    'question'=> $request->question,
                    'answer_one'=>$request->answerOne,
                    'answer_two'=>$request->answerTwo,
                    'answer_three'=>$request->answerThree,
                    'answer_four'=>$request->answerFour,
                    'answer_five'=>$request->answerFive,
                    'correct_answer'=>$request->correctAnswer,
                    'answer_point' => $request->answerPoint,
                ]);
                $message = 'New Question has been added to Exam.';
                return $this->sendResponse(new TestQuestionResource($add_test_question), $message);
            } catch (\Exception $e) {
                $message = 'An error occurred during the add process.';
                return $this->sendError($message);
            }
        }
        return response()->json(['success'=>false]); 
    }
    //Update Test Question
    public function updateTestQuestion(Request $request, $id)
    {
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
        try {
            $update_test_question= TestQuestion::where('id', $id)->update([
                'question'=> $request->question,
                'answer_one'=>$request->answerOne,
                'answer_two'=>$request->answerTwo,
                'answer_three'=>$request->answerThree,
                'answer_four'=>$request->answerFour,
                'answer_five'=>$request->answerFive,
                'correct_answer'=>$request->correctAnswer,
                'answer_point' => $request->answerPoint
            ]);
            $message = 'Question updated successfully.';
            return $this->sendResponse($update_test_question, $message); 
        } catch (\Exception $e) {
            $message = 'Question could not be updated.';
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]); 
    }
    //Delete Test Question 
    public function deleteTestQuestion(Request $request, $id)
    {
        $user = auth()->user();
        if($user->tokenCan('Teacher') ){
        try {
            $find_question = TestQuestion::find($id);
            $delete_question = $find_question->delete();
            $message = "Question Deleted.";
            return $this->sendResponse($delete_question, $message);
        } catch (\Exception $é) {
            $message = "Something went wrong.";
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]); 
    }
    //Get Exam Questions
    public function getExamQuestions(Request $request){
        $get_exam_questions=TestQuestion::Where('exam_id','=',$request->id)
        ->join('exams','test_questions.exam_id','exams.id')
        ->select(
            'exams.id as examId',
            'test_questions.id as questionId',
            'test_questions.question_number as questionNumber',
            'test_questions.question as question',
            'test_questions.answer_one as answerOne',
            'test_questions.answer_two as answerTwo',
            'test_questions.answer_three as answerThree',
            'test_questions.answer_four as answerFour',
            'test_questions.answer_five as answerFive',
            'test_questions.correct_answer as correctAnswer',
            'test_questions.answer_point as answerPoint',
            )->get();
        $message='Exam Questions';
        return $this->sendResponse($get_exam_questions,$message);
    }
}