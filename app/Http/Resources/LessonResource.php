<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'lessonCode'=>$this->lesson_code,
            'lessonName' => $this->lesson_name,
            'lessonTime'=>$this->lesson_time,
        ];    
    }
}
