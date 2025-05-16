@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Appointment Details</h1>
        <a href="{{ route('admin.appointments.index') }}" class="text-purple-600 hover:text-purple-800 dark:text-purple-400">
            ← Back to Appointments
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Patient Information -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Patient Information</h2>
                    <div class="space-y-3">
                        <p>
                            <span class="text-gray-600 dark:text-gray-400">Name:</span>
                            <span class="text-gray-800 dark:text-white">
                                {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                            </span>
                        </p>
                        <p>
                            <span class="text-gray-600 dark:text-gray-400">Email:</span>
                            <span class="text-gray-800 dark:text-white">{{ $appointment->patient->email }}</span>
                        </p>
                        <p>
                            <span class="text-gray-600 dark:text-gray-400">Phone:</span>
                            <span class="text-gray-800 dark:text-white">{{ $appointment->patient->phone }}</span>
                        </p>
                    </div>
                </div>

                <!-- Appointment Details -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Appointment Details</h2>
                    <div class="space-y-3">
                        <p>
                            <span class="text-gray-600 dark:text-gray-400">Date:</span>
                            <span class="text-gray-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
                            </span>
                        </p>
                        <p>
                            <span class="text-gray-600 dark:text-gray-400">Time:</span>
                            <span class="text-gray-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </span>
                        </p>
                        <p>
                            <span class="text-gray-600 dark:text-gray-400">Status:</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $appointment->status === 'Pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                   ($appointment->status === 'Confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                   ($appointment->status === 'Cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                                   'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200')) }}">
                                {{ $appointment->status }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Treatment Details Section -->
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Treatment Information</h2>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    @if($appointment->treatment)
                        <p class="text-gray-800 dark:text-white">
                            <span class="font-medium">Treatment:</span> 
                            {{ $appointment->treatment->name }}
                        </p>
                        <p class="text-gray-800 dark:text-white mt-2">
                            <span class="font-medium">Description:</span> 
                            {{ $appointment->treatment->description }}
                        </p>
                        <p class="text-gray-800 dark:text-white mt-2">
                            <span class="font-medium">Duration:</span> 
                            {{ $appointment->treatment->duration }} minutes
                        </p>
                        <p class="text-gray-800 dark:text-white mt-2">
                            <span class="font-medium">Price:</span> 
                            ${{ number_format($appointment->treatment->price, 2) }}
                        </p>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">No treatment specified</p>
                    @endif
                    
                    @if($appointment->notes)
                    <div class="mt-4">
                        <h3 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</h3>
                        <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $appointment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Edit Appointment
                </a>
                <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors"
                            onclick="return confirm('Are you sure you want to cancel this appointment?')">
                        Cancel Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection