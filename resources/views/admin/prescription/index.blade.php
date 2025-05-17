@extends('layouts.admin')

@section('title', 'Prescriptions')

@section('content')
<div class="card shadow-sm border-0 rounded-lg">
    <div class="card-header bg-gradient-primary text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="fas fa-prescription-bottle-alt me-2 fs-4" style="color: #000;"></i>
                <h5 class="mb-0 text-dark">Prescription Management</h5>
            </div>
            <div>
                <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-light text-primary fw-bold">
                    <i class="fas fa-plus-circle me-1"></i> New Prescription
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="p-3">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search prescriptions..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <button type="button" class="btn btn-outline-primary">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" width="60">
                            <span class="fw-bold text-uppercase text-muted small">ID</span>
                        </th>
                        <th width="25%">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user text-primary me-2"></i>
                                <span class="fw-bold text-uppercase text-muted small">Patient</span>
                            </div>
                        </th>
                        <th width="25%">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-md text-primary me-2"></i>
                                <span class="fw-bold text-uppercase text-muted small">Doctor</span>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                <span class="fw-bold text-uppercase text-muted small">Date</span>
                            </div>
                        </th>
                        <th class="text-end pe-3" width="130">
                            <span class="fw-bold text-uppercase text-muted small">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr>
                        <td class="ps-3 fw-bold">#{{ $prescription->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-light text-primary me-2">
                                    {{ substr($prescription->patient->name, 0, 1) }}
                                </div>
                                {{ $prescription->patient->name }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-light text-primary me-2">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                {{ $prescription->doctor->name }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-light text-dark me-2">
                                    {{ $prescription->created_at->format('m/d/Y') }}
                                </span>
                                <small class="text-muted">
                                    {{ $prescription->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end gap-1 pe-2">
                                <a href="{{ route('admin.prescriptions.show', $prescription->id) }}" 
                                   class="btn btn-sm btn-outline-info rounded-pill px-3" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.prescriptions.edit', $prescription->id) }}" 
                                   class="btn btn-sm btn-outline-warning rounded-pill px-3" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                   class="btn btn-sm btn-outline-danger rounded-pill px-3" 
                                   title="Delete"
                                   onclick="confirmDelete({{ $prescription->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-prescription-bottle-alt fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No prescriptions found</h6>
                                <p class="small text-muted">Create your first prescription to get started</p>
                                <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus-circle me-1"></i> New Prescription
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">
                        Showing {{ $prescriptions->firstItem() ?? 0 }} to {{ $prescriptions->lastItem() ?? 0 }} 
                        of {{ $prescriptions->total() ?? 0 }} prescriptions
                    </small>
                </div>
                <div>
                    {{ $prescriptions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this prescription? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Prescription</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .page-link {
        border-radius: 0.2rem;
        margin: 0 0.1rem;
    }
    
    .page-item.active .page-link {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }
</style>
@endsection

@section('scripts')
<script>
    function confirmDelete(id) {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('deleteForm').action = `{{ route('admin.prescriptions.destroy', '') }}/${id}`;
        modal.show();
    }
    
    $(document).ready(function() {
        // Simple client-side search
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection