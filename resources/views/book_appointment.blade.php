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
              <input type="date" name="appointment_date" id="appointment_date" 
                     class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" required>
            </div>
          </div>
          <!-- Time Selection -->
          <select name="appointment_time" id="appointment_time" 
                  class="w-full p-3 border rounded-lg bg-gray-100 focus:bg-blue-50 focus:border-blue-400 transition" required>
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
    // Function to open registration modal
    function openRegistrationModal() {
      document.getElementById('registration-modal').style.display = 'flex';
    }
    
    // Function to close registration modal
    function closeRegistrationModal() {
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

    // Show loading overlay
    function showLoader() {
      document.getElementById('loading-overlay').style.display = 'flex';
    }
    
    // Hide loading overlay
    function hideLoader() {
      document.getElementById('loading-overlay').style.display = 'none';
    }

    // Reset patient fields
    function resetPatientFields() {
        document.getElementById('patient_name').value = '';
        document.getElementById('patient_phone').value = '';
        document.querySelectorAll('input[name="gender"]').forEach(radio => {
            radio.checked = false;
            radio.disabled = true;
        });
    }

    // Fetch patient details when ID is entered
    async function fetchPatientDetails() {
        const patientId = document.getElementById('patient-id').value.trim();
        if (!patientId) return;

        // Show loading state
        const patientNameField = document.getElementById('patient_name');
        patientNameField.value = 'Loading...';
        patientNameField.classList.add('loading-pulse');
        
        // Disable fields while loading
        document.getElementById('patient_phone').disabled = true;
        document.querySelectorAll('input[name="gender"]').forEach(radio => {
            radio.disabled = true;
        });

        try {
            const response = await fetch(`/api/patient/${patientId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) throw new Error('Patient not found');
            
            const data = await response.json();
            
            if (data.success && data.patient) {
                // Fill the form fields
                document.getElementById('patient_name').value = data.patient.full_name;
                document.getElementById('patient_phone').value = data.patient.phone;
                
                // Enable and set gender radio buttons
                document.querySelectorAll('input[name="gender"]').forEach(radio => {
                    radio.disabled = false;
                    if (radio.value === data.patient.gender) {
                        radio.checked = true;
                    }
                });
                
                showToast('Patient details loaded successfully', 'success');
            } else {
                throw new Error('Invalid patient data format');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast(error.message || 'Error loading patient details', 'error');
            resetPatientFields();
        } finally {
            patientNameField.classList.remove('loading-pulse');
            document.getElementById('patient_phone').disabled = false;
        }
    }

    // Handle appointment form submission
    document.getElementById('appointment-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log("Form submission initiated"); // Debug log
        
        // Simple validation
        const patientId = document.getElementById('patient-id').value;
        if (!patientId) {
            showToast('Patient ID is required', 'error');
            return;
        }

        // Prepare form data - match EXACTLY with your backend expectations
        const formData = {
            patient_id: patientId,
            patient_name: document.getElementById('patient_name').value,
            patient_phone: document.getElementById('patient_phone').value,
            treatment_id: document.getElementById('treatment_id').value,
            appointment_date: document.getElementById('appointment_date').value,
            appointment_time: document.getElementById('appointment_time').value,
            gender: document.querySelector('input[name="gender"]:checked')?.value,
            message: document.querySelector('[name="message"]').value || ''
        };

        console.log("Form data to be submitted:", formData); // Debug log

        try {
            showLoader();
            console.log("Sending request to server..."); // Debug log
            
            const response = await axios.post('/book-appointment', formData, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            console.log("Server response:", response.data); // Debug log
            
            if (response.data.success) {
                showToast('Appointment booked successfully!', 'success');
                this.reset();
                resetPatientFields();
            } else {
                showToast(response.data.message || 'Booking failed', 'error');
            }
        } catch (error) {
            console.error("Full error details:", error); // Debug log
            console.error("Error response data:", error.response?.data); // Debug log
            
            let errorMsg = 'Booking failed. Please try again.';
            if (error.response?.data?.message) {
                errorMsg = error.response.data.message;
            } else if (error.response?.data?.errors) {
                errorMsg = Object.values(error.response.data.errors).flat().join('\n');
            }
            
            showToast(errorMsg, 'error');
        } finally {
            hideLoader();
        }
    });

    // Handle registration form submission
    document.getElementById('registration-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Registering...
            </span>
        `;

        try {
            const formData = new FormData(this);
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                closeRegistrationModal();
                showToast('Registration successful! Your Patient ID: ' + data.patient_id, 'success');
                
                // Auto-fill patient ID in appointment form
                const patientIdField = document.getElementById('patient-id');
                if (patientIdField) {
                    patientIdField.value = data.patient_id;
                    // Trigger fetch of patient details
                    fetchPatientDetails();
                }
            } else {
                showToast(data.message || 'Registration failed', 'error');
                
                // Show field-specific errors
                if (data.errors) {
                    Object.entries(data.errors).forEach(([field, messages]) => {
                        const input = this.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const errorDiv = input.nextElementSibling?.classList.contains('invalid-feedback') 
                                ? input.nextElementSibling
                                : document.createElement('div');
                            
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = messages[0];
                            input.parentNode.appendChild(errorDiv);
                        }
                    });
                }
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('An error occurred during registration', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Register';
        }
    });

    // Clear errors when user starts typing
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', () => {
            element.classList.remove('is-invalid');
            const errorDiv = element.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.classList.add('hidden');
            }
        });
    });
  </script>
</body>
</html>