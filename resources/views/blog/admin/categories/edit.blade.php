@include('blog.components.admin.header')
@include('blog.components.admin.sidebar')
<div class="flex-grow">
    <div class="pb-6 flex justify-between">
        <div>
            <a href="{{ route('blog.admin.categories.index') }}" class="flex items-center justify-center w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">Back</a>
        </div>
        @include('blog.components.admin.menu')
    </div>
    <form id="data" action="{{ route('blog.admin.categories.update', $category->id) }}" method="POST">
        @method('PATCH')
        @csrf
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">Title:</span>
            <input class="w-4/5 bg-white border border-solid border-gray-600 rounded py-1" name="title" type="text" placeholder="title" minlength="3" maxlength="200" required value="@if(empty(old('title'))){{ $category->title }}@else{{ old('title') }}@endif">
        </label>
        <label class="flex items-start justify-between mb-4">
            <span class="font-bold mr-8 select-none">Description:</span>
            <textarea class="w-4/5 h-40 resize-none bg-white border border-solid border-gray-600 rounded py-1" name="description" placeholder="content" maxlength="500">@if(empty(old('description'))){{ $category->description }}@else{{ old('description') }}@endif</textarea>
        </label>
    </form>
    <form id="delete" action="{{ route('blog.admin.categories.destroy', $category->id) }}" method="POST">
        @method('DELETE')
        @csrf
    </form>
    <div class="flex justify-end">
        <button form="delete" class="w-40 h-8 text-red-700 bg-white border border-solid border-red-700 rounded mr-8" type="submit">Delete</button>
        <button form="data" class="w-40 h-8 text-white bg-red-700 border border-solid border-red-700 rounded" type="submit">Send</button>
    </div>
</div>
@include('blog.components.footer')
