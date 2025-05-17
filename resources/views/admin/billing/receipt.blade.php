<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Payment Receipt - {{ config('app.name') }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    .header { text-align: center; margin-bottom: 20px; }
    .logo { max-width: 150px; }
    .title { font-size: 18px; font-weight: bold; }
    .clinic-info { margin-bottom: 20px; }
    .receipt-info { margin-bottom: 20px; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 8px; border: 1px solid #ddd; }
    .table th { background-color: #f2f2f2; text-align: left; }
    .text-right { text-align: right; }
    .footer { margin-top: 30px; font-size: 10px; text-align: center; }
    .signature { margin-top: 50px; }
  </style>
</head>
<body>
  <div class="header">
    @if(config('app.logo'))
      <img src="{{ storage_path('app/public/' . config('app.logo')) }}" class="logo">
    @endif
    <div class="title">{{ config('app.name') }}</div>
    <div class="clinic-info">
      {{ config('app.address') }}<br>
      Phone: {{ config('app.phone') }} | Email: {{ config('app.email') }}
    </div>
  </div>
  
  <div class="receipt-info">
    <div style="float: left; width: 50%;">
      <strong>Receipt #:</strong> {{ $payment->id }}<br>
      <strong>Date:</strong> {{ $payment->created_at->format('M j, Y') }}<br>
    </div>
    <div style="float: right; width: 50%; text-align: right;">
      <strong>Invoice #:</strong> {{ $invoice->invoice_number }}<br>
      <strong>Patient:</strong> {{ $invoice->patient->full_name }}<br>
    </div>
    <div style="clear: both;"></div>
  </div>
  
  <table class="table">
    <thead>
      <tr>
        <th>Description</th>
        <th class="text-right">Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Payment received for Invoice #{{ $invoice->invoice_number }}</td>
        <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
      </tr>
      <tr>
        <td><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</td>
        <td></td>
      </tr>
      @if($payment->transaction_id)
      <tr>
        <td><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</td>
        <td></td>
      </tr>
      @endif
    </tbody>
  </table>
  
  <div class="footer">
    <p>Thank you for your payment. This is an official receipt.</p>
    <div class="signature">
      <p>___________________________</p>
      <p>Authorized Signature</p>
    </div>
    <p>{{ config('app.name') }} | {{ config('app.url') }}</p>
  </div>
</body>
</html>