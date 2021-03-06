<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if ($request->user()) {
            return redirect()
                ->route('blog.articles.index')
                ->with('status', __('blog.already-logged-in', ['name' => $request->user()->name]));
        }

        return view('blog.auth.login', [
            'title' => __('blog.header-login'),
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()
                ->withInput()
                ->withErrors(__('auth.failed'));
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('blog.articles.index'))
            ->with('status', __('blog.success-hello-user', ['name' => $request->user()->name]));
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('blog.articles.index'));
    }
}
