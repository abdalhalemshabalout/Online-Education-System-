<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestAnswerResource;
use App\Models\Exam;
use App\Models\SendTestAnswer;
use App\Models\TestQuestion;
use App\Models\User;
use Illuminate\Http\Request;

class SendTestAnswerController extends ApiController
{
    //get Question 
    public function getQuestion(Request $request){
        $question_total=TestQuestion::where('exam_id','=',$request->input('examId'))
        ->select('question_id')->count();

        $question=Exam::where('exams.id','=',$request->input('examId'))
        ->join('test_questions','test_questions.exam_id','exams.id')
        ->select('test_questions.id as questionId','test_questions.exam_id as examId','test_questions.question_type as questionType',
        'test_questions.question_number as questionNumber','test_questions.question as question',
        'test_questions.answer_one as answerOne','test_questions.answer_two as answerTwo',
        'test_questions.answer_three as answerThree','test_questions.answer_four as answerFour',
        'test_questions.answer_five as answerFive','test_questions.correct_answer as correctAnswer','test_questions.answer_point as answerPoint'
        )->get();

        if($question_total>=$request->input('questionNumber')){
            $first_question=$question[$request->input('questionNumber')-1];
        }         
        $message = 'Başarılı';
        return $this->sendResponse($first_question, $message);
    }
    //Send Answer
    public function sendAnswer(Request $request)
    {
        $user = auth()->user();
        if($user->tokenCan('Student') ){
            try {
                $user = User::where('users.id','=',$request->user()->id)
                ->join('students','users.user_id','students.id')
                ->select('students.id as studentId')
                ->get();
                $userId = $user[0]['studentId'];
                $send_test_answer = SendTestAnswer::create([
                      'student_id'=>$userId,
                      'exam_id'=> $request->examId,
                      'question_id'=> $request->questionId,
                      'answer'=>$request->answer,
                ]);               
                $message = 'Cevap Gönderildi.';
                return $this->sendResponse(new TestAnswerResource($send_test_answer), $message);
            } catch (\Exception $e) {
                $message = 'Bir hata oluştu.';
                return $this->sendError($e->getMessage());
            }
        }
        return response()->json(['success'=>false]); 
    }
}
