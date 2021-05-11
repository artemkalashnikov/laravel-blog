<?php

namespace App\Policies;

use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param User $user
     * @return void|bool
     */
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     *
     * @param User $user
     * @param BlogArticle $blogArticle
     * @return bool
     */
    public function update(User $user, BlogArticle $blogArticle)
    {
        if ($user->id === $blogArticle->user_id) {
            return true;
        }

        return false;
    }
}
