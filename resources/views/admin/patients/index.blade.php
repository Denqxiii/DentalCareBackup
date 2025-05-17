@extends('admin.layouts.app')

@section('title', 'Patients')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h4>Patient List</h4>
    <a href="/admin/patients/create" class="btn btn-primary">
        <i class="bi bi-plus"></i> Add Patient
    </a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patients as $patient)
        <tr>
            <td>{{ $patient->id }}</td>
            <td>{{ $patient->name }}</td>
            <td>{{ $patient->phone }}</td>
            <td>{{ $patient->email }}</td>
            <td>
                <a href="/admin/patients/{{ $patient->id }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection