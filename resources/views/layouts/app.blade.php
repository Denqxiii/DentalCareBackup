<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dental Care</title>
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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
    />
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
      defer
    ></script>
    <script src="{{ asset('assets/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('assets/js/charts-pie.js') }}" defer></script>
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
      <!-- Desktop Sidebar -->
      <aside
        class="fixed inset-y-0 z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block shadow-lg"
      >
        <div class="py-6 px-6 flex flex-col h-full">
          <!-- Logo -->
          <a
            href="{{ route('dashboard') }}"
            class="mb-8 flex items-center space-x-3 text-gray-900 dark:text-white font-bold text-xl tracking-wide"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8 text-purple-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M9 12h6m-3-3v6m6 3v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2a6 6 0 0112 0z"
              />
            </svg>
            <span>Dental Care</span>
          </a>

          <!-- Navigation Menu -->
          <nav class="flex flex-col space-y-1 flex-grow">
            <!-- Dashboard -->
            <a
              href="{{ route('dashboard') }}"
              @class([
                "flex items-center px-4 py-3 rounded-lg transition-colors duration-200",
                "bg-purple-600 text-white" => request()->routeIs('dashboard'),
                "text-gray-700 dark:text-gray-300 hover:bg-purple-100 hover:text-purple-700 dark:hover:bg-gray-800 dark:hover:text-purple-400" => !request()->routeIs('dashboard'),
              ])
              aria-current="{{ request()->routeIs('dashboard') ? 'page' : false }}"
            >
              <svg
                class="w-5 h-5 mr-3"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                />
              </svg>
              <span class="ml-4">Dashboard</span>
            </a>

            <!-- Patient Management -->
            <div
              x-data="{ open: {{ request()->routeIs('register_patients') || request()->routeIs('patients.index') || request()->routeIs('patients.history') ? 'true' : 'false' }} }"
              class="relative"
            >
              <button
                @click="open = !open"
                class="flex items-center justify-between w-full px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-purple-100 hover:text-purple-700 dark:hover:bg-gray-800 dark:hover:text-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-600"
                aria-haspopup="true"
                :aria-expanded="open.toString()"
              >
                <span class="flex items-center">
                  <svg
                    class="w-5 h-5 mr-3"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                  >
                    <path
                      d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
                    />
                  </svg>
                  <span class="ml-4">Patient Management</span>
                </span>
                <svg
                  :class="{ 'transform rotate-180': open }"
                  class="w-4 h-4 transition-transform duration-300"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  aria-hidden="true"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
              <ul
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 max-h-0"
                x-transition:enter-end="opacity-100 max-h-40"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 max-h-40"
                x-transition:leave-end="opacity-0 max-h-0"
                class="pl-12 mt-2 space-y-1 text-sm text-gray-600 dark:text-gray-400"
                aria-label="submenu"
              >
                <li>
                  <a
                    href="{{ route('register_patients') }}"
                    class="block px-3 py-2 rounded hover:bg-purple-100 hover:text-purple-700 dark:hover:bg-gray-800 dark:hover:text-purple-400"
                  >
                    Registration
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('patients.index') }}"
                    class="block px-3 py-2 rounded hover:bg-purple-100 hover:text-purple-700 dark:hover:bg-gray-800 dark:hover:text-purple-400"
                  >
                    Registered
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('patients.history') }}"
                    class="block px-3 py-2 rounded hover:bg-purple-100 hover:text-purple-700 dark:hover:bg-gray-800 dark:hover:text-purple-400"
                  >
                    History
                  </a>
                </li>
              </ul>
            </div>

            <!-- Appointments -->
            <a
              href="{{ route('admin.appointments.index') }}"
              @class([
                "flex items-center px-4 py-3 rounded-lg transition-colors duration-200",
                "bg-purple-600 text-white" => request()->routeIs('admin.appointments.index'),
                "text-gray-700 dark:text-gray-300 hover:bg-purple-100 hover:text-purple-700 dark:hover:bg-gray-800 dark:hover:text-purple-400" => !request()->routeIs('admin.appointments.index'),
              ])
              aria-current="{{ request()->routeIs('admin.appointments.index') ? 'page' : false }}"
            >
              <svg
                class="w-5 h-5 mr-3"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path d="M3 7h18M3 12h18M3 17h18" />
              </svg>
              <span class="ml-4">Appointments</span>
            </a>

            <!-- Inventory -->
            <a
              href="{{ route('inventory.index') }}"
              @class([
                "flex items-center px-4 py-3 rounded-lg transition-colors duration-200",
                "bg-purple-600 text-white" => request()->routeIs('inventory.index'),
                "text-gray-700 dark:text-gray-300 hover:bg-purple-100 hover:text-purple-700 dark:hover:bg-gray-800 dark:hover:text-purple-400" => !request()->routeIs('inventory.index'),
              ])
              aria-current="{{ request()->routeIs('inventory.index') ? 'page' : false }}"
            >
              <svg
                class="w-5 h-5 mr-3"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path
                  d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
                />
                <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
              </svg>
              <span class="ml-4">Inventory</span>
            </a>

            <!-- Reports -->
            <a
              href="{{ route('reports.index') }}"
              @class([
                "flex items-center px-4 py-3 rounded-lg transition-colors duration-200",
                "bg-purple-600 text-white" => request()->routeIs('reports.index'),
                "text-gray-700 dark:text-gray-300 hover:bg-purple-100 hover:text-purple-700 dark:hover:bg-gray-800 dark:hover:text-purple-400" => !request()->routeIs('reports.index'),
              ])
              aria-current="{{ request()->routeIs('reports.index') ? 'page' : false }}"
            >
              <svg
                class="w-5 h-5 mr-3"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path d="M9 17v-6a2 2 0 012-2h3" />
                <path d="M12 3v4m0 0v4m0-4h4m-4 0H8" />
              </svg>
              <span class="ml-4">Reports</span>
            </a>
          </nav>

          <!-- Logout -->
          <div class="mt-auto pt-6 border-t border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button
                type="submit"
                class="w-full flex items-center justify-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-red-100 hover:text-red-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 transition"
              >
                <svg
                  class="w-5 h-5 mr-3 text-red-600"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
                  <path d="M7 16v-1a4 4 0 014-4h6" />
                </svg>
                Logout
              </button>
            </form>
          </div>
        </div>
      </aside>

      <!-- Main Content -->
      <div class="flex flex-col flex-1 w-full">
        <header class="z-10 py-4"></header>
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
          @yield('content')
        </div>
      </div>
    </div>
  </body>
</html>
