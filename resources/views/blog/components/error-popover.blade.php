@if(!empty($errors->all()))
    @foreach ($errors->all() as $error)
        <div class="fixed select-none rounded w-96 px-8 py-4 bottom-4 right-4 bg-red-400 text-gray-700 transition-opacity duration-300 delay-10s opacity-0">
            {{ $error }}
        </div>
    @endforeach
@endif
