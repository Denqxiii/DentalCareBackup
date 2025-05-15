<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Bill Details') }} - {{ $bill->bill_number }}
            </h2>
            <div class="space-x-3">
                @if($bill->status !== 'paid')
                    <a href="{{ route('payments.create', $bill) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Record Payment
                    </a>
                @endif
                <a href="{{ route('bills.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Bills
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Bill Information</h3>
                            <dl class="grid grid-cols-2 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Bill Number</dt>
                                <dd class="text-sm text-gray-900">{{ $bill->bill_number }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Patient</dt>
                                <dd class="text-sm text-gray-900">{{ $bill->patient->first_name }} {{ $bill->patient->last_name }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                                <dd class="text-sm text-gray-900">${{ number_format($bill->total_amount, 2) }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Paid Amount</dt>
                                <dd class="text-sm text-gray-900">${{ number_format($bill->paid_amount, 2) }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Balance</dt>
                                <dd class="text-sm text-gray-900">${{ number_format($bill->balance, 2) }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $bill->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                           ($bill->status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($bill->status) }}
                                    </span>
                                </dd>

                                <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                                <dd class="text-sm text-gray-900">{{ $bill->due_date->format('M d, Y') }}</dd>

                                @if($bill->notes)
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="text-sm text-gray-900">{{ $bill->notes }}</dd>
                                @endif
                            </dl>
                        </div>

                        @if($bill->appointment)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Appointment Information</h3>
                                <dl class="grid grid-cols-2 gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Treatment Type</dt>
                                    <dd class="text-sm text-gray-900">{{ $bill->appointment->treatment_type }}</dd>

                                    <dt class="text-sm font-medium text-gray-500">Appointment Date</dt>
                                    <dd class="text-sm text-gray-900">{{ $bill->appointment->appointment_date->format('M d, Y') }}</dd>

                                    @if($bill->appointment->message)
                                        <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                        <dd class="text-sm text-gray-900">{{ $bill->appointment->message }}</dd>
                                    @endif
                                </dl>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Payment History</h3>
                        @if($bill->payments->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Number</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference Number</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($bill->payments as $payment)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->payment_number }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($payment->amount, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($payment->payment_method) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->reference_number ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this payment?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">No payments have been recorded for this bill.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 