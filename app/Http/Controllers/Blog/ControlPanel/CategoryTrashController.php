<?php

namespace App\Http\Controllers\Blog\ControlPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
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

        return view('blog.control-panel.trash.categories.index', [
            'title'                 =>    __('blog.header-categories-show-trash'),
            'categoriesPaginator'   =>    $paginator,
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
        $category = BlogCategory::onlyTrashed()->find($id);

        if (empty($category)) {
            return back()
                ->withErrors(__('blog.error-category-not-found'))
                ->withInput();
        }

        return view('blog.control-panel.trash.categories.edit', [
            'title'         =>  __('blog.header-category-edit'),
            'category'      =>  $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogCategoryRequest $request, $id)
    {
        $category = BlogCategory::onlyTrashed()->find($id);

        if (empty($category)) {
            return back()
                ->withErrors(__('blog.error-category-not-found'))
                ->withInput();
        }

        $result = $category->restore();

        if (!$result) {
            return back()
                ->withErrors(__('blog.error-category-not-restored'))
                ->withInput();
        }

        return redirect()
            ->route('blog.control-panel.trash.categories.index')
            ->with('status', __('blog.success-category-restored'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $category = BlogCategory::onlyTrashed()->find($id);

        if (empty($category)) {
            return back()
                ->withErrors(__('blog.error-category-not-found'))
                ->withInput();
        }

        $result = $category->forceDelete();

        if (!$result) {
            return back()
                ->withErrors(__('blog.error-category-not-deleted'));
        }

        return redirect()
            ->route('blog.control-panel.trash.categories.index')
            ->with('status', __('blog.success-category-deleted'));
    }
}
