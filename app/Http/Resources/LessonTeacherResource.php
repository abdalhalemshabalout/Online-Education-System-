<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonTeacherResource extends JsonResource
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
            'classroomId'=>$this->classroom_id,
            'branchId' => $this->branch_id,     
            'teacherId'=>$this->teacher_id,
            'lessonId' => $this->lesson_id,
        ];   
    }
}
