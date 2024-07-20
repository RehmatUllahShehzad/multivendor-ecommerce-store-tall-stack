<div class="w-full">
    <form action="#" wire:submit.prevent="login">
        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
            Login
        </h1>
            @error('invalid-credentials')
                <div class="mb-4 text-red-800">
                    {{ $message }}
                </div>
            @enderror
        <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Email</span>
            <input wire:model.defer="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Jane Doe">
            @error('email')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">Password</span>
            <input wire:model.defer="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="***************" type="password">
            @error('password')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror
        </label>
    
        <!-- You should use a button here, as the anchor is only used for the example  -->
        <button class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            <div class="text" wire:loading.remove wire:target="login">
                Log in
            </div>
            <div class="loading" wire:loading wire:target="login">
                <i class="las la-circle-notch la-spin text-xl leading-none"></i>
            </div>
        </button>
    
        <p class="mt-4">
            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('admin.password-reset') }}">
                Forgot your password?
            </a>
        </p>
    </form>
</div>