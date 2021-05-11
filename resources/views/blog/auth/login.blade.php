@include('blog.components.header')
<form action="{{ route('login') }}" method="POST" class="bg-gray-100 rounded py-4 px-8 w-96 mx-auto flex-shrink-0">
    @csrf
    <h2 class="text-xl text-red-900 font-bold mb-4">Sign in:</h2>
    <label class="block">
        <span class="block mb-2">Email:</span>
        <input name="email" type="email" class="bg-white border border-solid border-gray-600 rounded py-0 h-8 block w-full" required value="{{ old('email') }}">
    </label>
    <label class="block my-4">
        <span class="block mb-2">Password:</span>
        <input name="password" type="password" class="bg-white border border-solid border-gray-600 rounded py-0 h-8 block w-full" required>
    </label>
    <button class="w-20 h-8 block ml-auto bg-red-700 border border-solid border-red-700 rounded text-white" type="submit">Send</button>
</form>
@include('blog.components.footer')
