<x-layouts.app>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-900 shadow-sm sm:rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Riwayat Pinjaman</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border border-gray-200 dark:border-zinc-700">
                        <thead class="bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-zinc-300">
                            <tr>
                                <th class="px-4 py-2 border-b">Jumlah</th>
                                <th class="px-4 py-2 border-b">Tenor</th>
                                <th class="px-4 py-2 border-b">Tujuan</th>
                                <th class="px-4 py-2 border-b">Status</th>
                                <th class="px-4 py-2 border-b">Dibuat</th>
                                <th class="px-4 py-2 border-b">Diupdate</th>
                                <th class="px-4 py-2 border-b"> </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                            @forelse ($loans as $loan)
                                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800">
                                    <td class="px-4 py-2">Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $loan->tenor }} bulan</td>
                                    <td class="px-4 py-2">{{ $loan->purpose }}</td>
                                    <td class="px-4 py-2">
                                        <span @class([
                                            'px-2 py-1 text-sm font-medium rounded-full',
                                            'bg-yellow-200/80 text-yellow-900' => $loan->status === 'pending',
                                            'bg-green-200/80 text-green-900' => $loan->status === 'accepted',
                                            'bg-red-200/80 text-red-900' => $loan->status === 'rejected',
                                            'bg-gray-200 text-gray-800' => ! in_array($loan->status, ['pending','accepted','rejected']),
                                        ])>
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $loan->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2">{{ $loan->updated_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2"><a class="text-orange-600 font-medium hover:text-orange-800" href={{ route('borrower.show', $loan->id) }}>detail</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                        Belum ada pengajuan pinjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination kalau pakai paginate() --}}
                <div class="mt-4">
                    {{ $loans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
