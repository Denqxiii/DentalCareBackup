<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Book Appointment</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f0f4ff 0%, #f9fafb 100%);
    }
    .back-button {
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 100;
    }
    .toast {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 1rem;
      border-radius: 0.5rem;
      color: white;
      font-weight: 500;
      z-index: 1000;
      transform: translateX(150%);
      transition: transform 0.3s ease-in-out;
    }
    .toast.show {
      transform: translateX(0);
    }
    .toast.success {
      background-color: #10B981;
    }
    .toast.error {
      background-color: #EF4444;
    }
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(255,255,255,0.7);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 2000;
      display: none;
    }
    .spinner {
      border: 6px solid #e5e7eb;
      border-top: 6px solid #3b82f6;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <!-- Loading Overlay -->
  <div id="loading-overlay" class="loading-overlay">
    <div class="spinner"></div>
  </div>
  <!-- Back Button -->
  <a href="{{ route('homepage') }}" class="back-button bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow flex items-center">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to Home
  </a>

  <div class="flex min-h-screen items-center justify-center">
    <!-- Left Section: Appointment Form -->
    <div class="w-full md:w-2/5 flex flex-col justify-center items-center px-4 py-10">
      <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border-t-8 border-blue-500 px-8 py-10 relative">
        <div class="flex flex-col items-center mb-6">
          <div class="bg-blue-100 text-blue-600 rounded-full p-3 mb-3 shadow">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="8" r="4" />
              <path d="M4 20c0-2.21 3.58-4 8-4s8 1.79 8 4" />
            </svg>
          </div>
          <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-1 text-center">Book your appointment</h1>
          <div class="w-16 h-1 bg-blue-500 rounded mb-2"></div>
          <p class="mb-4 text-gray-500 text-center">Schedule your dental appointment easily. Just fill out the form and we'll get back to you as soon as possible.</p>
        </div>
        <p class="text-sm text-gray-500 mb-4 text-center">
          No patient ID? <a href="javascript:void(0);" onclick="openRegistrationModal()" class="text-blue-600 hover:underline">Register here</a>.
        </p>
        <form class="space-y-5" id="appointment-form">
          @csrf  
          <input type="text" id="patient-id" name="patient_id" placeholder="Enter Patient ID (Sent via Email)" class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" onblur="fetchPatientDetails()">
          <input type="text" id="full-name" name="full_name" placeholder="Full Name" class="w-full p-3 border rounded-lg bg-gray-100" readonly>
          <input type="tel" id="phone-number" name="phone_number" placeholder="Phone Number" class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" required>
          <!-- Gender Selection -->
          <div class="flex gap-4">
            <label class="flex items-center">
              <input type="radio" name="gender" value="Male" class="mr-2" disabled> Male
            </label>
            <label class="flex items-center">
              <input type="radio" name="gender" value="Female" class="mr-2" disabled> Female
            </label>
            <label class="flex items-center">
              <input type="radio" name="gender" value="Other" class="mr-2" disabled> Other
            </label>
          </div>
          <div class="flex gap-4">
            <select name="treatment_id" id="treatment_id" class="w-1/2 p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" required>
              <option value="" disabled selected>Select Treatment</option>
              @foreach($treatments as $treatment)
                <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
              @endforeach
            </select>
            <input type="date" name="appointment_date" id="appointment_date" class="w-1/2 p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" required>
          </div>
          <!-- Time Selection -->
          <select name="appointment_time" id="appointment_time" class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" required>
            <option value="" disabled selected>Select Time</option>
            <option value="09:00">9:00 AM</option>
            <option value="10:00">10:00 AM</option>
            <option value="11:00">11:00 AM</option>
            <option value="12:00">12:00 PM</option>
            <option value="13:00">1:00 PM</option>
            <option value="14:00">2:00 PM</option>
            <option value="15:00">3:00 PM</option>
            <option value="16:00">4:00 PM</option>
            <option value="17:00">5:00 PM</option>
            <option value="18:00">6:00 PM</option>
          </select>
          <textarea name="message" placeholder="Write message" rows="4" class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition"></textarea>
          <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold py-3 rounded-xl shadow-lg text-lg transition transform hover:scale-105">Book Appointment</button>
          <p class="text-left text-sm text-gray-400 mt-4">© 2025 Dental Care – All Rights Reserved.</p>
        </form>
      </div>
    </div>
    <!-- Right Section: Image -->
    <div class="hidden md:flex w-3/5 items-center justify-center p-10">
      <div class="w-full h-[600px] rounded-2xl shadow-xl overflow-hidden bg-white flex items-center justify-center">
        <img src="/assets/img/homepage_and_book/book.jpg" alt="Dental Appointment" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
      </div>
    </div>
  </div>

  <!-- Registration Form Modal -->
  <div id="registration-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden z-50" onclick="if(event.target === this) closeRegistrationModal()">
    <div class="bg-white p-6 rounded-md w-96" onclick="event.stopPropagation()">
      <h2 class="text-2xl font-bold mb-4">Register as a New Patient</h2>
      <form id="registration-form" action="{{ route('patients.store') }}" method="POST">
        @csrf
        <input type="text" name="first_name" placeholder="Enter First Name" class="w-full p-3 border rounded-md bg-gray-100 mb-4" required>
        <input type="text" name="middle_name" placeholder="Enter Middle Name (Optional)" class="w-full p-3 border rounded-md bg-gray-100 mb-4">
        <input type="text" name="last_name" placeholder="Enter Last Name" class="w-full p-3 border rounded-md bg-gray-100 mb-4" required>
        <input type="tel" name="phone" placeholder="Enter Phone Number" class="w-full p-3 border rounded-md bg-gray-100 mb-4" required>
        <!-- Gender Selection -->
        <div class="flex gap-4 mb-4">
          <label class="flex items-center">
            <input type="radio" name="gender" value="Male" class="mr-2" required> Male
          </label>
          <label class="flex items-center">
            <input type="radio" name="gender" value="Female" class="mr-2" required> Female
          </label>
          <label class="flex items-center">
            <input type="radio" name="gender" value="Other" class="mr-2" required> Other
          </label>
        </div>
        <input type="email" name="email" placeholder="Enter Email" class="w-full p-3 border rounded-md bg-gray-100 mb-4" required>
        <input type="date" name="birth_date" placeholder="Enter Birth Date" class="w-full p-3 border rounded-md bg-gray-100 mb-4" required>
        <input type="text" name="address" placeholder="Enter Address" class="w-full p-3 border rounded-md bg-gray-100 mb-4" required>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-md">Register</button>
      </form>
      <button onclick="closeRegistrationModal()" class="w-full text-center text-sm text-gray-400 mt-4">Cancel</button>
    </div>
  </div>

  <!-- Toast Container -->
  <div id="toast" class="toast"></div>

  <script>
    function fetchPatientDetails() {
      const patientId = document.getElementById('patient-id').value;
      if (!patientId) return;

      const fullNameInput = document.getElementById('full-name');
      fullNameInput.value = 'Loading...';

      console.log('Fetching patient details for ID:', patientId);

      fetch(`/api/patients/${patientId}`, {
          headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
      })
      .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        console.log('Received data:', data);
        
        if (data && data.patient) {
          const patient = data.patient;
          console.log('Patient data:', patient);
          
          // Update form fields
          fullNameInput.value = `${patient.first_name} ${patient.middle_name || ''} ${patient.last_name}`.trim();
          document.getElementById('phone-number').value = patient.phone || '';
          
          // Enable and update gender selection
          document.querySelectorAll('input[name="gender"]').forEach(radio => {
            radio.disabled = false;
            if (radio.value === patient.gender) {
              radio.checked = true;
            }
          });
          
          showToast('Patient details loaded successfully', 'success');
        } else {
          console.error('Patient data not found in response:', data);
          showToast('Patient not found!', 'error');
          fullNameInput.value = '';
        }
      })
      .catch(error => {
        console.error('Error fetching patient details:', error);
        showToast('Error fetching patient details. Please try again.', 'error');
        fullNameInput.value = '';
      });
    }
    // Function to open registration modal
    function openRegistrationModal() {
      document.getElementById('registration-modal').style.display = 'flex';
    }
    // Function to close registration modal
    function closeRegistrationModal() {
      document.getElementById('registration-modal').style.display = 'none';
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = `toast ${type}`;
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 5000);
    }

    function showLoader() {
      document.getElementById('loading-overlay').style.display = 'flex';
    }
    function hideLoader() {
      document.getElementById('loading-overlay').style.display = 'none';
    }

    document.getElementById('appointment-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
      // Validate required fields
      const requiredFields = {
          'patient_id': 'Patient ID',
          'treatment_id': 'Treatment',
          'appointment_date': 'Appointment Date',
          'appointment_time': 'Appointment Time',
          'phone_number': 'Phone Number',
          'gender': 'Gender'
      };
      
      const missingFields = [];
      for (const [field, name] of Object.entries(requiredFields)) {
          if (!this.elements[field]?.value) {
              missingFields.push(name);
          }
      }
      
      if (missingFields.length > 0) {
          showToast(`Please fill in: ${missingFields.join(', ')}`, 'error');
          return;
      }

      // Prepare form data
      const formData = {
          patient_id: this.elements.patient_id.value,
          treatment_id: this.elements.treatment_id.value,
          appointment_date: this.elements.appointment_date.value,
          appointment_time: this.elements.appointment_time.value,
          phone_number: this.elements.phone_number.value,
          gender: document.querySelector('input[name="gender"]:checked')?.value,
          message: this.elements.message?.value || ''
      };

      try {
          showLoader();
          const response = await axios.post('/book-appointment', formData, {
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              }
          });
          
          if (response.data.success) {
              showToast('Appointment booked successfully!', 'success');
              this.reset();
          } else {
              showToast(response.data.message, 'error');
          }
      } catch (error) {
          console.error('Error:', error);
          const errorMsg = error.response?.data?.message || 
                          error.response?.data?.errors?.join('\n') || 
                          'Booking failed. Please try again.';
          showToast(errorMsg, 'error');
      } finally {
          hideLoader();
      }
  });

    document.getElementById('registration-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      // Collect form data
      const formData = {
          first_name: this.elements.first_name.value.trim(),
          middle_name: this.elements.middle_name?.value.trim() || null,
          last_name: this.elements.last_name.value.trim(),
          email: this.elements.email.value.trim(),
          phone: this.elements.phone.value.trim(),
          gender: document.querySelector('input[name="gender"]:checked')?.value,
          birth_date: this.elements.birth_date.value,
          address: this.elements.address.value.trim()
      };

      try {
          // Show loading state
          const submitBtn = this.querySelector('button[type="submit"]');
          submitBtn.disabled = true;
          submitBtn.innerHTML = 'Registering...';

          const response = await axios.post('/patients', formData, {
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              }
          });
          
          if (response.data.status === "success") {
              // Show success message
              showToast('Patient registered successfully!', 'success');
              
              // Close modal
              closeRegistrationModal();
              
              // Auto-fill patient ID in appointment form
              document.getElementById('patient-id').value = response.data.data.patient_id;
              
              // Enable gender radios
              document.querySelectorAll('input[name="gender"]').forEach(radio => {
                  radio.disabled = false;
                  if (radio.value === response.data.data.gender) {
                      radio.checked = true;
                  }
              });
          }
      } catch (error) {
          console.error('Registration error:', error);
          
          let errorMsg = 'Registration failed. Please try again.';
          if (error.response?.data?.errors) {
              errorMsg = Object.values(error.response.data.errors).flat().join('\n');
          } else if (error.response?.data?.message) {
              errorMsg = error.response.data.message;
          }
          
          showToast(errorMsg, 'error');
      } finally {
          // Reset button state
          const submitBtn = this.querySelector('button[type="submit"]');
          submitBtn.disabled = false;
          submitBtn.innerHTML = 'Register';
      }
  });
  </script>  </script>



</html></body></body>
</html>
