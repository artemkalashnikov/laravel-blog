@if (session('status'))
    <div class="fixed select-none rounded w-96 px-8 py-4 bottom-4 right-4 bg-green-600 text-white transition-opacity duration-300 delay-10s opacity-0">
        {{ session('status') }}
    </div>
@endif
