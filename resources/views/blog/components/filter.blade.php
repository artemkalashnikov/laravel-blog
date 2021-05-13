<aside class="sticky top-6 bg-gray-100 mr-4 rounded py-4 px-8 flex-shrink-0 w-82">
    <h2 class="font-bold pb-2">{{ __('blog.filter-title') }}</h2>
    <form action="{{ url()->current() }}" method="GET">
        <input class="mb-2 w-full block bg-white border border-solid border-gray-600 rounded py-0 h-8" name="title" type="text" placeholder="{{ __('blog.filter-placeholder-title') }}" @if(!empty(request()->query('title'))) value="{{ request()->query('title') }}" @endif>
        <select class="mb-2 w-full block bg-white border border-solid border-gray-600 rounded py-0 h-8" name="category">
            <option value="" selected>{{ __('blog.filter-placeholder-category') }}</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(!empty(request()->query('category')) && (request()->query('category')) == $category->id) selected @endif>
                    {{ $category->title }}
                </option>
            @endforeach
        </select>
        @if(request()->is('control-panel/*') && request()->user()->isAdmin())
            <select class="mb-4 w-full block bg-white border border-solid border-gray-600 rounded py-0 h-8" name="author">
                <option value="" selected>{{ __('blog.filter-placeholder-author') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if(!empty(request()->query('author')) && (request()->query('author')) == $user->id) selected @endif>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            <label class="flex mb-2 justify-between items-center">
                <span>{{ __('blog.filter-placeholder-not-published') }}</span>
                <input type="radio" name="published" value="0" @if(request()->exists('published') && (request()->query('published') == 0)) checked @endif>
            </label>
            <label class="flex mb-4 justify-between items-center">
                <span>{{ __('blog.filter-placeholder-published') }}</span>
                <input type="radio" name="published" value="1" @if(request()->exists('published') && (request()->query('published') == 1)) checked @endif>
            </label>
        @elseif(request()->is('control-panel/*'))
            <label class="flex mb-2 justify-between items-center">
                <span>{{ __('blog.filter-placeholder-not-published') }}</span>
                <input type="radio" name="published" value="0" @if(request()->exists('published') && (request()->query('published') == 0)) checked @endif>
            </label>
            <label class="flex mb-4 justify-between items-center">
                <span>{{ __('blog.filter-placeholder-published') }}</span>
                <input type="radio" name="published" value="1" @if(request()->exists('published') && (request()->query('published') == 1)) checked @endif>
            </label>
        @else
            <select class="mb-4 w-full block bg-white border border-solid border-gray-600 rounded py-0 h-8" name="author">
                <option value="" selected>{{ __('blog.filter-placeholder-author') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if(!empty(request()->query('author')) && (request()->query('author')) == $user->id) selected @endif>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        @endif
        <div class="flex justify-between">
            <a href="{{ url()->current() }}" class="inline-flex items-center justify-center w-20 h-8 bg-white border border-solid border-gray-600 text-gray-600 rounded" type="reset">{{ __('blog.btn-reset') }}</a>
            <button class="w-20 h-8 bg-white border border-solid border-red-700 rounded text-red-700" type="submit">{{ __('blog.btn-send') }}</button>
        </div>
    </form>
</aside>
