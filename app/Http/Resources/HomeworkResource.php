<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkResource extends JsonResource
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
            'lessonContentId'=>$this->lesson_content_id,
            'name' => $this->name,     
            'description' => $this->description,     
            'document' => $this->document,     
            'startDate' => $this->start_date,     
            'endDate' => $this->end_date,     
        ]; 
    }
}
