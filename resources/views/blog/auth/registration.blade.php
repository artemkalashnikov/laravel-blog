@include('blog.components.header')
<form action="{{ route('registration') }}" method="POST" class="bg-gray-100 rounded py-4 px-8 w-96 mx-auto flex-shrink-0">
    @csrf
    <label class="block">
        <span class="block mb-2">{{ __('blog.auth-form-name') }}</span>
        <input name="name" type="text" class="bg-white border border-solid border-gray-600 rounded py-0 h-8 block w-full">
    </label>
    <label class="block mt-4">
        <span class="block mb-2">{{ __('blog.auth-form-email') }}</span>
        <input name="email" type="email" class="bg-white border border-solid border-gray-600 rounded py-0 h-8 block w-full">
    </label>
    <label class="block mt-4">
        <span class="block mb-2">{{ __('blog.auth-form-password') }}</span>
        <input name="password" type="password" class="bg-white border border-solid border-gray-600 rounded py-0 h-8 block w-full">
    </label>
    <button class="mt-4 w-20 h-8 block ml-auto bg-red-700 border border-solid border-red-700 rounded text-white" type="submit">{{ __('blog.btn-send') }}</button>
</form>
@include('blog.components.footer')
