<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public static $wrap = 'article';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            =>  $this->id,
            'title'         =>  $this->title,
            'fragment'      =>  $this->fragment,
            'content'       =>  $this->content,
            'user'          =>  UserResource::make($this->user),
            'category'      =>  CategoryResource::make($this->category),
            'published_at'  =>  $this->published_at,
        ];
    }
}
