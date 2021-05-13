<?php

namespace App\Http\Controllers\Blog\ControlPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::on()
            ->select(['id', 'title', 'description', 'created_at'])
            ->paginate(15);

        return view('blog.control-panel.categories.index', [
            'title'                 =>  __('blog.header-categories-show'),
            'categoriesPaginator'   =>  $paginator,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.control-panel.categories.create', ['title' => __('blog.header-category-create')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogCategoryRequest $request)
    {
        $data = $request->all();
        $category = BlogCategory::on()->create($data);

        if (!$category->exists) {
            return back()
                ->withErrors(__('blog.error-category-not-created'))
                ->withInput();
        }

        return redirect()
            ->route('blog.control-panel.categories.edit', $category->id)
            ->with('status', __('blog.success-category-created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $category = BlogCategory::on()->find($id);

        if (empty($category)) {
            return back()
                ->withErrors(__('blog.error-category-not-found'))
                ->withInput();
        }

        return view('blog.control-panel.categories.edit', [
            'title'     =>   __('blog.header-category-edit'),
            'category'  =>   $category,
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
        $category = BlogCategory::on()->find($id);

        if (empty($category)) {
            return back()
                ->withErrors(__('blog.error-category-not-found'))
                ->withInput();
        }

        $data = $request->all();
        $result = $category->update($data);

        if (!$result) {
            return back()
                ->withErrors(__('blog.error-category-not-updated'))
                ->withInput();
        }

        return redirect()
            ->route('blog.control-panel.categories.edit', $category->id)
            ->with('status', __('blog.success-category-updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = BlogCategory::destroy($id);

        if (!$result) {
            return back()
                ->withErrors(__('blog.error-category-not-deleted'));
        }

        return redirect()
            ->route('blog.control-panel.categories.index')
            ->with('status', __('blog.success-category-deleted'));
    }
}
