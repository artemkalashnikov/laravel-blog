@include('blog.components.admin.header')
@include('blog.components.admin.filter')
<div class="flex-grow">
    <div class="pb-6 flex justify-between">
        <div>
            <a href="{{ route('blog.admin.articles.create') }}" class="flex items-center justify-center w-40 h-8 text-white bg-red-700 border border-solid border-red-700 rounded">Add new article</a>
        </div>
        @include('blog.components.admin.menu')
    </div>
    @if($articlesPaginator->total() === 0)
        <p class="text-center font-bold text-5xl pt-20 text-gray-200 select-none">No articles found</p>
    @else
        <table class="table-fixed w-full">
            <thead>
            <tr>
                <th class="px-1 py-2 w-2/6">Title</th>
                <th class="px-1 py-2 w-1/6">Category</th>
                <th class="px-1 py-2 w-1/6">Author</th>
                <th class="px-1 py-2 w-1/6">Created at</th>
                <th class="px-1 py-2 w-1/6">Published at</th>
            </tr>
            </thead>
            @foreach($articlesPaginator as $article)
                <tr @if(!$article->is_published) class="bg-red-50" @endif>
                    <td class="px-1 py-2"><a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.admin.articles.edit', $article->id) }}">{{ $article->title }}</a></td>
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
