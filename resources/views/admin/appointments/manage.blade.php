@extends('layouts.app')

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <!-- Header with back button -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Appointment Details
                </h2>
                <a href="{{ route('admin.appointments.index') }}" class="flex items-center text-sm text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Appointments
                </a>
            </div>

            <!-- Appointment Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden dark:bg-gray-800">
                <!-- Card Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Appointment #{{ $appointment->id }}
                    </h3>
                    <div class="flex items-center mt-1">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full {{ 
                            $appointment->status == 'Pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                            ($appointment->status == 'Completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') 
                        }}">
                            {{ $appointment->status }}
                        </span>
                        @if(\Carbon\Carbon::parse($appointment->appointment_date)->lt(now()) && $appointment->status != 'Completed' && $appointment->status != 'Cancelled')
                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Overdue
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Patient Information -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3 pb-2 border-b border-gray-200 dark:border-gray-600">
                                Patient Information
                            </h4>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                        {{ substr($appointment->patient->first_name, 0, 1) }}{{ substr($appointment->patient->last_name, 0, 1) }}
                                    </div>
                                </div>
                                <div>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $appointment->patient->first_name }} {{ $appointment->patient->middle_name }} {{ $appointment->patient->last_name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $appointment->patient->gender ?? 'N/A' }} • {{ $appointment->patient->age ?? 'N/A' }} years
                                    </p>
                                    <div class="mt-2 space-y-1">
                                        <p class="text-sm">
                                            <a href="tel:{{ $appointment->patient->phone }}" class="text-gray-600 hover:text-purple-600 dark:text-gray-300 dark:hover:text-purple-400">
                                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                {{ $appointment->patient->phone ?? 'N/A' }}
                                            </a>
                                        </p>
                                        <p class="text-sm">
                                            <a href="mailto:{{ $appointment->patient->email }}" class="text-gray-600 hover:text-purple-600 dark:text-gray-300 dark:hover:text-purple-400">
                                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $appointment->patient->email ?? 'N/A' }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Appointment Details -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3 pb-2 border-b border-gray-200 dark:border-gray-600">
                                Appointment Details
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Treatment Type</p>
                                    <p class="text-gray-900 dark:text-white">{{ $appointment->treatment_type ?? 'Consultation' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Date & Time</p>
                                    <p class="text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
                                        at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Duration</p>
                                    <p class="text-gray-900 dark:text-white">{{ $appointment->duration ?? '30' }} minutes</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    @if($appointment->notes)
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</h4>
                        <div class="bg-gray-50 p-4 rounded-lg dark:bg-gray-700">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $appointment->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Status Update Form -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <form action="{{ route('admin.appointments.update-status', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-4">Update Status</h4>
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                <div class="flex-grow">
                                    <select name="status" id="status" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="Pending" {{ $appointment->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Completed" {{ $appointment->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Cancelled" {{ $appointment->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:bg-purple-700 dark:hover:bg-purple-800">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection