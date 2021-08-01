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
use App\Services\HtmlRenderService;
use Illuminate\Http\Request;

class ArticleTrashController extends Controller
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

        $articles = BlogArticle::onlyTrashed()
            ->filter($filters)
            ->select(['id', 'title', 'fragment', 'is_published', 'published_at', 'user_id', 'category_id', 'created_at'])
            ->with(['user', 'category'])
            ->orderByDesc('published_at');

        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        $users = User::on()
            ->select(['id', 'name'])
            ->get();

        $paginator = $articles->paginate(15)->withQueryString();

        return view('blog.control-panel.trash.articles.index', [
            'title'             => __('blog.header-articles-show-trash'),
            'articlesPaginator' =>  $paginator,
            'categories'        =>  $categories,
            'users'             =>  $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $article = BlogArticle::onlyTrashed()->find($id);

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

        $articles = BlogArticle::on()
            ->select(['id', 'title'])
            ->orderByDesc('id')
            ->get();

        return view('blog.control-panel.trash.articles.edit', [
            'title'             =>  __('blog.header-article-edit'),
            'current_article'   =>  $article,
            'categories'        =>  $categories,
            'articles'          =>  $articles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogArticleRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogArticleRequest $request, $id, HtmlRenderService $renderService)
    {
        $article = BlogArticle::onlyTrashed()->find($id);
        $data = $request->validated();
        $data['content'] = $renderService->replaceAllowedTags($data['content']);

        if (empty($article)) {
            return back()
                ->withErrors(__('blog.error-article-not-found'))
                ->withInput();
        }

        if ($request->user()->cannot('update', $article)) {
            return back()
                ->withErrors(__('blog.error-permissions'));
        }

        $article->fill($data);

        if(isset($data['child_ids']))
        {
            $article->child_articles()->sync($data['child_ids']);
        }

        if(isset($data['parent_ids']))
        {
            $article->parent_articles()->sync($data['parent_ids']);
        }

        $result = $article->restore();

        if (!$result) {
            return back()
                ->withErrors(__('blog.error-article-not-restored'))
                ->withInput();
        }

        return redirect()
            ->route('blog.control-panel.trash.articles.index')
            ->with('status', __('blog.success-article-restored'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $article = BlogArticle::onlyTrashed()->find($id);

        if (empty($article)) {
            return back()
                ->withErrors(__('blog.error-article-not-found'))
                ->withInput();
        }

        if ($request->user()->cannot('delete', $article)) {
            return back()
                ->withErrors(__('blog.error-permissions'));
        }

        $result = $article->forceDelete();

        if (!$result) {
            return back()
                ->withErrors(__('blog.error-article-not-deleted'));
        }

        return redirect()
            ->route('blog.control-panel.trash.articles.index')
            ->with('status', __('blog.success-article-deleted'));
    }
}
