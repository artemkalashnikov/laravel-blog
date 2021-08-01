@include('blog.components.header')
<div class="flex-grow">
    <div class="pb-6 flex justify-between">
        <div>
            <a href="{{ route('blog.control-panel.articles.index') }}" class="flex items-center justify-center w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">{{ __('blog.btn-back') }}</a>
        </div>
        @include('blog.components.control-panel.menu')
    </div>
    <form id="data" action="{{ route('blog.control-panel.articles.store') }}" method="POST">
        @csrf
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-title') }}</span>
            <input class="w-4/5 bg-white border border-solid border-gray-600 rounded py-1" name="title" type="text" placeholder="{{ __('blog.article-form-placeholder-title') }}" minlength="3" maxlength="200" required value="{{ old('title') }}">
        </label>
        <label class="flex items-start justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-content') }}</span>
            <textarea class="w-4/5 h-40 resize-none bg-white border border-solid border-gray-600 rounded py-1" name="content" placeholder="{{ __('blog.article-form-placeholder-content') }}" required minlength="5" maxlength="10000">{{ old('content') }}</textarea>
        </label>
        <label class="flex items-start justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-fragment') }}</span>
            <textarea class="w-4/5 h-40 resize-none bg-white border border-solid border-gray-600 rounded py-1" name="fragment" placeholder="{{ __('blog.article-form-placeholder-fragment') }}" maxlength="500">{{ old('fragment') }}</textarea>
        </label>
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-category') }}</span>
            <select class="w-4/5 bg-white border border-solid border-gray-600 rounded py-1" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id == old('category_id')) selected="selected" @endif>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </label>
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-parent-articles') }}</span>
            <div class="w-4/5 py-1">
                <select class="w-full bg-white border border-solid border-gray-600 rounded" name="parent_ids[]" multiple="multiple" size="10">
                    @foreach($all_articles as $article)
                        <option value="{{ $article->id }}">
                            {{ $article->title }}
                        </option>
                    @endforeach
                </select>
                <p class="pt-4">{{ __('blog.article-form-relations-description') }}</p>
            </div>
        </label>
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-child-articles') }}</span>
            <div class="w-4/5 py-1">
                <select class="w-full bg-white border border-solid border-gray-600 rounded" name="child_ids[]" multiple="multiple" size="10">
                    @foreach($all_articles as $article)
                        <option value="{{ $article->id }}">
                            {{ $article->title }}
                        </option>
                    @endforeach
                </select>
                <p class="pt-4">{{ __('blog.article-form-relations-description') }}</p>
            </div>
        </label>
        <input name="is_published" value="0" type="hidden">
        <div class="flex items-start justify-between mb-4">
            <label for="checkbox" class="font-bold mr-8 select-none">{{ __('blog.article-form-published') }}</label>
            <span class="flex items-start w-4/5">
                <input id="checkbox" class="rounded" name="is_published" type="checkbox" value="1" @if(old('is_published') === '1') checked @endif>
            </span>
        </div>
    </form>
    <div class="flex justify-end">
        <button form="data" class="w-40 h-8 text-white bg-red-700 border border-solid border-red-700 rounded" type="submit">{{ __('blog.btn-create') }}</button>
    </div>
</div>
@include('blog.components.footer')
