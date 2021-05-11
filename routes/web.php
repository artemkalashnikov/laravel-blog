<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Blog\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Blog\Admin\ArticleTrashController as AdminArticleTrashController;
use App\Http\Controllers\Blog\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Blog\Admin\CategoryTrashController as AdminCategoryTrashController;
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

Route::view('login', 'blog.auth.login')->name('login.view');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::view('registration', 'blog.auth.registration')->name('registration.view');
Route::post('registration', [RegistrationController::class, 'store'])->name('registration');

Route::prefix('blog')->name('blog.articles.')->group(function () {
    Route::get('articles', [ArticleController::class, 'index'])->name('index');
    Route::get('articles/{article}', [ArticleController::class, 'show'])->name('show');
});

//Admin panel
Route::prefix('admin/blog')->name('blog.admin.')->middleware('auth')->group(function () {
    Route::resource('categories', AdminCategoryController::class)
        ->except('show')
        ->middleware('admin');

    Route::resource('articles', AdminArticleController::class)
        ->except('show');

    //Trash
    Route::prefix('trash')->name('trash.')->group(function () {
        Route::resource('categories', AdminCategoryTrashController::class)
            ->except('create', 'store', 'show')
            ->middleware('admin');

        Route::resource('articles', AdminArticleTrashController::class)
            ->except('create', 'store', 'show');
    });
});
