@include('blog.components.admin.header')
<div class="flex-grow">
    <div class="pb-6 flex justify-end">
        @include('blog.components.admin.menu')
    </div>
    @if($categoriesPaginator->total() === 0)
        <p class="text-center font-bold text-5xl pt-20 text-gray-200 select-none">No categories found</p>
    @else
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="px-1 py-2 w-1/4">Title</th>
                    <th class="px-1 py-2 w-2/4">Description</th>
                    <th class="px-1 py-2 w-1/4">Created at</th>
                </tr>
            </thead>
            @foreach($categoriesPaginator as $category)
                <tr>
                    <td class="px-1 py-2"><a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.admin.trash.categories.edit', $category->id) }}">{{ $category->title }}</a></td>
                    <td class="px-1 py-2">{{ $category->description }}</td>
                    <td class="px-1 py-2 text-center">{{ $category->created_at }}</td>
                </tr>
            @endforeach
        </table>
        <div class="pt-6">
            @if($categoriesPaginator->total() > $categoriesPaginator->count())
                {{ $categoriesPaginator->links() }}
            @endif
        </div>
    @endif
</div>
@include('blog.components.footer')
