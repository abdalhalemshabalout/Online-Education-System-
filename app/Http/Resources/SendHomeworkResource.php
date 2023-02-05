<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SendHomeworkResource extends JsonResource
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
            'homeworkId'=>$this->homework_id,
            'userId' => $this->student_id,     
            'document' => $this->document,     
        ];
    }
}
