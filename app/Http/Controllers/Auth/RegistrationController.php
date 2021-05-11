<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * @param RegistrationRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RegistrationRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        /** @var User $user */
        $user = User::on()->create($data);
        Auth::login($user);

        return redirect(route('blog.articles.index'));
    }
}
