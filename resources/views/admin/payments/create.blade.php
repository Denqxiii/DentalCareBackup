<h3>Payment for Appointment #{{ $appointment->id }}</h3>
<p>Patient: {{ $appointment->patient->name }}</p>

<form action="{{ route('payments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

    <div class="mb-3">
        <label>Amount</label>
        <input type="number" name="amount" step="0.01" required class="form-control" value="{{ $appointment->fee ?? '' }}">
    </div>

    <div class="mb-3">
        <label>Payment Method</label>
        <select name="method" required class="form-control">
            <option value="cash">Cash</option>
            <option value="card">Card</option>
            <option value="insurance">Insurance</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Payment Date</label>
        <input type="date" name="payment_date" required class="form-control" value="{{ date('Y-m-d') }}">
    </div>

    <button type="submit" class="btn btn-success">Submit Payment</button>
</form>
