@extends('layouts.app')

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Patient Registration
            </h2>

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

                <!-- Error Messages Placeholder -->
                <div id="toast" style="display:none;">Success! Patient Registered.</div>

                <form id="registration-form" method="POST" action="{{ route('patients.store') }}">
                    @csrf  {{-- Protects against CSRF attacks --}}
                    
                    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">First Name</span>
                            <input name="first_name" class="block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Middle Name</span>
                            <input name="middle_name" class="block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Last Name</span>
                            <input name="last_name" class="block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Birth Date</span>
                            <input type="date" name="birth_date" class="block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
                        </label>

                        <div class="mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Gender</span>
                            <div class="mt-2">
                                <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                                    <input type="radio" name="gender" value="Male" class="form-radio text-purple-600">
                                    <span class="ml-2">Male</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                                    <input type="radio" name="gender" value="Female" class="form-radio text-purple-600">
                                    <span class="ml-2">Female</span>
                                </label>
                            </div>
                        </div>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Address</span>
                            <input name="address" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input" placeholder="Address">
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Email Address</span>
                            <input type="email" name="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input" placeholder="Email">
                        </label>   

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Phone Number</span>
                            <input name="phone" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input" placeholder="Phone Number">
                        </label>
                    </div>

                    <button 
                        type="submit" 
                        class="px-4 py-2 text-sm font-medium text-green-100 border  bg-green-600 rounded-lg hover:bg-green-700 dark:text-white">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById('registration-form'); // Get form by ID

            form.addEventListener("submit", function (event) {
                event.preventDefault(); // Prevent default form submission (page reload)

                const formData = new FormData(form); // Gather form data

                // Perform the AJAX request using fetch()
                fetch("{{ route('patients.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector("input[name=_token]").value
                    }
                })
                .then(response => response.json()) // Parse JSON response
                .then(data => {
                    if (data.status === "success") {
                        // Display success message via Toast or alert
                        showToast("Patient registered successfully!");
                        form.reset(); // Reset form fields

                        // Optionally, redirect to another page
                        // window.location.replace("{{ route('patients.index') }}");
                    } else {
                        // Handle error
                        showToast("Error occurred! Please try again.");
                    }
                })
                .catch(error => {
                    // Log and display unexpected errors
                    console.error("Error:", error);
                    showToast("An unexpected error occurred.");
                });
            });

            // Toast function to show success/error messages
            function showToast(message) {
                const toast = document.getElementById('toast');
                toast.innerHTML = message; // Set the message
                toast.style.display = 'block'; // Show the toast
                setTimeout(() => {
                    toast.style.display = 'none'; // Hide the toast after 3 seconds
                }, 3000);
            }
        });
    </script>
@endsection

