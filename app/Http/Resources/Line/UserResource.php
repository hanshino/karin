<?php

namespace App\Http\Resources\Line;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'userId' => $this->platform_id,
            'displayName' => $this->display_name,
            'pictureUrl' => $this->picture_url,
            'statusMessage' => $this->status_message,
        ];
    }
}
