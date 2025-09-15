<x-layouts.app>
    <div class="min-h-screen dark:from-zinc-950 dark:to-zinc-900 py-10">
        <div class="max-w-5xl mx-auto px-6">

            <!-- Detail Pinjaman Card -->
            <div class="bg-white/70 dark:bg-zinc-900/80 backdrop-blur-md shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-zinc-700 mb-10">
                
                <h2 class="text-2xl font-bold mb-8 text-gray-900 dark:text-white tracking-wide">
                    📄 Detail Pinjaman
                </h2>

                <dl class="divide-y divide-gray-200 dark:divide-zinc-700">
                    <div class="py-4 grid grid-cols-3 gap-4">
                        <dt class="font-semibold text-gray-600 dark:text-zinc-400">Jumlah</dt>
                        <dd class="col-span-2 text-xl font-bold text-gray-900 dark:text-zinc-100">
                            Rp {{ number_format($loan->amount, 0, ',', '.') }}
                        </dd>
                    </div>

                    <div class="py-4 grid grid-cols-3 gap-4">
                        <dt class="font-semibold text-gray-600 dark:text-zinc-400">Tenor</dt>
                        <dd class="col-span-2 text-gray-900 dark:text-zinc-200">
                            {{ $loan->tenor }} bulan
                        </dd>
                    </div>

                    <div class="py-4 grid grid-cols-3 gap-4">
                        <dt class="font-semibold text-gray-600 dark:text-zinc-400">Tujuan</dt>
                        <dd class="col-span-2 text-gray-900 dark:text-zinc-200">
                            {{ $loan->purpose }}
                        </dd>
                    </div>

                    <div class="py-4 grid grid-cols-3 gap-4">
                        <dt class="font-semibold text-gray-600 dark:text-zinc-400">Bunga/Tahun</dt>
                        <dd class="col-span-2 text-gray-900 dark:text-zinc-200">
                            {{ $loan->interest_rate }}%
                        </dd>
                    </div>
                    
                    <div class="py-4 grid grid-cols-3 gap-4">
                        <dt class="font-semibold text-gray-600 dark:text-zinc-400">Status</dt>
                        <dd class="col-span-2">
                            <span @class([
                                'px-3 py-1 text-sm font-medium rounded-full',
                                'bg-yellow-200/80 text-yellow-900' => $loan->status === 'pending',
                                'bg-green-200/80 text-green-900' => $loan->status === 'approved',
                                'bg-red-200/80 text-red-900' => $loan->status === 'rejected',
                                'bg-gray-200 text-gray-800' => ! in_array($loan->status, ['pending','approved','rejected']),
                            ])>
                                {{ ucfirst($loan->status ?? 'Unknown') }}
                            </span>
                        </dd>
                    </div>

                    <div class="py-4 grid grid-cols-3 gap-4">
                        <dt class="font-semibold text-gray-600 dark:text-zinc-400">Tanggal Pengajuan</dt>
                        <dd class="col-span-2 text-gray-900 dark:text-zinc-200">
                            {{ $loan->created_at->format('d M Y H:i') }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-8">
                    <a href="{{ route('borrower.list') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium bg-gray-800 text-white rounded-full shadow hover:bg-gray-700 transition">
                        ← Kembali ke Riwayat
                    </a>
                </div>
            </div>

            <!-- History Pendanaan -->
            <div class="bg-white/70 dark:bg-zinc-900/80 backdrop-blur-md shadow-xl rounded-2xl p-6 border border-gray-200 dark:border-zinc-700">
                <h3 class="text-xl font-bold mb-6 text-gray-900 dark:text-white">📜 Riwayat Pendanaan</h3>

                @php
                    $totalCollected = $loan->offers->sum('amount');
                    
                    // Hitung biaya-biaya
                    $adminFee = $totalCollected * 0.025; // 2.5% biaya admin
                    $transferFee = 6500; // Biaya transfer tetap
                    $serviceFee = $totalCollected * 0.01; // 1% biaya layanan
                    $totalFees = $adminFee + $transferFee + $serviceFee;
                    $netAmount = $totalCollected - $totalFees;
                @endphp

                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Total Dana Terkumpul: </span>
                        <span class="text-green-600 dark:text-green-400 font-bold">
                            Rp {{ number_format($totalCollected, 0, ',', '.') }}
                        </span>
                    </div>
                    @if($loan->status != 'active')
                        <button type="button" onclick="openWithdrawModal()"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium 
                                bg-green-600 hover:bg-green-700 text-white rounded-full shadow transition-all duration-200 hover:scale-105">
                            💰 Withdraw Dana
                        </button>
                    @endif
                </div>

                @if($loan->offers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-zinc-800">
                                    <th class="px-4 py-2 rounded-tl-lg">No</th>
                                    <th class="px-4 py-2">Lender</th>
                                    <th class="px-4 py-2">Tanggal</th>
                                    <th class="px-4 py-2">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                                @foreach($loan->offers as $offer)
                                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $offer->lender_id }}</td>
                                    <td class="px-4 py-3">{{ $offer->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-3 font-semibold">Rp {{ number_format($offer->amount, 0, ',', '.') }}</td>    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">💸</div>
                        <p class="text-gray-700 dark:text-gray-300 text-lg">Belum ada penawaran untuk pinjaman ini.</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Tunggu lender memberikan penawaran terbaik!</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Withdraw Modal dengan Rincian Biaya -->
<div id="withdrawModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 animate-fade-in">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div id="modalContent" 
             class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl max-w-lg w-full transform transition-all duration-300 scale-95 opacity-0
                    max-h-[90vh] overflow-y-auto">
            
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200 dark:border-zinc-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Rincian Pencairan Dana</h3>
                    </div>
                    <button onclick="closeWithdrawModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <!-- Status Warning -->
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5C3.312 18.333 4.271 20 5.81 20z"></path>
                        </svg>
                        <div class="text-sm text-yellow-700 dark:text-yellow-300">
                            <p class="font-medium">⚠️ Dana Belum Penuh</p>
                            <p class="mt-1">Target: <strong>Rp {{ number_format($loan->amount, 0, ',', '.') }}</strong></p>
                            <p>Terkumpul: <strong>Rp {{ number_format($totalCollected, 0, ',', '.') }}</strong></p>
                            <p>Kekurangan: <strong>Rp {{ number_format($loan->amount - $totalCollected, 0, ',', '.') }}</strong></p>
                        </div>
                    </div>
                </div>

                <!-- Rincian Pencairan -->
                <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4 space-y-3">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">💰 Rincian Pencairan</h4>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total Dana Terkumpul</span>
                        <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($totalCollected, 0, ',', '.') }}</span>
                    </div>

                    <hr class="border-gray-200 dark:border-zinc-600">

                    <div class="text-gray-500 dark:text-gray-400 font-medium">Potongan Biaya:</div>

                    <div class="flex justify-between items-center pl-4">
                        <span class="text-gray-600 dark:text-gray-400">• Biaya Admin (2.5%)</span>
                        <span class="text-red-600 dark:text-red-400">- Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pl-4">
                        <span class="text-gray-600 dark:text-gray-400">• Biaya Transfer Bank</span>
                        <span class="text-red-600 dark:text-red-400">- Rp {{ number_format($transferFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pl-4">
                        <span class="text-gray-600 dark:text-gray-400">• Biaya Layanan (1%)</span>
                        <span class="text-red-600 dark:text-red-400">- Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center pl-4 pt-2 border-t border-gray-200 dark:border-zinc-600">
                        <span class="font-medium text-gray-600 dark:text-gray-400">Total Potongan</span>
                        <span class="font-semibold text-red-600 dark:text-red-400">- Rp {{ number_format($totalFees, 0, ',', '.') }}</span>
                    </div>

                    <hr class="border-gray-200 dark:border-zinc-600">

                    <div class="flex justify-between items-center bg-green-100 dark:bg-green-900/30 -m-2 p-3 rounded-lg">
                        <span class="font-bold text-green-800 dark:text-green-200">Dana yang Diterima</span>
                        <span class="font-bold text-green-800 dark:text-green-200 text-lg">Rp {{ number_format($netAmount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Info Tambahan -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-700 dark:text-blue-300">
                            <p class="font-medium mb-2">📋 Informasi Penting:</p>
                            <ul class="space-y-1 text-xs">
                                <li>• Dana akan ditransfer ke rekening terdaftar dalam 1-2 hari kerja</li>
                                <li>• Pastikan data rekening sudah benar dan aktif</li>
                                <li>• Anda akan menerima notifikasi setelah transfer berhasil</li>
                                <li>• Hubungi customer service jika ada kendala</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        Apakah Anda yakin ingin melanjutkan pencairan dana?
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Setelah dikonfirmasi, proses tidak dapat dibatalkan.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-200 dark:border-zinc-700 flex gap-3">
                <button onclick="closeWithdrawModal()" 
                    class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-zinc-800 hover:bg-gray-200 dark:hover:bg-zinc-700 rounded-lg transition-colors">
                    Batal
                </button>
                
                <form action="{{route('borrower.disbursed',$loan->id)}}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="disbursed_amount" value="{{ $netAmount }}">
                    <button type="submit" 
                        class="w-full px-4 py-2.5 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors shadow-lg hover:shadow-xl">
                        Konfirmasi Pencairan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openWithdrawModal() {
        const modal = document.getElementById('withdrawModal');
        const modalContent = document.getElementById('modalContent');
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Block background scroll
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeWithdrawModal() {
        const modal = document.getElementById('withdrawModal');
        const modalContent = document.getElementById('modalContent');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    document.getElementById('withdrawModal').addEventListener('click', function(e) {
        if (e.target === this) closeWithdrawModal();
    });

    document.getElementById('modalContent').addEventListener('click', function(e) {
        e.stopPropagation();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('withdrawModal').classList.contains('hidden')) {
            closeWithdrawModal();
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>

</x-layouts.app>