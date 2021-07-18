<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" =>$this->id,
            "descripcion" => $this->descripcion,
            "imagen" => $this->imagen,
            "created_at" => $this->created_at,
            "user" => new UserResource($this->whenLoaded('user')),
        ];
    }
}
