<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            "my_like" => $this->when(Auth::user(), function(){
                return $this->myLike();
            }),
            "contador" => $this->contador(),
            "created_at" => strtotime($this->created_at),
            "user" => new UserResource($this->whenLoaded('user')),
        ];
    }

    public function myLike(){
        return !$this->likes->where("user_id", Auth::user()->id)->isEmpty();
    }

    public function contador(){
        return $this->likes->count();
    }

}
