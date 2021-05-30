<?php

namespace App\Http\Controllers\Blog\ControlPanel;

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
            ->with(['user', 'category'])
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        $users = User::on()
            ->select(['id', 'name'])
            ->get();

        $paginator = $articles->paginate(15)->withQueryString();

        return view('blog.control-panel.articles.index', [
            'title'             =>  __('blog.header-articles-show'),
            'articlesPaginator' =>  $paginator,
            'categories'        =>  $categories,
            'users'             =>  $users,
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

        return view('blog.control-panel.articles.create', [
            'title'         =>  __('blog.header-article-create'),
            'categories'    =>  $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogArticleRequest $request)
    {
        $data = $request->validated();
        $article = BlogArticle::on()->create($data);

        if (empty($article)) {
            return back()
                ->withErrors(__('blog.error-article-not-created'))
                ->withInput();
        }

        return redirect()
            ->route('blog.control-panel.articles.edit', $article->id)
            ->with('status', __('blog.success-article-created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $article = BlogArticle::on()->find($id);

        if (empty($article)) {
            return back()
                ->withErrors(__('blog.error-article-not-found'))
                ->withInput();
        }

        if ($request->user()->cannot('update', $article)) {
            return back()
                ->withErrors(__('blog.error-permissions'));
        }

        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        return view('blog.control-panel.articles.edit', [
            'title'         =>  __('blog.header-article-edit'),
            'article'       =>  $article,
            'categories'    =>  $categories,
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
                ->withErrors(__('blog.error-article-not-found'))
                ->withInput();
        }

        if ($request->user()->cannot('update', $article)) {
            return back()
                ->withErrors(__('blog.error-permissions'));
        }

        $data = $request->validated();
        $result = $article->update($data);

        if (!$result) {
            return back()
                ->withErrors(__('blog.error-article-not-updated'))
                ->withInput();
        }

        return redirect()
            ->route('blog.control-panel.articles.edit', $article->id)
            ->with('status', __('blog.success-article-updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $article = BlogArticle::on()->find($id);

        if (empty($article)) {
            return back()
                ->withErrors(__('blog.error-article-not-found'))
                ->withInput();
        }

        if ($request->user()->cannot('delete', $article)) {
            return back()
                ->withErrors(__('blog.error-permissions'));
        }

        $result = $article->delete();

        if (!$result) {
            return back()
                ->withErrors(__('blog.error-article-not-deleted'));
        }

        return redirect()
            ->route('blog.control-panel.articles.index')
            ->with('status', __('blog.success-article-deleted'));
    }
}
