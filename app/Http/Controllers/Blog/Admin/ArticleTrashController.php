<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogArticleUpdateRequest;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\User;
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
        $articles = BlogArticle::onlyTrashed()
            ->filtered($request)
            ->select(['id', 'title', 'fragment', 'is_published', 'published_at', 'user_id', 'category_id', 'created_at'])
            ->with(['user:id,name', 'category:id,title'])
            ->orderBy('published_at', 'desc');

        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        $users = User::on()
            ->select(['id', 'name'])
            ->get();

        $paginator = $articles->paginate(15)->withQueryString();

        return view('blog.admin.trash.articles.index', [
            'articlesPaginator' => $paginator,
            'categories' => $categories,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $article = BlogArticle::onlyTrashed()->find($id);

        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        if ($article === null) {
            return back()
                ->withErrors('Article not found')
                ->withInput();
        }

        return view('blog.admin.trash.articles.edit', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogArticleUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogArticleUpdateRequest $request, $id)
    {
        $article = BlogArticle::onlyTrashed()->find($id);

        if (empty($article)) {
            return back()
                ->withErrors('Article not found')
                ->withInput();
        }

        $result = $article->restore();

        if (!$result) {
            return back()
                ->withErrors('Article not restored')
                ->withInput();
        }

        return redirect()
            ->route('blog.admin.trash.articles.index')
            ->with('status', 'Restore was successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = BlogArticle::onlyTrashed()
            ->find($id)
            ->forceDelete();

        if (!$result) {
            return back()
                ->withErrors('Article not deleted');
        }

        return redirect()
            ->route('blog.admin.trash.articles.index')
            ->with(['status' => 'Article was deleted']);
    }
}
