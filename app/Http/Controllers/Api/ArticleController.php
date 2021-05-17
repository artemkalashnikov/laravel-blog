<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\BlogArticle;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ArticleCollection
     */
    public function index()
    {
        $articles = BlogArticle::on()
            ->with(['user', 'category'])
            ->get();

        return new ArticleCollection($articles);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ArticleResource
     */
    public function show($id)
    {
        $article = BlogArticle::on()
            ->with(['user', 'category'])
            ->findOrFail($id);

        return new ArticleResource($article);
    }
}
