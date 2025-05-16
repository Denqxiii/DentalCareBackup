@extends('layouts.app')

@php
    function getStatusBadge($status) {
        switch ($status) {
            case 'Pending': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
            case 'Confirmed': return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
            case 'Cancelled': return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
            case 'Completed': return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
            default: return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
        }
    }
@endphp

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-4 mx-auto sm:px-6 lg:px-8">
            <!-- Header with stats -->
            <div class="mb-8">
                <div class="flex flex-col items-start justify-between space-y-4 md:flex-row md:items-center md:space-y-0">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                            Appointment Management
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">Manage and track patient appointments</p>
                    </div>
                    <div class="flex space-x-3">
                        <!-- Export Button -->
                        <button class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export
                        </button>
                    </div>
                </div>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-4 mt-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Total Appointments</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-800 dark:text-purple-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Upcoming</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['upcoming'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Completed</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['completed'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Cancelled</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['cancelled'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-red-100 text-red-600 dark:bg-red-800 dark:text-red-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="p-6">
                    <form action="{{ route('admin.appointments.index') }}" method="GET" class="space-y-4 md:space-y-0">
                        <!-- Search Input Row -->
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
                            <div class="flex-grow">
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Patient name, treatment or ID...">
                                </div>
                            </div>
                        </div>

                        <!-- Filter Controls Row -->
                        <div class="flex flex-col sm:flex-row sm:items-end space-y-4 sm:space-y-0 sm:space-x-4">
                            <!-- Status Filter -->
                            <div class="flex-1">
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                <select name="status" id="status" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">All Statuses</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>

                            <!-- Date Filter -->
                            <div class="flex-1">
                                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                                <input type="date" name="date" id="date" value="{{ request('date') }}"
                                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-end space-x-3 pt-1">
                                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:bg-purple-700 dark:hover:bg-purple-800">
                                    Apply Filters
                                </button>
                                @if(request()->has('search') || request()->has('status') || request()->has('date'))
                                <a href="{{ route('admin.appointments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                                    Reset
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Appointments Table -->
                <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="overflow-x-auto w-full">  <!-- Added w-full -->
                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 table-auto">  <!-- Added w-full -->
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300 w-16">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300 min-w-[200px]">Patient</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300 min-w-[150px]">Treatment</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300 w-40">Date & Time</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300 w-28">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300 min-w-[180px]">Contact</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300 w-32">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($appointments as $appointment)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            #{{ $appointment->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <div class="flex items-center justify-center w-full h-full rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                                        {{ substr($appointment->patient->first_name, 0, 1) }}{{ substr($appointment->patient->last_name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $appointment->patient->gender ?? 'N/A' }} • {{ $appointment->patient->age ?? 'N/A' }} yrs
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                @if($appointment->treatment)
                                                    {{ $appointment->treatment->name }}
                                                @else
                                                    {{ $appointment->treatment_type ?? 'Consultation' }}
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                @if($appointment->treatment)
                                                    {{ $appointment->treatment->duration }} mins
                                                @else
                                                    {{ $appointment->duration ?? '30' }} mins
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                            </div>
                                            @if($appointment->appointment_date < now() && $appointment->status != 'Completed' && $appointment->status != 'Cancelled')
                                                <span class="inline-block mt-1 text-xs text-red-600 dark:text-red-400">Overdue</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full {{ getStatusBadge($appointment->status) }}">
                                                {{ $appointment->status }}
                                            </span>
                                            @if($appointment->notes)
                                                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs" title="{{ $appointment->notes }}">
                                                    <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                                    </svg>
                                                    {{ Str::limit($appointment->notes, 20) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                <a href="tel:{{ $appointment->patient->phone }}" class="hover:text-purple-600 dark:hover:text-purple-400">
                                                    {{ $appointment->patient->phone ?? 'N/A' }}
                                                </a>
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                                <a href="mailto:{{ $appointment->patient->email }}" class="hover:text-purple-600 dark:hover:text-purple-400">
                                                    {{ $appointment->patient->email ?? 'N/A' }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <div class="flex justify-end space-x-2">
                                                @if($appointment->status != 'Completed')
                                                <form action="{{ route('admin.appointments.update-status', ['appointment' => $appointment->id, 'status' => 'Completed']) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="p-1 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 tooltip"
                                                            data-tooltip="Mark as Completed">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                <a href="{{ route('admin.appointments.manage', $appointment->id) }}" 
                                                class="p-1 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 tooltip"
                                                data-tooltip="Manage">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                
                                                @if($appointment->status != 'Cancelled')
                                                <form action="{{ route('admin.appointments.update-status', ['appointment' => $appointment->id, 'status' => 'Cancelled']) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="p-1 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 tooltip"
                                                            data-tooltip="Cancel"
                                                            onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                <a href="{{ route('admin.appointments.show', $appointment->id) }}" 
                                                class="p-1 text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 tooltip"
                                                data-tooltip="View Details">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No appointments found</h3>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                @if(request()->has('search') || request()->has('status') || request()->has('date'))
                                                    Try adjusting your search or filter to find what you're looking for.
                                                @else
                                                    There are currently no appointments scheduled. Create a new appointment to get started.
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="flex flex-col items-center px-4 py-3 bg-gray-50 border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600 sm:px-6 sm:flex-row sm:justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Showing <span class="font-medium">{{ $appointments->firstItem() }}</span> to <span class="font-medium">{{ $appointments->lastItem() }}</span> of <span class="font-medium">{{ $appointments->total() }}</span> results
                        </div>
                        <div class="mt-2 sm:mt-0">
                            {{ $appointments->links() }}
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection

@push('scripts')
    <script>
        // Tooltip functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tooltips = document.querySelectorAll('.tooltip');
            
            tooltips.forEach(tooltip => {
                const tooltipText = tooltip.getAttribute('data-tooltip');
                const tooltipElement = document.createElement('div');
                
                tooltipElement.className = 'hidden absolute z-10 py-1 px-2 text-xs font-medium text-white bg-gray-900 rounded-md shadow-sm whitespace-nowrap';
                tooltipElement.textContent = tooltipText;
                tooltipElement.style.top = '100%';
                tooltipElement.style.left = '50%';
                tooltipElement.style.transform = 'translateX(-50%)';
                
                tooltip.parentNode.style.position = 'relative';
                tooltip.parentNode.appendChild(tooltipElement);
                
                tooltip.addEventListener('mouseenter', () => {
                    tooltipElement.classList.remove('hidden');
                });
                
                tooltip.addEventListener('mouseleave', () => {
                    tooltipElement.classList.add('hidden');
                });
            });
        });
    </script>
@endpush