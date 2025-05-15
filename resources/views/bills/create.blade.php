@extends('layouts.app')

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center my-6 ml-0 md:ml-64">
            <a href="{{ route('bills.index') }}" class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded shadow-sm border border-gray-200 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Bills
            </a>
        </div>
        <div class="w-full max-w-lg mx-auto ml-0 md:ml-64">
            <div class="bg-gradient-to-br from-blue-50 via-white to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-3xl shadow-2xl border-t-8 border-blue-500 px-10 py-12 relative overflow-hidden">
                <div class="absolute top-4 right-4 opacity-10 text-blue-400 pointer-events-none select-none z-0">
                    <svg class="w-28 h-28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 48 48"><circle cx="24" cy="24" r="22" stroke="currentColor" stroke-width="3"/><path d="M16 32c0-4 8-4 8-8s-8-4-8-8" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                </div>
                <div class="flex flex-col items-center mb-8 relative z-10">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3 mb-3 shadow">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/></svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-1 text-center">Create New Bill</h2>
                    <div class="w-16 h-1 bg-blue-500 rounded mb-2"></div>
                    <p class="text-gray-500 dark:text-gray-300 text-base text-center">Fill in the details below to generate a new bill for a patient.</p>
                </div>
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('bills.store') }}" method="POST" class="space-y-8 relative z-10">
                    @csrf
                    <div>
                        <label for="patient_id" class="block text-lg font-bold text-gray-700 dark:text-gray-200 mb-2">Patient</label>
                        <select name="patient_id" id="patient_id" class="mt-1 block w-full rounded-xl border border-gray-300 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:bg-blue-50 transition text-base py-3" required>
                            <option value="">Select a patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->patient_id }}" {{ old('patient_id') == $patient->patient_id ? 'selected' : '' }}>
                                    {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->patient_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="appointment_id" class="block text-lg font-bold text-gray-700 dark:text-gray-200 mb-2">Appointment (Optional)</label>
                        <select name="appointment_id" id="appointment_id" class="mt-1 block w-full rounded-xl border border-gray-300 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:bg-blue-50 transition text-base py-3">
                            <option value="">Select an appointment</option>
                            @foreach($appointments as $appointment)
                                <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                    {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }} - {{ $appointment->treatment_type }} ({{ $appointment->appointment_date->format('M d, Y') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="total_amount" class="block text-lg font-bold text-gray-700 dark:text-gray-200 mb-2">Total Amount</label>
                        <div class="flex items-center mt-1 rounded-xl shadow-sm border border-gray-300 dark:bg-gray-700 dark:text-gray-200 focus-within:border-blue-500 focus-within:ring focus-within:ring-blue-200 focus-within:ring-opacity-50 bg-white dark:bg-gray-700">
                            <span class="pl-4 pr-2 text-gray-500 text-lg">₱</span>
                            <input type="number" name="total_amount" id="total_amount" step="0.01" min="0" value="{{ old('total_amount') }}" class="flex-1 py-3 pr-4 bg-transparent rounded-xl border-0 focus:ring-0 focus:bg-blue-50 dark:focus:bg-blue-900 transition text-base" required>
                        </div>
                    </div>
                    <div>
                        <label for="notes" class="block text-lg font-bold text-gray-700 dark:text-gray-200 mb-2">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-xl border border-gray-300 dark:bg-gray-700 dark:text-gray-200 shadow focus:shadow-lg focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:bg-blue-50 dark:focus:bg-blue-900 transition text-base py-3 px-4" placeholder="Optional notes..."></textarea>
                    </div>
                    <div class="mt-10">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold py-3 rounded-xl shadow-lg text-lg transition transform hover:scale-105">Create Bill</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection 