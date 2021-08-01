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
    public function creating(BlogArticle $blogArticle)
    {
        $blogArticle['user_id'] = request()->user()->id;
    }

    /**
     * Handle the BlogArticle "saving" event.
     * @param BlogArticle $blogArticle
     * @return void
     */
    public function saving(BlogArticle $blogArticle)
    {
        $isDirtyIsPublished = $blogArticle->isDirty('is_published');
        $isPublished = $blogArticle->getAttribute('is_published');

        if ($isDirtyIsPublished && $isPublished) {
            $blogArticle->fill([
                'published_at' => now(),
            ]);
        } else if ($isDirtyIsPublished && !$isPublished){
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
}
