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

            <!-- History Offer -->
            <div class="bg-white/70 dark:bg-zinc-900/80 backdrop-blur-md shadow-xl rounded-2xl p-6 border border-gray-200 dark:border-zinc-700">
                <h3 class="text-xl font-bold mb-6 text-gray-900 dark:text-white">📜 Riwayat Penawaran</h3>

                @if($loan->offers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-zinc-800">
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-300">No</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-300">Lender</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-300">Tanggal</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-300">Bunga</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-300">Total Pengembalian</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-300">Status</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-300">Komentar</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-300 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                                @foreach($loan->offers as $offer)
                                <tr>                                    
                                    <td class="px-4 py-2 text-gray-900 dark:text-zinc-200">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-zinc-200">
                                        {{ $offer->lender_id }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-zinc-200">
                                        {{ $offer->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-zinc-200">
                                        {{ number_format($offer->interest_rate, 0, ',', '.') }}%
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-zinc-200">
                                        Rp {{ number_format($offer->repayment_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span @class([
                                            'px-2 py-1 text-sm font-medium rounded-full',
                                            'bg-yellow-200/80 text-yellow-900' => $offer->status === 'pending',
                                            'bg-green-200/80 text-green-900' => $offer->status === 'accepted',
                                            'bg-red-200/80 text-red-900' => $offer->status === 'rejected',
                                            'bg-gray-200 text-gray-800' => ! in_array($offer->status, ['pending','accepted','rejected']),
                                        ])>
                                            {{ ucfirst($offer->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-zinc-200">
                                        {{ $offer->comment ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-zinc-200 flex justify-center items-center">
                                    <form action="{{ route('offers.approve', $offer->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium 
                                                bg-green-600 hover:bg-green-700 text-white rounded-full shadow transition">
                                            Approve
                                        </button>
                                    </form>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-700 dark:text-gray-300">Belum ada penawaran untuk pinjaman ini.</p>
                @endif
            </div>

        </div>
    </div>
</x-layouts.app>
