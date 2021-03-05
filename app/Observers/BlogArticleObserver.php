<?php

namespace App\Observers;

use App\Models\BlogArticle;

class BlogArticleObserver
{
    /**
     * Handle the BlogArticle "saving" event.
     * @param BlogArticle $blogArticle
     * @return void
     */
    public function saving(BlogArticle $blogArticle)
    {
        $isPublished = request()->input('is_published');
        $publishedAt = $blogArticle->getAttribute('published_at');

        if ($isPublished && $publishedAt === null) {

            $blogArticle->fill([
                'published_at' => now(),
            ]);
        } else if (!$isPublished){

            $blogArticle->fill([
                'published_at' => null,
            ]);
        }
    }

    /**
     * Handle the BlogArticle "deleting" event.
     *
     * @param  \App\Models\BlogArticle  $blogArticle
     * @return void
     */
    public function deleting(BlogArticle $blogArticle)
    {
        $blogArticle->update([
            'is_published' => 0,
            'published_at' => null,
        ]);
    }

    /**
     * Handle the BlogArticle "restoring" event.
     *
     * @param  \App\Models\BlogArticle  $blogArticle
     * @return void
     */
    public function restoring(BlogArticle $blogArticle)
    {
        $data = request()->all();
        $blogArticle->fill([
            'title'        => $data['title'],
            'content'      => $data['content'],
            'fragment'     => $data['fragment'],
            'category_id'  => $data['category_id'],
            'is_published' => $data['is_published'],
        ]);
    }
}
