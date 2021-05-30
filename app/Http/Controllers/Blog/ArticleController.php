<?php

namespace App\Http\Controllers\Blog;

use App\Filters\ArticleFilters\ArticleAuthorFilter;
use App\Filters\ArticleFilters\ArticleCategoryFilter;
use App\Filters\ArticleFilters\ArticleTitleFilter;
use App\Filters\QueryFiltersCollection;
use App\Http\Controllers\Controller;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        $filters = QueryFiltersCollection::make([
            new ArticleTitleFilter($request->input('title')),
            new ArticleCategoryFilter($request->input('category')),
            new ArticleAuthorFilter($request->input('author')),
        ]);

        $articles = BlogArticle::on()
            ->filter($filters)
            ->published()
            ->select(['id', 'title', 'fragment', 'is_published', 'published_at', 'user_id', 'category_id', 'created_at'])
            ->with(['user', 'category'])
            ->orderByDesc('published_at')
            ->orderBy('title');


        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        $users = User::on()
            ->select(['id', 'name'])
            ->get();

        $paginator = $articles->paginate(15)->withQueryString();

        return view('blog.articles.index', [
            'articlesPaginator' =>  $paginator,
            'categories'        =>  $categories,
            'users'             =>  $users,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $article = BlogArticle::on()->find($id);

        if (empty($article)) {
            return back()
                ->withErrors(__('blog.error-article-not-found'))
                ->withInput();
        }

        return view('blog.articles.show', [
            'title'     =>  $article->title,
            'article'   =>  $article,
        ]);
    }
}
