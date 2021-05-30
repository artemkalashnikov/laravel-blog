@include('blog.components.header')
<div class="flex-grow">
    <div class="pb-6 flex">
        <a href="{{ route('blog.articles.index') }}" class="flex items-center justify-center w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">{{ __('blog.btn-back') }}</a>
        @can('update', $article)
            <a href="{{ route('blog.control-panel.articles.edit', $article->id) }}" class="ml-4 flex items-center justify-center w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">{{ __('blog.btn-edit') }}</a>
        @endcan
    </div>
    <article class="text-lg text-gray-600 leading-7">
        {{ $article->content }}
    </article>
    <div class="flex text-gray-400 mt-6">
        <p class="pr-6">{{ __('blog.article-item-category') }} <a class="text-gray-600 underline hover:no-underline hover:text-red-700 " href="{{ route('blog.articles.index', ['category' => $article->category->id]) }}">{{ $article->category->title }}</a></p>
        <p>{{ __('blog.article-item-author') }} <a class="text-gray-600 underline hover:no-underline hover:text-red-700 " href="{{ route('blog.articles.index', ['author' => $article->user->id]) }}">{{ $article->user->name }}</a></p>
        <p class="ml-auto">{{ __('blog.article-item-date') }} {{ $article->published_at }}</p>
    </div>
</div>
@include('blog.components.footer')
