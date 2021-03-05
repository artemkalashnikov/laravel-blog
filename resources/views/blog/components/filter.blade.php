<aside class="sticky top-6 bg-gray-100 mr-2 rounded py-4 px-8 flex-shrink-0 w-82">
    <h2 class="font-bold pb-2">Filter:</h2>
    <form action="{{ url()->current() }}" method="GET">
        <input class="mb-2 w-full block bg-white border border-solid border-gray-600 rounded py-0 h-8" name="title" type="text" placeholder="Title" @if(!empty(request()->query('title'))) value="{{ request()->query('title') }}" @endif>
        <select class="mb-2 w-full block bg-white border border-solid border-gray-600 rounded py-0 h-8" name="category">
            <option value="" selected>Category name</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(!empty(request()->query('category')) && (request()->query('category')) == $category->id) selected @endif>
                    {{ $category->title }}
                </option>
            @endforeach
        </select>
        <select class="mb-4 w-full block bg-white border border-solid border-gray-600 rounded py-0 h-8" name="author">
            <option value="" selected>Author name</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @if(!empty(request()->query('author')) && (request()->query('author')) == $user->id) selected @endif>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        <div class="flex justify-between">
            <a href="{{ url()->current() }}" class="inline-flex items-center justify-center w-20 h-8 bg-white border border-solid border-gray-600 text-gray-600 rounded" type="reset">Reset</a>
            <button class="w-20 h-8 bg-white border border-solid border-red-700 rounded text-red-700" type="submit">Send</button>
        </div>
    </form>
</aside>
