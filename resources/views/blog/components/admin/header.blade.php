<!Doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin panel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="flex flex-col min-h-screen">
    <header class="bg-gray-100 flex-shrink-0">
        <div class="flex items-center px-8 py-6 container mx-auto ">
            <h1 class="text-4xl text-red-900 font-bold pr-2">Laravel blog admin panel</h1>
            <form method="POST" action="" class="ml-auto pl-2">
                <button class="block w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">Log out</button>
            </form>
        </div>
    </header>
    <div class="container flex items-start mx-auto px-8 py-6 flex-grow">
