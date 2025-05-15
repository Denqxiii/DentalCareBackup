<?php
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Patient History</h1>
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Patient Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Appointment Date</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $patient)
                    @foreach ($patient->appointments as $appointment)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $patient->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $appointment->appointment_date }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $appointment->status }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-center text-sm text-gray-500 dark:text-gray-400">No patient history found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection