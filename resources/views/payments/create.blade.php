<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record Payment') }} - Bill #{{ $bill->bill_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Bill Information</h3>
                        <dl class="grid grid-cols-2 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Patient</dt>
                            <dd class="text-sm text-gray-900">{{ $bill->patient->first_name }} {{ $bill->patient->last_name }}</dd>

                            <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                            <dd class="text-sm text-gray-900">${{ number_format($bill->total_amount, 2) }}</dd>

                            <dt class="text-sm font-medium text-gray-500">Paid Amount</dt>
                            <dd class="text-sm text-gray-900">${{ number_format($bill->paid_amount, 2) }}</dd>

                            <dt class="text-sm font-medium text-gray-500">Balance</dt>
                            <dd class="text-sm text-gray-900">${{ number_format($bill->balance, 2) }}</dd>
                        </dl>
                    </div>

                    <form action="{{ route('payments.store', $bill) }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="amount" id="amount" step="0.01" min="0.01" max="{{ $bill->balance }}" value="{{ old('amount') }}" class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Maximum payment amount: ${{ number_format($bill->balance, 2) }}</p>
                        </div>

                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select a payment method</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="debit_card" {{ old('payment_method') == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="insurance" {{ old('payment_method') == 'insurance' ? 'selected' : '' }}>Insurance</option>
                            </select>
                        </div>

                        <div>
                            <label for="reference_number" class="block text-sm font-medium text-gray-700">Reference Number (Optional)</label>
                            <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">For credit/debit cards, bank transfers, or insurance payments</p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('bills.show', $bill) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 