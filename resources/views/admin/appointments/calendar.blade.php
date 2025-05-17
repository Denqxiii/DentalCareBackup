@extends('admin.layouts.app')

@section('title', 'Appointment Calendar')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Appointment Calendar</h5>
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Appointment
            </a>
        </div>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
<style>
    #calendar {
        background-color: white;
        border-radius: 0.25rem;
        padding: 1rem;
    }
    .fc-event {
        cursor: pointer;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: {!! json_encode($events) !!},
            eventClick: function(info) {
                window.location.href = `/admin/appointments/${info.event.id}`;
            },
            eventDisplay: 'block',
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            }
        });
        calendar.render();
    });
</script>
@endsection
@endsection