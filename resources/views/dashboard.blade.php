<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col gap-6 p-6">

        <!-- Main Card: Outstanding Loan + Account Status -->
        <div class="grid gap-4 md:grid-cols-1 lg:grid-cols-2">

            <!-- Outstanding Loan -->
            <div class="p-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-red-50 dark:bg-red-900/20 flex flex-col justify-between">
                <div>
                    <div class="text-lg font-medium text-red-600 mb-2">Outstanding Loan</div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1">$8,750.00</div>
                    <div class="text-md text-gray-700 dark:text-gray-300">Next payment: $425.50</div>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">18 months left</div>
                </div>
            </div>

            <!-- Account Status + Actions -->
            <div class="p-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-green-50 dark:bg-green-900/20 flex flex-col justify-between">
                <div>
                    <div class="text-lg font-medium text-green-600 mb-2">Account Status</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        {{ auth()->user()->status === 'verified' ? 'Verified' : 'Unverified' }}
                    </div>
                    <div class="text-md text-gray-700 dark:text-gray-300 mb-4">
                        {{ auth()->user()->status === 'verified' ? 'KTP, Payslip approved' : 'Complete verification to unlock features' }}
                    </div>
                    <div class="flex gap-3 flex-wrap">
                        @if(auth()->user()->status !== 'verified')
                            <a href={{ route('borrower.verification',auth()->user()->id) }} class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium">Verify Now</a>
                        @endif

                        @if(auth()->user()->role !== 'lender')
                            <a href={{ route('lender.create',auth()->user()->id) }} class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded text-sm font-medium">Become Lender</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Activity -->
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Loan Activity</h2>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium">Apply for New Loan</button>
            </div>

            <!-- Example Transactions -->
            <div class="space-y-3">
                @foreach([
                    ['title'=>'Payment Due','desc'=>'Monthly installment','amount'=>'$425.50','color'=>'red','time'=>'Due in 3 days'],
                    ['title'=>'Payment Received','desc'=>'Monthly installment','amount'=>'$425.50','color'=>'green','time'=>'Last month'],
                ] as $tx)
                    <div class="flex justify-between p-3 rounded-lg border border-{{ $tx['color'] }}-200 dark:border-{{ $tx['color'] }}-800 bg-{{ $tx['color'] }}-50 dark:bg-{{ $tx['color'] }}-900/20">
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $tx['title'] }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $tx['desc'] }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-{{ $tx['color'] }}-600 dark:text-{{ $tx['color'] }}-400">{{ $tx['amount'] }}</div>
                            <div class="text-sm text-{{ $tx['color'] }}-500">{{ $tx['time'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
