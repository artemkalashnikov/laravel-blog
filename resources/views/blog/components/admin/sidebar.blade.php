<aside class="bg-gray-100 mr-4 rounded py-4 px-8 w-82 flex-shrink-0">
    @isset($article)
        <p class="font-bold">Author name: <span class="font-normal">{{ $article->user->name }}</span></p>
        <p class="pt-2 font-bold">Created at: <span class="font-normal">{{ $article->created_at }}</span></p>
        <p class="pt-2 font-bold">Updated at: <span class="font-normal">{{ $article->updated_at }}</span></p>
        @isset($article->published_at)
            <p class="pt-2 font-bold">Published at: <span class="font-normal">{{ $article->published_at }}</span></p>
        @endisset
        @isset($article->deleted_at)
            <p class="pt-2 font-bold">Deleted at: <span class="font-normal">{{ $article->deleted_at }}</span></p>
        @endisset
    @endisset
    @isset($category)
        <p class="font-bold">Created at: <span class="font-normal">{{ $category->created_at }}</span></p>
        @isset($category->updated_at)
            <p class="pt-2 font-bold">Updated at: <span class="font-normal">{{ $category->updated_at }}</span></p>
        @endisset
        @isset($category->deleted_at)
            <p class="pt-2 font-bold">Deleted at: <span class="font-normal">{{ $category->deleted_at }}</span></p>
        @endisset
    @endisset
</aside>
