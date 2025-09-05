<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Current Loan Balance -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-gradient-to-br from-red-500 to-pink-600 p-6 text-white">
                <div class="flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <span class="text-sm font-medium opacity-90">Outstanding Loan</span>
                        </div>
                        <div class="text-3xl font-bold mb-1">$8,750.00</div>
                        <div class="text-sm opacity-75">Next payment: $425.50</div>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">18 months left</span>
                    </div>
                </div>
            </div>

            <!-- Credit Score -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white">
                <div class="flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="text-sm font-medium opacity-90">Credit Score</span>
                        </div>
                        <div class="text-3xl font-bold mb-1">650</div>
                        <div class="text-sm opacity-75">Good Credit</div>
                    </div>
                    <div class="flex items-center text-sm">
                        <div class="bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs">
                            Improving (+15)
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Status -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-white">
                <div class="flex flex-col justify-between h-full">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium opacity-90">Account Status</span>
                        </div>
                        <div class="text-2xl font-bold mb-1">Verified</div>
                        <div class="text-sm opacity-75">KTP, Payslip approved</div>
                    </div>
                    <div class="flex items-center text-sm">
                        <div class="bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Complete
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-gray-800">
            <div class="p-6 h-full">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Loan Activity</h2>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Apply for New Loan</button>
                </div>
                
                <!-- Recent Transactions -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">Payment Due</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Monthly installment</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-red-600 dark:text-red-400">$425.50</div>
                            <div class="text-sm text-red-500">Due in 3 days</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">Payment Received</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Monthly installment</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-green-600 dark:text-green-400">$425.50</div>
                            <div class="text-sm text-green-500">Last month</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">Loan Disbursed</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Personal Loan</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-blue-600 dark:text-blue-400">$10,000.00</div>
                            <div class="text-sm text-blue-500">6 months ago</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">Application Approved</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Personal Loan</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-yellow-600 dark:text-yellow-400">$10,000.00</div>
                            <div class="text-sm text-yellow-500">6 months ago</div>
                        </div>
                    </div>
                </div>

                <!-- Loan Stats -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Paid</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">$2,553.00</div>
                        <div class="text-sm text-green-500">6 payments made</div>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Interest Rate</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">12.5%</div>
                        <div class="text-sm text-blue-500">Annual rate</div>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Available Credit</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">$5,000</div>
                        <div class="text-sm text-green-500">Pre-approved</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>