<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogArticleCreateRequest;
use App\Http\Requests\BlogArticleUpdateRequest;
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
        $articles = BlogArticle::on()
            ->filtered($request)
            ->select(['id', 'title', 'fragment', 'is_published', 'published_at', 'user_id', 'category_id', 'created_at'])
            ->with(['user:id,name', 'category:id,title'])
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc');

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
            'users' => $users,
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
     * @param BlogArticleCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogArticleCreateRequest $request)
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
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $article = BlogArticle::on()->find($id);
        $categories = BlogCategory::on()
            ->select(['id', 'title'])
            ->get();

        if ($article === null) {
            return back()
                ->withErrors('Article not found')
                ->withInput();
        }

        return view('blog.admin.articles.edit', [
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
        $article = BlogArticle::on()->find($id);

        if (empty($article)) {
            return back()
                ->withErrors('Article not found')
                ->withInput();
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
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = BlogArticle::destroy($id);

        if (!$result) {
            return back()
                ->withErrors('Article not deleted');
        }

        return redirect()
            ->route('blog.admin.articles.index')
            ->with('status', 'Article was deleted');
    }
}
