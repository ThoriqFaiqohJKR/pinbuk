<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 mx-auto mt-10">
    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Login</h2>

    <form wire:submit.prevent="login" class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
            <input
                type="email"
                id="email"
                wire:model="email"
                required
                placeholder="you@example.com"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
                type="password"
                id="password"
                wire:model="password"
                required
                placeholder="Enter your password"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            />
        </div>

        @if($error)
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded-md">
                {{ $error }}
            </div>
        @endif

        <button
            type="submit"
            class="w-full bg-indigo-600 text-white py-3 rounded-md text-lg font-semibold hover:bg-indigo-700 transition-colors"
        >
            Login
        </button>
    </form>
</div>


</div>
