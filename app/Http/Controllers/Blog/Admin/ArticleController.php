<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Filters\ArticleFilters\ArticleAuthorFilter;
use App\Filters\ArticleFilters\ArticleCategoryFilter;
use App\Filters\ArticleFilters\ArticleIsPublishedFilter;
use App\Filters\ArticleFilters\ArticleTitleFilter;
use App\Filters\QueryFiltersCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogArticleRequest;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = QueryFiltersCollection::make([
            new ArticleTitleFilter($request->input('title')),
            new ArticleCategoryFilter($request->input('category')),
            new ArticleIsPublishedFilter($request->input('published')),
        ]);

        if (!$request->user()->isAdmin()) {
            $filters->push(new ArticleAuthorFilter($request->user()->id));
        }

        $articles = BlogArticle::on()
            ->filter($filters)
            ->select(['id', 'title', 'fragment', 'is_published', 'published_at', 'user_id', 'category_id', 'created_at'])
            ->with(['user:id,name', 'category:id,title'])
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        $users = User::on()
            ->select(['id', 'name'])
            ->get();

        $paginator = $articles->paginate(15)->withQueryString();

        return view('blog.admin.articles.index', [
            'articlesPaginator' => $paginator,
            'categories' => $categories,
            'users' => $users || null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        return view('blog.admin.articles.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogArticleRequest $request)
    {
        $data = $request->all();
        $article = BlogArticle::on()->create($data);

        if (!$article->exists) {
            return back()
                ->withErrors('Article not created')
                ->withInput();
        }

        return redirect()
            ->route('blog.admin.articles.edit', $article->id)
            ->with('status', 'Created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $article = BlogArticle::on()->find($id);

        if ($article === null) {
            return back()
                ->withErrors('Article not found')
                ->withInput();
        }

        if (!Gate::allows('update', $article)) {
            return back()
                ->withErrors('You don\'t have permissions');
        }

        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        return view('blog.admin.articles.edit', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogArticleRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogArticleRequest $request, $id)
    {
        $article = BlogArticle::on()->find($id);

        if (empty($article)) {
            return back()
                ->withErrors('Article not found')
                ->withInput();
        }

        if (!Gate::allows('update', $article)) {
            return back()
                ->withErrors('You don\'t have permissions');
        }

        $data = $request->all();
        $result = $article->update($data);

        if (!$result) {
            return back()
                ->withErrors('Article not updated')
                ->withInput();
        }

        return redirect()
            ->route('blog.admin.articles.edit', $article->id)
            ->with('status', 'Update was successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $article = BlogArticle::on()->find($id);

        if (!Gate::allows('update', $article)) {
            return back()
                ->withErrors('You don\'t have permissions');
        }

        $result = $article->delete();

        if (!$result) {
            return back()
                ->withErrors('Article not deleted');
        }

        return redirect()
            ->route('blog.admin.articles.index')
            ->with('status', 'Article was deleted');
    }
}
