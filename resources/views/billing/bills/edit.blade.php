@extends('layouts.app')

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center my-6 ml-0 md:ml-64">
            <a href="{{ route('billing.invoices.show', $bill->id) }}" class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded shadow-sm border border-gray-200 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Bill Details
            </a>
        </div>
        <div class="w-full max-w-lg mx-auto ml-0 md:ml-64">
            <div class="bg-gradient-to-br from-blue-50 via-white to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-3xl shadow-2xl border-t-8 border-blue-500 px-10 py-12 relative overflow-hidden">
                <div class="absolute top-4 right-4 opacity-10 text-blue-400 pointer-events-none select-none z-0">
                    <svg class="w-28 h-28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 48 48"><circle cx="24" cy="24" r="22" stroke="currentColor" stroke-width="3"/><path d="M16 32c0-4 8-4 8-8s-8-4-8-8" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                </div>
                <div class="flex flex-col items-center mb-8 relative z-10">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3 mb-3 shadow">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-1 text-center">Edit Bill</h2>
                    <div class="w-16 h-1 bg-blue-500 rounded mb-2"></div>
                    <p class="text-gray-500 dark:text-gray-300 text-base text-center">Update the bill details below.</p>
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
                <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mt-10" style="padding: 25px;">
                    <form action="{{ route('billing.invoices.update', $bill->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Patient --}}
                        <div>
                            <label for="patient_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Patient</label>
                            <select name="patient_id" id="patient_id" required
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select a patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id', $bill->patient_id) == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Appointment --}}
                        <div>
                            <label for="appointment_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Appointment (Optional)</label>
                            <select name="appointment_id" id="appointment_id"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select an appointment</option>
                                @foreach($appointments as $appointment)
                                    <option value="{{ $appointment->id }}" {{ old('appointment_id', $bill->appointment_id) == $appointment->id ? 'selected' : '' }}>
                                        {{ $appointment->treatment_type }} ({{ $appointment->appointment_date }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Total Amount --}}
                        <div>
                            <label for="total_amount" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Total Amount
                            </label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-gray-500 dark:text-gray-400 text-base pointer-events-none">
                                    ₱
                                </span>
                                <input 
                                    type="number" 
                                    name="total_amount" 
                                    id="total_amount" 
                                    step="0.01" 
                                    min="0"
                                    value="{{ old('total_amount', $bill->total_amount) }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base transition"
                                    required
                                >
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Status
                            </label>
                            <select name="status" id="status" required
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="pending" {{ old('status', $bill->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('status', $bill->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="overdue" {{ old('status', $bill->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>

                        {{-- Due Date --}}
                        <div>
                            <label for="due_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Due Date
                            </label>
                            <input 
                                type="date" 
                                name="due_date" 
                                id="due_date"
                                value="{{ old('due_date', $bill->due_date->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base transition"
                                required
                            >
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Optional notes...">{{ old('notes', $bill->notes) }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-6">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition transform hover:scale-[1.02]">
                                Update Bill
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const patientSelect = document.getElementById('patient_id');
        const appointmentSelect = document.getElementById('appointment_id');
        const oldAppointmentId = '{{ old('appointment_id', $bill->appointment_id ?? '') }}';

        function fetchAppointments(patientId) {
            console.log(`Fetching appointments for patient ID: ${patientId}`);
            appointmentSelect.innerHTML = '<option value="">Select an appointment</option>';

            if (patientId) {
                fetch(`/appointments/${patientId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'No appointments available';
                            appointmentSelect.appendChild(option);
                        } else {
                            data.forEach(appointment => {
                                const option = document.createElement('option');
                                option.value = appointment.id;
                                option.textContent = `${appointment.treatment_type} (${appointment.appointment_date})`;

                                // Re-select old appointment if form was submitted
                                if (appointment.id == oldAppointmentId) {
                                    option.selected = true;
                                }

                                appointmentSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => console.error('Error fetching appointments:', error));
            }
        }

        // If a patient was selected before (old input), fetch their appointments
        const initialPatientId = patientSelect.value;
        if (initialPatientId) {
            fetchAppointments(initialPatientId);
        }

        // Fetch new appointments when patient changes
        patientSelect.addEventListener('change', function () {
            fetchAppointments(this.value);
        });
    });
</script>
@endsection