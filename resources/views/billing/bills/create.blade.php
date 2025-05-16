@extends('layouts.app')

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center my-6 ml-0 md:ml-64">
            <a href="{{ route('billing.invoices') }}" class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded shadow-sm border border-gray-200 transition">
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
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                        </svg>
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
                <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mt-10" style="padding: 25px;">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Create New Bill</h2>

                    <form action="{{ route('billing.invoices.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Patient --}}
                        <div>
                            <label for="patient_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Patient</label>
                            <select name="patient_id" id="patient_id" required
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" disabled selected>Select a patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->first_name }} {{ $patient->last_name }}
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
                            </select>
                        </div>

                        {{-- Treatment Price (Hidden) --}}
                        <input type="hidden" id="treatment_price" value="0">

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
                                    value="{{ old('total_amount') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base transition"
                                    required
                                >
                            </div>
                        </div>

                        {{-- Amount Paid --}}
                        <div>
                            <label for="amount_paid" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Amount Paid
                            </label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-gray-500 dark:text-gray-400 text-base pointer-events-none">
                                    ₱
                                </span>
                                <input 
                                    type="number" 
                                    name="amount_paid" 
                                    id="amount_paid" 
                                    step="0.01" 
                                    min="0"
                                    value="{{ old('amount_paid') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base transition"
                                >
                            </div>
                        </div>

                        {{-- Change --}}
                        <div>
                            <label for="change_amount" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                Change
                            </label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-gray-500 dark:text-gray-400 text-base pointer-events-none">
                                    ₱
                                </span>
                                <input 
                                    type="number" 
                                    name="change_amount" 
                                    id="change_amount" 
                                    step="0.01"
                                    value="0.00"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base transition"
                                    readonly
                                >
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Optional notes...">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-6">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition transform hover:scale-[1.02]">
                                Create Bill
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
        const totalAmountInput = document.getElementById('total_amount');
        const amountPaidInput = document.getElementById('amount_paid');
        const changeAmountInput = document.getElementById('change_amount');
        const treatmentPriceInput = document.getElementById('treatment_price');
        const oldAppointmentId = '{{ old('appointment_id', '') }}';
        const oldPatientId = '{{ old('patient_id', '') }}';

        function fetchAppointments(patientId) {
            console.log(`Fetching appointments for patient ID: ${patientId}`);
            appointmentSelect.innerHTML = '<option value="">Select an appointment</option>';
            
            if (patientId) {
                // Use absolute URL path to ensure correct routing
                fetch(`/api/appointments/${patientId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Appointments data received:', data);
                        
                        if (data.length === 0) {
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'No completed appointments available';
                            appointmentSelect.appendChild(option);
                        } else {
                            // Filter for only completed appointments
                            const completedAppointments = data.filter(appointment => 
                                appointment.status === 'completed'
                            );
                            
                            console.log('Completed appointments:', completedAppointments);
                            
                            if (completedAppointments.length === 0) {
                                const option = document.createElement('option');
                                option.value = '';
                                option.textContent = 'No completed appointments available';
                                appointmentSelect.appendChild(option);
                            } else {
                                completedAppointments.forEach(appointment => {
                                    const option = document.createElement('option');
                                    option.value = appointment.id;
                                    const formattedDate = new Date(appointment.appointment_date).toLocaleDateString();
                                    option.textContent = `${appointment.treatment_type} (${formattedDate}) - ₱${appointment.treatment_price || 0}`;
                                    option.setAttribute('data-price', appointment.treatment_price || 0);

                                    // Re-select old appointment if form was submitted
                                    if (appointment.id == oldAppointmentId) {
                                        option.selected = true;
                                        updateTreatmentPrice(appointment.treatment_price || 0);
                                    }

                                    appointmentSelect.appendChild(option);
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching appointments:', error);
                        appointmentSelect.innerHTML = '<option value="">Error loading appointments</option>';
                    });
            }
        }

        function updateTreatmentPrice(price) {
            treatmentPriceInput.value = price;
            // Only update total amount if it's not already set by the user
            if (!totalAmountInput.value) {
                totalAmountInput.value = price;
            }
            calculateChange();
        }

        function calculateChange() {
            const totalAmount = parseFloat(totalAmountInput.value) || 0;
            const amountPaid = parseFloat(amountPaidInput.value) || 0;
            const change = amountPaid - totalAmount;
            
            // Only show positive change values
            changeAmountInput.value = change > 0 ? change.toFixed(2) : '0.00';
        }

        // If a patient was selected before (old input), fetch their appointments
        if (oldPatientId) {
            fetchAppointments(oldPatientId);
        }

        // Fetch new appointments when patient changes
        patientSelect.addEventListener('change', function () {
            if (this.value) {
                fetchAppointments(this.value);
            } else {
                appointmentSelect.innerHTML = '<option value="">Select an appointment</option>';
            }
            totalAmountInput.value = '';
            amountPaidInput.value = '';
            changeAmountInput.value = '0.00';
        });

        // Update total amount when appointment changes
        appointmentSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const treatmentPrice = selectedOption ? selectedOption.getAttribute('data-price') || 0 : 0;
            updateTreatmentPrice(treatmentPrice);
        });

        // Calculate change when amount paid changes
        amountPaidInput.addEventListener('input', calculateChange);
        totalAmountInput.addEventListener('input', calculateChange);
    });
</script>
@endsection