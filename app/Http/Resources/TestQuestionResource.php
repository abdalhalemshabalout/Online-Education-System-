<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return 
        [
            'examId'=>$this->exam_id,
            'questionNumber' => $this->question_number,
            'question' => $this->question,
            'answerOne' => $this->answer_one,
            'answerTwo' => $this->answer_two,
            'answerThree' => $this->answer_three,
            'answerFour' => $this->answer_four,
            'answerFive' => $this->answer_five,
            'correctAnswer' => $this->correct_answer,
            'answerPoint' => $this->answer_point,
        ];
    }
}
