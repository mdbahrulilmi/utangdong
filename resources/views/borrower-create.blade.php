<x-layouts.app :title="__('Apply for Loan')">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Formulir Peminjaman</h1>
            <p class="text-gray-600 dark:text-gray-400">Isi semua formulir untuk melakukan peminjaman!</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-8">

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('borrower.store') }}" method="POST">
                @csrf

                @php
                    $maxAmount = $gradeSetting->max_loan_amount ?? 1000000;
                    $maxTenor = $gradeSetting->max_tenor_months ?? 12;
                    $interestRate = $gradeSetting->interest_rate ?? 0;
                @endphp

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
                            max="{{ $maxAmount }}" 
                            step="100"
                            value="{{ old('amount') }}"
                            required
                            class="w-full pl-8 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white @error('amount') border-red-500 @enderror"
                        >
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Minimum 100.000, Maksimum {{ number_format($maxAmount,0,',','.') }}
                    </p>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tenor -->
                <div class="mb-6">
                    <label for="tenor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Loan Term (Months) <span class="text-red-500">*</span>
                    </label>
                    <select name="tenor" id="tenor" required
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white @error('tenor') border-red-500 @enderror">
                        @for($i = 1; $i <= $maxTenor; $i++)
                            <option value="{{ $i }}" {{ old('tenor') == $i ? 'selected' : '' }}>
                                {{ $i }} Month{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Maksimal tenor: {{ $maxTenor }} bulan
                    </p>
                    @error('tenor')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Loan Purpose -->
                <div class="mb-8">
                    <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Loan Purpose <span class="text-red-500">*</span>
                    </label>
                    <textarea name="purpose" cols="30" rows="4" 
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white @error('purpose') border-red-500 @enderror"
                        required
                        style="resize:none">{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Monthly Payment Summary -->
                <div class="mb-6">
                    <p>Estimated Monthly Payment: <span id="summary-payment">Rp0</span></p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg flex items-center justify-center gap-2">
                        Submit Application
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculatePayment() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const tenor = parseInt(document.getElementById('tenor').value) || 0;
            const interestRate = {{ $interestRate }} / 100 / 12;

            let monthlyPayment = 0;
            if(amount > 0 && tenor > 0) {
                const numerator = amount * interestRate * Math.pow(1 + interestRate, tenor);
                const denominator = Math.pow(1 + interestRate, tenor) - 1;
                monthlyPayment = denominator > 0 ? numerator / denominator : amount;
            }

            document.getElementById('summary-payment').textContent = 'Rp' + monthlyPayment.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0});
        }

        document.getElementById('amount').addEventListener('input', calculatePayment);
        document.getElementById('tenor').addEventListener('change', calculatePayment);

        calculatePayment();
    </script>
</x-layouts.app>
