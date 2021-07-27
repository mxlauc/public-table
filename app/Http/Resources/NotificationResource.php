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
                return "<span class='fw-bold'>" . $this->data['user']['nombre'] ."</span>" . " a comentado tu publicación.";
            case 'App\Notifications\NewPostFollowed':
                return "<span class='fw-bold'>" . $this->data['user']['nombre'] ."</span>" . " a subido una nueva publicación.";
            case 'App\Notifications\NewLike':
                return "A <span class='fw-bold'>" . $this->data['user']['nombre'] ."</span>" . " le ha gustado tu publicación.";
            case 'App\Notifications\NewFollower':
                return "A <span class='fw-bold'>" . $this->data['user']['nombre'] ."</span>" . " ha comenzado a seguirte.";
        }
    }

    private function getUrl(){
        switch($this->type){
            case 'App\Notifications\NewComment':
                return route('posts.show', ["post" => $this->data['post'], "notification" => $this->id]);
            case 'App\Notifications\NewPostFollowed':
                return route('posts.show', ["post" => $this->data['post'], "notification" => $this->id]);
            case 'App\Notifications\NewLike':
                return route('posts.show', ["post" => $this->data['post'], "notification" => $this->id]);
            case 'App\Notifications\NewFollower':
                return User::find($this->data['user']['id'])->getUrl() . '?notification=' . $this->id;
        }
    }
}
