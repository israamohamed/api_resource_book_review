<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'created_at' => date("Y-m-d h:i a" , strtotime( $this->created_at)),
            'rate' => $this->rate,
            'body' => $this->body,
            'user' => new UserResource($this->user),
        ];
    }
}
