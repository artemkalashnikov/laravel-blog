<?php

namespace App\Observers;

use App\Models\BlogArticle;
use App\Models\BlogCategory;

class BlogCategoryObserver
{
    /**
     * Handle the BlogCategory "deleting" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return bool
     */
    public function deleting(BlogCategory $blogCategory)
    {
        if ($blogCategory->id === 1) {
            return false;
        }

        return true;
    }

    /**
     * Handle the BlogCategory "deleted" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function deleted(BlogCategory $blogCategory)
    {
        BlogArticle::where('category_id', $blogCategory->id)->update(['category_id' => 1]);
    }

    /**
     * Handle the BlogCategory "restoring" event.
     *
     * @param \App\Models\BlogCategory $blogCategory
     * @return void
     */
    public function restoring(BlogCategory $blogCategory)
    {
        $data = request()->all();
        $blogCategory->fill([
            'title'       => $data['title'],
            'description' => $data['description'],
        ]);
    }
}
