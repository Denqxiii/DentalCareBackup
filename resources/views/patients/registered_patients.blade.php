@extends('layouts.app')

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Registered Patients
        </h2>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">Patient ID</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Gender</th>
                            <th class="px-4 py-3">Birth Date</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone</th>
                            <th class="px-4 py-3">Address</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($patients as $patient)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">{{ $patient->patient_id }}</td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $patient->first_name }} {{ $patient->middle_name }} {{ $patient->last_name }}
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $patient->gender }}</td>
                                <td class="px-4 py-3 text-sm">{{ $patient->birth_date }}</td>
                                <td class="px-4 py-3 text-sm">{{ $patient->email }}</td>
                                <td class="px-4 py-3 text-sm">{{ $patient->phone }}</td>
                                <td class="px-4 py-3 text-sm">{{ $patient->address }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <!-- View Button -->
                                    <a href="{{ route('patients.show_details', $patient->patient_id) }}" class="text-blue-600 dark:text-blue-400">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
 