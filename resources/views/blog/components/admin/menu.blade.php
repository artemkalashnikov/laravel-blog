<div class="flex">
    <ul class="flex">
        <li>
            <a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.admin.articles.index') }}">Articles</a>
        </li>
        <li class="ml-2">
            <a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.admin.categories.index') }}">Categories</a>
        </li>
    </ul>
    <h2 class="font-bold ml-6 mr-2">Trash:</h2>
    <ul class="flex">
        <li>
            <a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.admin.trash.articles.index') }}">Articles</a>
        </li>
        <li class="ml-2">
            <a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.admin.trash.categories.index') }}">Categories</a>
        </li>
    </ul>
</div>
