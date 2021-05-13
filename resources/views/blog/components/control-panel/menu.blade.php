<div class="flex">
    <ul class="flex">
        <li>
            <a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.control-panel.articles.index') }}">{{ __('blog.menu-articles') }}</a>
        </li>
        @if(request()->user()->isAdmin())
            <li class="ml-2">
                <a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.control-panel.categories.index') }}">{{ __('blog.menu-categories') }}</a>
            </li>
        @endif
    </ul>
    <h2 class="font-bold ml-6 mr-2">{{ __('blog.menu-trash') }}</h2>
    <ul class="flex">
        <li>
            <a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.control-panel.trash.articles.index') }}">{{ __('blog.menu-articles') }}</a>
        </li>
        @if(request()->user()->isAdmin())
            <li class="ml-2">
                <a class="text-red-700 underline hover:no-underline hover:text-red-700" href="{{ route('blog.control-panel.trash.categories.index') }}">{{ __('blog.menu-categories') }}</a>
            </li>
        @endif
    </ul>
</div>
