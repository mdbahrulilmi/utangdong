<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col gap-6 p-6">

        <!-- 4 Cards: Loan Info, Limit, Credit Score, Status -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-2">

            <!-- Outstanding Loan -->
            <div class="p-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-red-50 dark:bg-red-900/20 flex flex-col justify-between">
                <div>
                    <div class="text-lg font-medium text-red-600 mb-2">Utang Bulan Ini</div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1">
                        Rp{{ number_format($totalActiveAmount/$tenor ?? 0) }}
                    </div>
                    <div class="text-md text-gray-700 dark:text-gray-300">Sisa utang: Rp{{ number_format($totalActiveAmount ?? 0) }}</div>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $tenor }} Bulan Sisa Tenor</div>
                </div>
            </div>

            <!-- Max Loan Limit -->
            <div class="p-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 flex flex-col justify-between">
                <div>
                    <div class="text-lg font-medium text-blue-600 mb-2">Limit Maksimal Peminjaman</div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1">
                        Rp{{ number_format($maxLimit ?? 0,0,',','.') }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Sesuai peringkat kamu</div>
                </div>
            </div>

            <!-- Credit Score -->
            <div class="p-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-yellow-50 dark:bg-yellow-900/20 flex flex-col justify-between">
                <div>
                    <div class="text-lg font-medium text-yellow-600 mb-2">Skor Kredit</div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1">
                        {{ auth()->user()->borrower->credit_score ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Skor kredit kamu</div>
                </div>
            </div>

            <!-- Account Status -->
            <div class="p-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-green-50 dark:bg-green-900/20 flex flex-col justify-between">
                <div>
                    <div class="text-lg font-medium text-green-600 mb-2">Status Akunmu</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        {{ auth()->user()->status === 'verified' ? 'Terverifikasi' : (auth()->user()->status === 'requested' ? 'Lagi diajukan' : 'Belum Terverifikasi') }}

                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        {{ auth()->user()->status === 'verified' ? 'KTP, Payslip disetujui' : 'Selesaikan verifikasi untuk membuka fitur' }}
                    </div>

                    <!-- Tombol aksi -->
                    <div class="flex gap-3 flex-wrap">
                        @if(auth()->user()->status == 'unverified' || auth()->user()->status == 'rejected')
                            <a href="{{ route('borrower.verification', auth()->user()->id) }}" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium">
                            Verify Now
                            </a>
                        @endif

                        @if(auth()->user()->role !== 'lender')
                            <a href="{{ route('lender.create', auth()->user()->id) }}" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded text-sm font-medium">
                            Become Lender
                            </a>
                        @endif
                    </div>
                </div>
            </div>


        </div>

        {{-- <!-- Loan Activity -->
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Loan Activity</h2>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium">Apply for New Loan</button>
            </div>
        </div> --}}
    </div>
</x-layouts.app>
