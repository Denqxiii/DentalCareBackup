@component('mail::message')
# Welcome to {{ config('app.name') }}, {{ $patient->first_name }}!

Thank you for choosing our dental clinic! We're excited to care for your smile. Here are your registration details:

@component('mail::panel')
**Patient ID:** {{ $patient->patient_id }}  
**Name:** {{ $patient->first_name }} {{ $patient->last_name }}  
**Email:** {{ $patient->email }}  
**Phone:** {{ $patient->phone }}  
**Next Steps:** Please bring this ID to your first appointment
@endcomponent

**Important:**  
🔹 Your Patient ID is required for all appointments and inquiries  
🔹 Save this email for future reference  
🔹 Arrive 15 minutes early for your first visit with your ID  

@component('mail::button', ['url' => route('book.appointment'), 'color' => 'green'])
Schedule Your First Appointment
@endcomponent

For emergencies, please call:  
📞 {{ config('app.emergency_phone') ?? '(123) 456-7890' }}

We look forward to seeing your smile soon!  

Warm regards,  
**The {{ config('app.name') }} Team**  
📍 {{ config('app.address') ?? '123 Dental Care Avenue' }}  
🌐 {{ config('app.url') }}  
@endcomponent