<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;

class CategoryTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::onlyTrashed()
            ->select(['id', 'title', 'description', 'created_at'])
            ->paginate(15);

        return view('blog.admin.trash.categories.index', ['categoriesPaginator' => $paginator]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $category = BlogCategory::onlyTrashed()->find($id);

        if ($category === null) {
            return back()
                ->withErrors('Category not found')
                ->withInput();
        }

        return view('blog.admin.trash.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $category = BlogCategory::onlyTrashed()->find($id);

        if (empty($category)) {
            return back()
                ->withErrors('Category not found')
                ->withInput();
        }

        $result = $category->restore();

        if (!$result) {
            return back()
                ->withErrors('Category not restored')
                ->withInput();
        }

        return redirect()
            ->route('blog.admin.trash.categories.index')
            ->with('status', 'Restore successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = BlogCategory::onlyTrashed()
            ->find($id)
            ->forceDelete();

        if (!$result) {
            return back()
                ->withErrors('Article not deleted');
        }

        return redirect()
            ->route('blog.admin.trash.categories.index')
            ->with('status', 'Category was deleted');
    }
}
