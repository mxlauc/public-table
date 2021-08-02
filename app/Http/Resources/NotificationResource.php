<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            "id" => $this->id,
            "imagen" => $this->data["user"]["avatar"],
            "descripcion" => $this->getDescripcion(),
            "url" => $this->getUrl(),
            "timestamp" => strtotime($this->created_at),
            "visto" => $this->read_at != null
        ];
    }

    private function getDescripcion(){

        switch($this->type){
            case 'App\Notifications\NewComment':
                return __("has comment your publication", ["name" => $this->data['user']['nombre']]);
            case 'App\Notifications\NewPostFollowed':
                return __("has created a publication", ["name" => $this->data['user']['nombre']]);
            case 'App\Notifications\NewLike':
                return __("has liked your publication", ["name" => $this->data['user']['nombre']]);
            case 'App\Notifications\NewFollower':
                return __("has followed you", ["name" => $this->data['user']['nombre']]);
            case 'App\Notifications\NewCommentLike':
                return __("has liked your comment", ["name" => $this->data['user']['nombre']]);
        }
    }

    private function getUrl(){
        switch($this->type){
            case 'App\Notifications\NewComment':

            case 'App\Notifications\NewCommentLike':

            case 'App\Notifications\NewPostFollowed':

            case 'App\Notifications\NewLike':
                return route('posts.show', ["post" => $this->data['post'], "notification" => $this->id]);
            case 'App\Notifications\NewFollower':
                return User::find($this->data['user']['id'])->getUrl() . '?notification=' . $this->id;
        }
    }
}
