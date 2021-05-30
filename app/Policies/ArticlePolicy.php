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
     * Perform update checks.
     *
     * @param User $user
     * @param BlogArticle $article
     * @return bool
     */
    public function update(User $user, BlogArticle $article)
    {
        return $user->id === $article->user_id;
    }

    /**
     * Perform delete checks.
     *
     * @param User $user
     * @param BlogArticle $article
     * @return bool
     */
    public function delete(User $user, BlogArticle $article)
    {
        return $user->id === $article->user_id;
    }
}
