<?php

use App\Http\Controllers\Blog\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Blog\Admin\ArticleTrashController;
use App\Http\Controllers\Blog\Admin\CategoryTrashController;
use App\Http\Controllers\Blog\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Blog\ArticleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('blog')->group(function () {
    Route::resource('articles', ArticleController::class)->names('blog.articles');
});

//Admin panel
Route::prefix('admin/blog')->name('blog.admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class)
        ->except('show');

    Route::resource('articles', AdminArticleController::class)
        ->except('show');

    //Trash
    Route::prefix('trash')->name('trash.')->group(function () {
        Route::resource('categories', CategoryTrashController::class)
            ->except('create', 'store', 'show');

        Route::resource('articles', ArticleTrashController::class)
            ->except('create', 'store', 'show');
    });
});
