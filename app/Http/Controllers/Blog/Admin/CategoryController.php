<?php

namespace App\Http\Controllers\Blog\Admin;

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

        return view('blog.admin.categories.index', ['categoriesPaginator' => $paginator]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.admin.categories.create');
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
                ->withErrors('Category not created')
                ->withInput();
        }

        return redirect()
            ->route('blog.admin.categories.edit', $category->id)
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
        $category = BlogCategory::on()->find($id);

        if ($category === null) {
            return back()
                ->withErrors('Category not found')
                ->withInput();
        }

        return view('blog.admin.categories.edit', ['category' => $category]);
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
                ->withErrors('Category not found')
                ->withInput();
        }

        $data = $request->all();
        $result = $category->update($data);

        if (!$result) {
            return back()
                ->withErrors('Category not updated')
                ->withInput();
        }

        return redirect()
            ->route('blog.admin.categories.edit', $category->id)
            ->with('status', 'Category saved successful');
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
                ->withErrors('Category not deleted');
        }

        return redirect()
            ->route('blog.admin.categories.index')
            ->with('status', 'Category was deleted');
    }
}
