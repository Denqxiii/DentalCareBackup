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

    input:disabled, select:disabled, textarea:disabled {
        background-color: #f3f4f6;
        cursor: not-allowed;
    }

    .loading-pulse {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { opacity: 0.6; }
        50% { opacity: 1; }
        100% { opacity: 0.6; }
    }

    .is-invalid {
        border-color: #EF4444 !important;
    }

    .invalid-feedback {
        color: #EF4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
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
          <div>
            <input type="text" id="patient-id" name="patient_id" placeholder="Enter Patient ID (Sent via Email)" 
                   class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" 
                   onblur="fetchPatientDetails()">
            <div id="patient-id-error" class="invalid-feedback hidden"></div>
          </div>
          <input type="text" id="patient_name" name="patient_name" placeholder="Full Name" 
                 class="w-full p-3 border rounded-lg bg-gray-100" readonly>
          <input type="tel" id="patient_phone" name="patient_phone" placeholder="Phone Number" 
                 class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" required>
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
            <div class="w-1/2">
              <select name="treatment_id" id="treatment_id" 
                      class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" required>
                <option value="" disabled selected>Select Treatment</option>
                @foreach($treatments as $treatment)
                      <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="w-1/2">
              <input type="datetime-local" name="appointment_date" id="appointment_date" 
                     class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" min="{{ now()->format('Y-m-d\TH:i') }}" 
                      value="{{ now()->addDay()->format('Y-m-d\T09:00') }}"
               required>
            </div>
          </div>
          <textarea name="message" placeholder="Write message" rows="4" 
                    class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition"></textarea>
          <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold py-3 rounded-xl shadow-lg text-lg transition transform hover:scale-105">
            Book Appointment
          </button>
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
      <form id="registration-form" action="{{ route('patients.register') }}" method="POST">
        @csrf
        <div class="mb-4">
          <input type="text" name="first_name" placeholder="Enter First Name" 
                 class="w-full p-3 border rounded-md bg-gray-100" required>
          <div class="invalid-feedback hidden"></div>
        </div>
        <div class="mb-4">
          <input type="text" name="middle_name" placeholder="Enter Middle Name (Optional)" 
                 class="w-full p-3 border rounded-md bg-gray-100">
        </div>
        <div class="mb-4">
          <input type="text" name="last_name" placeholder="Enter Last Name" 
                 class="w-full p-3 border rounded-md bg-gray-100" required>
          <div class="invalid-feedback hidden"></div>
        </div>
        <div class="mb-4">
          <input type="tel" name="phone" placeholder="Enter Phone Number" 
                 class="w-full p-3 border rounded-md bg-gray-100" required>
          <div class="invalid-feedback hidden"></div>
        </div>
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
        <div class="mb-4">
          <input type="email" name="email" placeholder="Enter Email" 
                 class="w-full p-3 border rounded-md bg-gray-100" required>
          <div class="invalid-feedback hidden"></div>
        </div>
        <div class="mb-4">
          <input type="date" name="birth_date" placeholder="Enter Birth Date" 
                 class="w-full p-3 border rounded-md bg-gray-100" required>
          <div class="invalid-feedback hidden"></div>
        </div>
        <div class="mb-4">
          <input type="text" name="address" placeholder="Enter Address" 
                 class="w-full p-3 border rounded-md bg-gray-100" required>
          <div class="invalid-feedback hidden"></div>
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-md">
          Register
        </button>
      </form>
      <button onclick="closeRegistrationModal()" class="w-full text-center text-sm text-gray-400 mt-4">Cancel</button>
    </div>
  </div>

  <!-- Toast Container -->
  <div id="toast" class="toast"></div>

  <script>
   async function fetchPatientDetails() {
        const patientId = document.getElementById('patient-id').value.trim();
        if (!patientId) return;

        showLoader();
        try {
            const response = await fetch(`/api/patient/${patientId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) throw new Error('Patient not found');
            
            const data = await response.json();
            
            if (data.patient) {
                // Enable all fields first
                document.getElementById('patient_name').readOnly = false;
                document.getElementById('patient_phone').readOnly = false;
                document.querySelectorAll('input[name="gender"]').forEach(radio => {
                    radio.disabled = false;
                });

                // Set values
                document.getElementById('patient_name').value = data.patient.full_name || 
                    `${data.patient.first_name} ${data.patient.last_name}`;
                document.getElementById('patient_phone').value = data.patient.phone;
                
                // Set gender
                document.querySelectorAll('input[name="gender"]').forEach(radio => {
                    if (radio.value.toLowerCase() === data.patient.gender.toLowerCase()) {
                        radio.checked = true;
                    }
                });

                // Make fields readonly after setting values (except phone)
                document.getElementById('patient_name').readOnly = true;
                document.querySelectorAll('input[name="gender"]').forEach(radio => {
                    radio.disabled = true; // Keep disabled but with values set
                });
            } else {
                throw new Error('Invalid patient data format');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast(error.message || 'Error loading patient details', 'error');
            resetPatientFields();
        } finally {
            hideLoader();
        }
    }

     document.getElementById('appointment-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        showLoader();

        try {
            // Create a plain object from form data
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                // Include all fields, even disabled ones
                data[key] = value;
            });

            // Manually add disabled fields that should be submitted
            if (!data.gender) {
                const selectedGender = document.querySelector('input[name="gender"]:checked');
                if (selectedGender) data.gender = selectedGender.value;
            }

            const response = await axios.post('{{ route("appointments.guest") }}', data, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });

            if (response.data.success) {
                showToast('Appointment booked successfully!', 'success');
                form.reset();
                resetPatientFields();
            } else {
                showToast(response.data.message || 'Booking failed', 'error');
            }
        } catch (error) {
            if (error.response) {
                if (error.response.status === 401) {
                    showToast('Please login or register first', 'error');
                } else if (error.response.data.errors) {
                    // Clear previous errors
                    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                    
                    // Handle validation errors
                    Object.entries(error.response.data.errors).forEach(([field, messages]) => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = messages.join(' ');
                            input.parentNode.appendChild(errorDiv);
                        }
                    });
                }
            } else {
                showToast('Network error. Please try again.', 'error');
            }
        } finally {
            hideLoader();
        }
    });

      function resetPatientFields() {
          document.getElementById('patient_name').value = '';
          document.getElementById('patient_phone').value = '';
          document.querySelectorAll('input[name="gender"]').forEach(r => {
              r.checked = false;
              r.disabled = true;
              r.required = false;
          });
      }

      // Submit registration form (ajax)
      document.getElementById('registration-form').addEventListener('submit', async function(e) {
          e.preventDefault();
          
          // Show loading state
          const submitBtn = this.querySelector('button[type="submit"]');
          submitBtn.disabled = true;
          submitBtn.innerHTML = 'Registering...';
          showLoader();

          try {
              // Create FormData object
              const formData = new FormData(this);
              
              // Convert FormData to JSON
              const jsonData = {};
              formData.forEach((value, key) => {
                  jsonData[key] = value;
              });

              const response = await axios.post(this.action, jsonData, {
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                  }
              });

              if (response.data.success) {
                  showToast('Registration successful!', 'success');
                  closeRegistrationModal();
                  
                  // Auto-fill patient ID if exists in response
                  if (response.data.patient_id) {
                      document.getElementById('patient-id').value = response.data.patient_id;
                      fetchPatientDetails();
                  }
              } else {
                  showToast(response.data.message || 'Registration failed', 'error');
              }
          } catch (error) {
              console.error('Registration error:', error);
              
              if (error.response?.data?.errors) {
                  // Clear previous errors
                  document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                  document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                  
                  // Show new errors
                  Object.entries(error.response.data.errors).forEach(([field, messages]) => {
                      const input = this.querySelector(`[name="${field}"]`);
                      if (input) {
                          input.classList.add('is-invalid');
                          const errorDiv = document.createElement('div');
                          errorDiv.className = 'invalid-feedback';
                          errorDiv.textContent = messages.join(' ');
                          input.parentNode.appendChild(errorDiv);
                      }
                  });
                  
                  showToast('Please fix the errors in the form', 'error');
              } else {
                  showToast('An error occurred during registration', 'error');
              }
          } finally {
              submitBtn.disabled = false;
              submitBtn.innerHTML = 'Register';
              hideLoader();
          }
      });

      // Loader controls
      function showLoader() {
        document.getElementById('loading-overlay').style.display = 'flex';
      }
      function hideLoader() {
        document.getElementById('loading-overlay').style.display = 'none';
      }

      // Function to open registration modal
      function openRegistrationModal() {
          document.getElementById('registration-modal').classList.remove('hidden');
          document.getElementById('registration-modal').style.display = 'flex';
      }

      // Function to close registration modal
      function closeRegistrationModal() {
          document.getElementById('registration-modal').classList.add('hidden');
          document.getElementById('registration-modal').style.display = 'none';
      }

      // Show toast notification
      function showToast(message, type = 'success') {
          const toast = document.getElementById('toast');
          toast.textContent = message;
          toast.className = `toast ${type}`;
          toast.classList.add('show');
          
          setTimeout(() => {
              toast.classList.remove('show');
          }, 5000);
      }
  </script>
</body>
</html>