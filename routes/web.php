<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Blog\ControlPanel\ArticleController as ControlPanelArticleController;
use App\Http\Controllers\Blog\ControlPanel\ArticleTrashController as ControlPanelArticleTrashController;
use App\Http\Controllers\Blog\ControlPanel\CategoryController as ControlPanelCategoryController;
use App\Http\Controllers\Blog\ControlPanel\CategoryTrashController as ControlPanelCategoryTrashController;
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

Route::get('login', [LoginController::class, 'index'])->name('login.view');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('registration', [RegistrationController::class, 'index'])->name('registration.view');
Route::post('registration', [RegistrationController::class, 'store'])->name('registration');

Route::prefix('blog')->name('blog.articles.')->group(function () {
    Route::get('articles', [ArticleController::class, 'index'])->name('index');
    Route::get('articles/{article}', [ArticleController::class, 'show'])->name('show');
});

//Admin panel
Route::prefix('control-panel/blog')->name('blog.control-panel.')->middleware('auth')->group(function () {
    Route::resource('categories', ControlPanelCategoryController::class)
        ->except('show')
        ->middleware('admin');

    Route::resource('articles', ControlPanelArticleController::class)
        ->except('show');

    //Trash
    Route::prefix('trash')->name('trash.')->group(function () {
        Route::resource('categories', ControlPanelCategoryTrashController::class)
            ->except('create', 'store', 'show')
            ->middleware('admin');

        Route::resource('articles', ControlPanelArticleTrashController::class)
            ->except('create', 'store', 'show');
    });
});
