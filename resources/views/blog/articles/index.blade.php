@include('blog.components.header')
@include('blog.components.filter')
<div class="flex-grow">
    @auth()
        <div class="mb-6">
            <a href="{{ route('blog.control-panel.articles.create') }}" class="flex items-center justify-center w-40 h-8 text-white bg-red-700 border border-solid border-red-700 rounded">{{ __('blog.btn-add-article') }}</a>
        </div>
    @endauth
    @if($articlesPaginator->total() === 0)
        <p class="text-center font-bold text-5xl pt-20 text-gray-200 select-none">{{ __('blog.error-articles-not-found') }}</p>
    @else
        @foreach($articlesPaginator as $article)
            <section class="mb-6">
                <h2><a class="text-xl text-red-700 underline hover:no-underline hover:text-red-700 " href="{{ route('blog.control-panel.articles.edit', $article->id) }}">{{ $article->title }}</a></h2>
                <p class="text-lg text-gray-600 my-2">{{ $article->fragment }}</p>
                <div class="flex text-gray-400">
                    <p class="pr-6">{{ __('blog.article-item-category') }} <a class="text-gray-600 underline hover:no-underline hover:text-red-700 " href="{{ route('blog.articles.index', ['category' => $article->category->id]) }}">{{ $article->category->title }}</a></p>
                    <p>{{ __('blog.article-item-author') }} <a class="text-gray-600 underline hover:no-underline hover:text-red-700 " href="{{ route('blog.articles.index', ['author' => $article->user->id]) }}">{{ $article->user->name }}</a></p>
                    <p class="ml-auto">{{ __('blog.article-item-date') }} {{ $article->published_at }}</p>
                </div>
                <hr class="mt-4 bg-gray-400">
            </section>
        @endforeach
        <div>
            @if($articlesPaginator->total() > $articlesPaginator->count())
                {{ $articlesPaginator->links() }}
            @endif
        </div>
    @endif
</div>
@include('blog.components.footer')
