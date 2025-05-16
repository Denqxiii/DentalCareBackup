@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Prescriptions</h1>
        <a href="{{ route('prescriptions.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Create New Prescription
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($prescriptions as $prescription)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $prescription->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Dr. {{ $prescription->doctor->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $prescription->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('prescriptions.show', $prescription) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                        <a href="{{ route('prescriptions.edit', $prescription) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form action="{{ route('prescriptions.destroy', $prescription) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $prescriptions->links() }}
    </div>
</div>
@endsection