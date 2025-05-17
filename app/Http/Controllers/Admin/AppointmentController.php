<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Repositories\AppointmentRepository;
use Carbon\Carbon;

class AppointmentController extends BaseController
{
    private $appointmentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->appointmentRepository = app(AppointmentRepository::class);
    }

    public function index()
    {
        $today = Carbon::today();
        $upcoming = $this->appointmentRepository->getUpcomingAppointments();
        $past = $this->appointmentRepository->getPastAppointments(10);
        
        $this->title = "Appointment Management";
        $this->content = view('admin.appointments.index', 
            compact('upcoming', 'past', 'today'))->render();
            
        return $this->renderOutput();
    }

    public function create()
    {
        $patients = Patient::active()->get();
        $dentists = User::dentists()->get();
        $timeSlots = $this->generateTimeSlots();
        
        $this->title = "Schedule New Appointment";
        $this->content = view('admin.appointments.create', 
            compact('patients', 'dentists', 'timeSlots'))->render();
            
        return $this->renderOutput();
    }

    public function store(AppointmentRequest $request)
    {
        $data = $request->all();
        $data['appointment_date'] = Carbon::parse($data['date'] . ' ' . $data['time']);
        
        // Check for conflicts
        if ($this->appointmentRepository->hasConflict(
            $data['dentist_id'], 
            $data['appointment_date'])
        ) {
            return back()
                ->withInput()
                ->withErrors(['time' => 'The selected time is already booked']);
        }
        
        $appointment = $this->appointmentRepository->create($data);
        
        // Send notifications
        event(new NewAppointmentScheduled($appointment));
        
        return redirect()
            ->route('admin.appointments.show', $appointment->id)
            ->with(['success' => 'Appointment scheduled successfully']);
    }

    public function show($id)
    {
        $appointment = $this->appointmentRepository->getEdit($id);
        
        $this->title = "Appointment Details";
        $this->content = view('admin.appointments.show', 
            compact('appointment'))->render();
            
        return $this->renderOutput();
    }

    public function edit($id)
    {
        $appointment = $this->appointmentRepository->getEdit($id);
        $patients = Patient::active()->get();
        $dentists = User::dentists()->get();
        $timeSlots = $this->generateTimeSlots();
        
        $this->title = "Edit Appointment";
        $this->content = view('admin.appointments.edit', 
            compact('appointment', 'patients', 'dentists', 'timeSlots'))->render();
            
        return $this->renderOutput();
    }

    public function update(AppointmentRequest $request, $id)
    {
        $appointment = $this->appointmentRepository->getEdit($id);
        $data = $request->all();
        $data['appointment_date'] = Carbon::parse($data['date'] . ' ' . $data['time']);
        
        // Check for conflicts (excluding current appointment)
        if ($this->appointmentRepository->hasConflict(
            $data['dentist_id'], 
            $data['appointment_date'],
            $appointment->id
        )) {
            return back()
                ->withInput()
                ->withErrors(['time' => 'The selected time is already booked']);
        }
        
        $appointment->update($data);
        
        return redirect()
            ->route('admin.appointments.show', $appointment->id)
            ->with(['success' => 'Appointment updated successfully']);
    }

    public function destroy($id)
    {
        $appointment = $this->appointmentRepository->getEdit($id);
        $appointment->delete();
        
        return redirect()
            ->route('admin.appointments.index')
            ->with(['success' => 'Appointment cancelled successfully']);
    }
    
    public function calendar()
    {
        $events = $this->appointmentRepository->getCalendarEvents();
        
        $this->title = "Appointment Calendar";
        $this->content = view('admin.appointments.calendar', 
            compact('events'))->render();
            
        return $this->renderOutput();
    }
    
    public function changeStatus(Request $request, $id)
    {
        $appointment = $this->appointmentRepository->getEdit($id);
        $status = $request->input('status');
        
        $validStatuses = ['scheduled', 'completed', 'cancelled', 'no_show'];
        
        if (!in_array($status, $validStatuses)) {
            return back()->withErrors(['status' => 'Invalid status']);
        }
        
        $appointment->status = $status;
        $appointment->save();
        
        return back()->with(['success' => 'Appointment status updated']);
    }
    
    private function generateTimeSlots()
    {
        $slots = [];
        $start = Carbon::createFromTime(9, 0, 0); // 9 AM
        $end = Carbon::createFromTime(17, 0, 0);  // 5 PM
        
        while ($start <= $end) {
            $slots[$start->format('H:i')] = $start->format('h:i A');
            $start->addMinutes(30);
        }
        
        return $slots;
    }
}