<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? __('blog.header') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="flex flex-col min-h-screen">
    <header class="bg-gray-100 flex-shrink-0">
        <div class="flex items-center px-8 py-6 container mx-auto ">
            <h1 class="text-4xl text-red-900 font-bold pr-2">
                <a href="{{ route('blog.articles.index') }}">{{ $title ?? __('blog.header') }}</a>
            </h1>
            @auth()
                <p class="ml-auto text-sm text-gray-600">{{ request()->user()->email }}</p>
                @if(request()->is('control-panel/*'))
                    <a href="{{ route('blog.articles.index') }}" class="ml-8 flex items-center justify-center w-48 h-8 bg-white border border-solid border-red-700 rounded text-red-700" type="submit">{{ __('blog.btn-exit-control-panel') }}</a>
                @else
                    <a href="{{ route('blog.control-panel.articles.index') }}" class="ml-8 flex items-center justify-center w-48 h-8 bg-white border border-solid border-red-700 rounded text-red-700" type="submit">{{ __('blog.btn-control-panel') }}</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="ml-8">
                    @csrf
                    <button class="block w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">{{ __('blog.btn-logout') }}</button>
                </form>
            @else
                <a href="{{ route('login.view') }}" class="ml-auto flex items-center justify-center w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">{{ __('blog.btn-login') }}</a>
                <a href="{{ route('registration.view') }}" class="ml-4 flex items-center justify-center w-32 h-8 text-white bg-red-700 border border-solid border-red-700 rounded">{{ __('blog.btn-registration') }}</a>
            @endauth
        </div>
    </header>
    <div class="container flex items-start mx-auto px-8 py-6 flex-grow">
