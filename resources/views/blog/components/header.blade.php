<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="flex flex-col min-h-screen">
    <header class="bg-gray-100 flex-shrink-0">
        <div class="flex items-center px-8 py-6 container mx-auto ">
            <h1 class="text-4xl text-red-900 font-bold pr-2">
                <a href="{{ route('blog.articles.index') }}">Blog</a>
            </h1>
            @auth()
                <form method="POST" action="{{ route('logout') }}" class="ml-auto pl-2">
                    @csrf
                    <button class="block w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">Log out</button>
                </form>
            @else
                <a href="{{ route('login.view') }}" class="ml-auto flex items-center justify-center w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">Sign in</a>
                <a href="{{ route('registration.view') }}" class="ml-4 flex items-center justify-center w-32 h-8 text-white bg-red-700 border border-solid border-red-700 rounded">Sign up</a>
            @endauth
        </div>
    </header>
    <div class="container flex items-start mx-auto px-8 py-6 flex-grow">
