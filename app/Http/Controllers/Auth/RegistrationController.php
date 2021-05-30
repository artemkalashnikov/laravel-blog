<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('blog.auth.registration', [
            'title' => __('blog.header-registration'),
        ]);
    }

    /**
     * @param RegistrationRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RegistrationRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            return back()
                ->withInput()
                ->withErrors([__('blog.error-user-exist', ['email' => $user->email])]);
        }

        /** @var User $user */
        $user = User::on()->create($data);
        Auth::login($user);

        return redirect(route('blog.articles.index'))
            ->with('status', __('blog.success-hello-user', ['name' => $request->user()->name]));
    }
}
