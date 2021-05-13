@include('blog.components.header')
@include('blog.components.filter')
<div class="flex-grow">
    <div class="pb-6 flex justify-end">
        @include('blog.components.control-panel.menu')
    </div>
    @if($articlesPaginator->total() === 0)
        <p class="text-center font-bold text-5xl pt-20 text-gray-200 select-none">{{ __('blog.error-articles-not-found') }}</p>
    @else
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="px-1 py-2 w-2/6">{{ __('blog.control-panel-table-title') }}</th>
                    <th class="px-1 py-2 w-1/6">{{ __('blog.control-panel-table-category') }}</th>
                    <th class="px-1 py-2 w-1/6">{{ __('blog.control-panel-table-author') }}</th>
                    <th class="px-1 py-2 w-1/6">{{ __('blog.control-panel-table-created-at') }}</th>
                    <th class="px-1 py-2 w-1/6">{{ __('blog.control-panel-table-published-at') }}</th>
                </tr>
            </thead>
            @foreach($articlesPaginator as $article)
                <tr @if(!$article->is_published) class="bg-red-50" @endif>
                    <td class="px-1 py-2"><a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.control-panel.trash.articles.edit', $article->id) }}">{{ $article->title }}</a></td>
                    <td class="px-1 py-2 text-center">{{ $article->category->title }}</td>
                    <td class="px-1 py-2 text-center">{{ $article->user->name }}</td>
                    <td class="px-1 py-2 text-center">{{ $article->created_at }}</td>
                    <td class="px-1 py-2 text-center">{{ $article->published_at }}</td>
                </tr>
            @endforeach
        </table>
        <div class="pt-6">
            @if($articlesPaginator->total() > $articlesPaginator->count())
                {{ $articlesPaginator->links() }}
            @endif
        </div>
    @endif
</div>
@include('blog.components.footer')
