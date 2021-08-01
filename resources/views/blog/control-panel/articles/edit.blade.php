@include('blog.components.header')
@include('blog.components.control-panel.sidebar')
<div class="flex-grow">
    <div class="pb-6 flex justify-between">
        <div>
            <a href="{{ route('blog.control-panel.articles.index') }}" class="flex items-center justify-center w-32 h-8 text-gray-600 bg-white border border-solid border-gray-600 rounded">{{ __('blog.btn-back') }}</a>
        </div>
        @include('blog.components.control-panel.menu')
    </div>
    <form id="data" action="{{ route('blog.control-panel.articles.update', $current_article->id) }}" method="POST">
        @method('PATCH')
        @csrf
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-title') }}</span>
            <input class="w-4/5 bg-white border border-solid border-gray-600 rounded py-1 px-2" name="title" type="text" placeholder="{{ __('blog.article-form-placeholder-title') }}" minlength="3" maxlength="200" required value="@if(empty(old('title'))){{ $current_article->title }}@else{{ old('title') }}@endif">
        </label>
        <label class="flex items-start justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-content') }}</span>
            <textarea class="w-4/5 h-40 resize-none bg-white border border-solid border-gray-600 rounded py-1 px-2" name="content" placeholder="{{ __('blog.article-form-placeholder-content') }}" required minlength="5" maxlength="10000">@if(empty(old('content'))){{ $current_article->content }}@else{{ old('content') }}@endif</textarea>
        </label>
        <label class="flex items-start justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-fragment') }}</span>
            <textarea class="w-4/5 h-40 resize-none bg-white border border-solid border-gray-600 rounded py-1 px-2" name="fragment" placeholder="{{ __('blog.article-form-placeholder-fragment') }}" maxlength="500">@if(empty(old('fragment'))){{ $current_article->fragment }}@else{{ old('fragment') }}@endif</textarea>
        </label>
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-category') }}</span>
            <select class="w-4/5 bg-white border border-solid border-gray-600 rounded py-1 px-2" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id == old('category_id') || (empty(old('category_id')) && $category->id === $current_article->category_id)) selected="selected" @endif>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </label>
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-parent-articles') }}</span>
            <div class="w-4/5">
                <select class="w-full bg-white border border-solid border-gray-600 rounded py-1 px-2" name="parent_ids[]" multiple="multiple" size="10">
                @foreach($articles as $article)
                    @if($current_article->id !== $article->id)
                        <option value="{{ $article->id }}" @if($current_article->parent_articles->contains($article)) selected="selected" @endif>
                            {{ $article->title }}
                        </option>
                    @endif
                @endforeach
                </select>
                <p class="pt-4">{{ __('blog.article-form-relations-description') }}</p>
            </div>
        </label>
        <label class="flex items-center justify-between mb-4">
            <span class="font-bold mr-8 select-none">{{ __('blog.article-form-child-articles') }}</span>
            <div class="w-4/5">
                <select class="w-full bg-white border border-solid border-gray-600 rounded py-1 px-2" name="child_ids[]" multiple="multiple" size="10">
                    @foreach($articles as $article)
                        @if($current_article->id !== $article->id)
                            <option value="{{ $article->id }}" @if($current_article->child_articles->contains($article)) selected="selected" @endif>
                                {{ $article->title }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <p class="pt-4">{{ __('blog.article-form-relations-description') }}</p>
            </div>
        </label>
        <div class="flex items-center justify-between mb-4">
            <label for="checkbox" class="font-bold mr-8 select-none">{{ __('blog.article-form-published') }}</label>
            <span class="flex items-start w-4/5">
                <input name="is_published" value="0" type="hidden">
                <input id="checkbox" class="rounded w-4 h-4" name="is_published" type="checkbox" value="1" @if(old('is_published') === '1' || (old('is_published') !== '0' && $current_article->is_published === 1)) checked="checked" @endif>
            </span>
        </div>
    </form>
    <form id="delete" action="{{ route('blog.control-panel.articles.destroy', $current_article->id) }}" method="POST">
        @method('DELETE')
        @csrf
    </form>
    <div class="flex justify-end">
        <button form="delete" class="w-40 h-8 text-red-700 bg-white border border-solid border-red-700 rounded mr-8" type="submit">{{ __('blog.btn-delete') }}</button>
        <button form="data" class="w-40 h-8 text-white bg-red-700 border border-solid border-red-700 rounded" type="submit">{{ __('blog.btn-edit') }}</button>
    </div>
</div>
@include('blog.components.footer')
