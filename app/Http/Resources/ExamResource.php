<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'examId'=>$this->id,
            'lessonContentId'=>$this->lesson_content_id,
            'examName' => $this->exam_name,
            'questionNumber' => $this->question_number,
            'examTime' => $this->exam_time,
            'successGrade'=>$this->success_grade,
            'startDate'=>date('d-m-Y H:i', strtotime($this->start_date)),
            'endDate'=>date('d-m-Y H:i', strtotime($this->end_date)),
            'isActive'=>$this->isActive,
        ];
    }
}
