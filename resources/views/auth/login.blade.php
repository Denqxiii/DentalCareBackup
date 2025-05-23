<!DOCTYPE html>
<html :class="{ 'theme-white': white }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Dental Care Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
  </head>
  <body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <!-- Left Side: Image -->
          <div class="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              class="object-cover w-full h-full dark:hidden"
              src="{{ asset('assets/img/login-office.jpeg') }}"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="{{ asset('assets/img/login-office-dark.jpeg') }}"
              alt="Office"
            />
          </div>
          <!-- Right Side: Form -->
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                Login
              </h1>
              <!-- Login Form -->
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Field -->
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Email</span>
                  <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                           focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                           dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="johndoe@example.com"
                  />
                </label>
                @error('email')
                  <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror

                <!-- Password Field -->
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Password</span>
                  <input
                    type="password"
                    name="password"
                    required
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                           focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                           dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="***************"
                  />
                </label>
                @error('password')
                  <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror

                <!-- Submit Button -->
                <button
                  type="submit"
                  class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white 
                         transition-colors duration-150 bg-purple-600 border border-transparent 
                         rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                  Log in
                </button>
              </form>
              <!-- End Login Form -->

              <hr class="my-8" />
              <!-- Link to Forgot Password and Register -->
              <p class="mt-4 mb-4">
                <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" 
                   href="{{ route('password.request') }}">
                  Forgot your password?
                </a>
              </p>
              <p class="mt-1">
                <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" 
                   href="{{ route('register') }}">
                  Create account
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>