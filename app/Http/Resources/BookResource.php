<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'bookCode'=>$this->book_code,
            'title' => $this->title,   
            'subject' => $this->subject, 
            'authorName'=>$this->author_name,
            'releaseDate' => $this->release_date,   
            'details' => $this->details,                     
        ];   
    }
}
