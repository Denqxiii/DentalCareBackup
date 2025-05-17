@extends('layouts.admin')

@section('title', 'Add Patient')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Add New Patient</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/admin/patients">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="tel" class="form-control" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Patient</button>
        </form>
    </div>
</div>
@endsection