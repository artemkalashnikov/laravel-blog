@include('blog.components.header')
@include('blog.components.admin.sidebar')
<div class="flex-grow">
    <div class="pb-6 flex justify-between">
        <div>
            <a href="{{ route('blog.admin.trash.articles.index') }}" class="flex items-center justify-center w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">Back</a>
        </div>
        @include('blog.components.admin.menu')
    </div>
    <form id="data" action="{{ route('blog.admin.trash.articles.update', $article->id) }}" method="POST">
        @method('PATCH')
        @csrf
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">Title:</span>
            <input class="w-4/5 bg-white border border-solid border-gray-600 rounded py-1" name="title" type="text" placeholder="title" minlength="3" maxlength="200" required value="@if(empty(old('title'))){{ $article->title }}@else{{ old('title') }}@endif">
        </label>
        <label class="flex items-start justify-between mb-4">
            <span class="font-bold mr-8 select-none">Content:</span>
            <textarea class="w-4/5 h-40 resize-none bg-white border border-solid border-gray-600 rounded py-1" name="content" placeholder="content" required minlength="5" maxlength="10000">@if(empty(old('content'))){{ $article->content }}@else{{ old('content') }}@endif</textarea>
        </label>
        <label class="flex items-start justify-between mb-4">
            <span class="font-bold mr-8 select-none">Fragment:</span>
            <textarea class="w-4/5 h-40 resize-none bg-white border border-solid border-gray-600 rounded py-1" name="fragment" placeholder="fragment" maxlength="500">@if(empty(old('fragment'))){{ $article->fragment }}@else{{ old('fragment') }}@endif</textarea>
        </label>
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">Category:</span>
            <select class="w-4/5 bg-white border border-solid border-gray-600 rounded py-1" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id == old('category_id') || (empty(old('category_id')) && $category->id === $article->category_id)) selected="selected" @endif>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </label>
        <input name="is_published" value="0" type="hidden">
        <div class="flex items-start justify-between mb-4">
            <label for="checkbox" class="font-bold mr-8 select-none">Published:</label>
            <span class="flex items-start w-4/5">
                <input id="checkbox" class="rounded" name="is_published" type="checkbox" value="1" @if(old('is_published') === '1' || (old('is_published') !== '0' && $article->is_published === 1)) checked="checked" @endif>
            </span>
        </div>
    </form>
    <form id="delete" action="{{ route('blog.admin.trash.articles.destroy', $article->id) }}" method="POST">
        @method('DELETE')
        @csrf
    </form>
    <div class="flex justify-end">
        <button form="delete" class="w-40 h-8 text-red-700 bg-white border border-solid border-red-700 rounded mr-8" type="submit">Delete</button>
        <button form="data" class="w-40 h-8 text-white bg-red-700 border border-solid border-red-700 rounded" type="submit">Restore*</button>
    </div>
    <p class="pt-4">* - "Restore" button submit all data that you change</p>
</div>
@include('blog.components.footer')
