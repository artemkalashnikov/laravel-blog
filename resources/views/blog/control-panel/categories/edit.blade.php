@include('blog.components.header')
@include('blog.components.control-panel.sidebar')
<div class="flex-grow">
    <div class="pb-6 flex justify-between">
        <div>
            <a href="{{ route('blog.control-panel.categories.index') }}" class="flex items-center justify-center w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">{{ __('blog.btn-back') }}</a>
        </div>
        @include('blog.components.control-panel.menu')
    </div>
    <form id="data" action="{{ route('blog.control-panel.categories.update', $category->id) }}" method="POST">
        @method('PATCH')
        @csrf
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.category-form-title') }}</span>
            <input class="w-4/5 bg-white border border-solid border-gray-600 rounded py-1" name="title" type="text" placeholder="{{ __('blog.category-form-placeholder-title') }}" minlength="3" maxlength="200" required value="@if(empty(old('title'))){{ $category->title }}@else{{ old('title') }}@endif">
        </label>
        <label class="flex items-start justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.category-form-description') }}</span>
            <textarea class="w-4/5 h-40 resize-none bg-white border border-solid border-gray-600 rounded py-1" name="description" placeholder="{{ __('blog.category-form-placeholder-description') }}" maxlength="500">@if(empty(old('description'))){{ $category->description }}@else{{ old('description') }}@endif</textarea>
        </label>
    </form>
    <form id="delete" action="{{ route('blog.control-panel.categories.destroy', $category->id) }}" method="POST">
        @method('DELETE')
        @csrf
    </form>
    <div class="flex justify-end">
        <button form="delete" class="w-40 h-8 text-red-700 bg-white border border-solid border-red-700 rounded mr-8" type="submit">{{ __('blog.btn-delete') }}</button>
        <button form="data" class="w-40 h-8 text-white bg-red-700 border border-solid border-red-700 rounded" type="submit">{{ __('blog.btn-edit') }}</button>
    </div>
</div>
@include('blog.components.footer')
