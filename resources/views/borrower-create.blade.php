<x-layouts.app :title="__('Apply for Loan')">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Formulir Peminjaman</h1>
            <p class="text-gray-600 dark:text-gray-400">Isi semua formulir untuk melakukan peminjaman!</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-8">
            <form action="{{ route('borrower.store') }}" method="POST">
                @csrf
                
                <!-- Loan Amount -->
                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Jumlah Uang <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-lg">Rp</span>
                        </div>
                        <input 
                            type="number" 
                            name="amount" 
                            id="amount" 
                            min="100000" 
                            step="100"
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white @error('amount') border-red-500 @enderror" 
                            placeholder="100,000"
                            value="{{ old('amount') }}"
                            required
                        >
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Minimum Rp100.000</p>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tenor -->
                <div class="mb-6">
                    <label for="tenor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Loan Term (Months) <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="tenor" 
                        id="tenor" 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white @error('tenor') border-red-500 @enderror"
                        required
                    >
                        <option value="">Select loan term</option>
                        <option value="6" {{ old('tenor') == 6 ? 'selected' : '' }}>6 Months</option>
                        <option value="12" {{ old('tenor') == 12 ? 'selected' : '' }}>12 Months</option>
                        <option value="18" {{ old('tenor') == 18 ? 'selected' : '' }}>18 Months</option>
                        <option value="24" {{ old('tenor') == 24 ? 'selected' : '' }}>24 Months</option>
                        <option value="36" {{ old('tenor') == 36 ? 'selected' : '' }}>36 Months</option>
                    </select>
                    @error('tenor')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purpose -->
                <div class="mb-8">
                    <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Loan Purpose <span class="text-red-500">*</span>
                    </label>
                    <textarea name="purpose" id="" cols="30" rows="10" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white @error('amount') border-red-500 @enderror" required style="resize:none"></textarea>
                    @error('purpose')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4">
                    <button 
                        type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Submit Application
                    </button>
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    <script>
        // Calculate monthly payment
        function calculatePayment() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const tenor = parseInt(document.getElementById('tenor').value) || 0;
            const interestRate = 0.125 / 12; // 12.5% annual rate converted to monthly
            
            let monthlyPayment = 0;
            if (amount > 0 && tenor > 0) {
                // Formula: PMT = P * [r(1+r)^n] / [(1+r)^n - 1]
                const numerator = amount * interestRate * Math.pow(1 + interestRate, tenor);
                const denominator = Math.pow(1 + interestRate, tenor) - 1;
                monthlyPayment = numerator / denominator;
            }
            
            // Update summary
            document.getElementById('summary-amount').textContent = '$' + amount.toLocaleString();
            document.getElementById('summary-tenor').textContent = tenor + ' months';
            document.getElementById('summary-payment').textContent = '$' + monthlyPayment.toFixed(2);
        }
        
        // Add event listeners
        document.getElementById('amount').addEventListener('input', calculatePayment);
        document.getElementById('tenor').addEventListener('change', calculatePayment);
        
        // Initial calculation
        calculatePayment();
    </script>
</x-layouts.app>