<x-layouts.app :title="'Account Verification'">
    <div class="max-w-md mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-8">
        <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Account Verification</h2>

        @if (session()->has('message'))
            <div class="bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200 p-3 mb-4 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('lender.store') }}" method="POST" class="flex flex-col gap-5">
            @csrf

            {{-- User ID --}}
            <input type="hidden" name="user_id" value="{{ $user_id }}">

            <!-- company -->
            <div class="flex flex-col">
                <label class="font-medium mb-1 text-gray-700 dark:text-gray-200">Company</label>
                <input type="text" name="company" class="border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-gray-50 dark:bg-gray-700" placeholder="Masukkan company">
                @error('company') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition-colors">
                Submit Verification
            </button>
        </form>
    </div>
</x-layouts.app>
