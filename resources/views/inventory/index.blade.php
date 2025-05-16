@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Inventory Management</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Track and manage your inventory items</p>
            </div>
            <a href="{{ route('inventory.create') }}" 
                class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 focus:ring-4 focus:ring-green-300 focus:outline-none transition-all shadow-md hover:shadow-lg"
                role="button" aria-label="Add New Inventory">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Item
            </a>
        </div>

        <!-- Search & Filter Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 mb-8">
            <form method="GET" action="{{ route('inventory.index') }}" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-12 sm:gap-4">
                <!-- Search Input -->
                <div class="sm:col-span-6 lg:col-span-4 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search items..."
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 placeholder-gray-400 dark:placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                        aria-label="Search inventory items">
                </div>

                <!-- Category Filter -->
                <div class="sm:col-span-4 lg:col-span-3">
                    <select name="category" class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <option value="">All Categories</option>
                        <option value="dental" {{ request('category') === 'dental' ? 'selected' : '' }}>Dental</option>
                        <option value="hygiene" {{ request('category') === 'hygiene' ? 'selected' : '' }}>Hygiene</option>
                        <option value="tools" {{ request('category') === 'tools' ? 'selected' : '' }}>Tools</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="sm:col-span-2 flex gap-2">
                    <button type="submit" class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                        Filter
                    </button>
                    <a href="{{ route('inventory.index') }}" 
                       class="flex items-center justify-center px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all"
                       role="button" aria-label="Reset filters">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                       </svg>
                    </a>
                </div>
            </form>
        </div>

        <!-- Inventory Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($inventoryItems as $item)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100 dark:border-gray-700">
                    <!-- Card Header -->
                    <div class="flex justify-between items-start p-4 pb-2 relative">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ $item->item_name }}</h3>
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full mt-1 
                                @if($item->quantity_in_stock < 10) bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @elseif($item->quantity_in_stock < 20) bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                {{ $item->quantity_in_stock }} in stock
                            </span>
                        </div>
                        
                        <!-- Dropdown Menu - Wrapper div moved outside card boundaries -->
                        <div class="relative">
                            <button type="button" data-dropdown-toggle
                                class="p-1.5 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all"
                                aria-label="Item actions">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Dropdown Menu - Now positioned outside card container -->
                    <div class="absolute z-50 mt-1 w-56 origin-top-right bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none divide-y divide-gray-100 dark:divide-gray-700 hidden transition-all duration-100 transform opacity-0 scale-95"
                        data-dropdown-menu style="position: absolute; right: 0; margin-top: 0;">
                        <div class="py-1">
                            <a href="{{ route('stock-movements.create', ['inventory_id' => $item->id, 'movement_type' => 'in']) }}" 
                            class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Stock In
                            </a>
                            <a href="{{ route('stock-movements.create', ['inventory_id' => $item->id, 'movement_type' => 'out']) }}" 
                            class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                                Stock Out
                            </a>
                            <a href="{{ route('stock-movements.create', ['inventory_id' => $item->id, 'movement_type' => 'adjustment']) }}" 
                            class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Adjust Stock
                            </a>
                        </div>
                        <div class="py-1">
                            <a href="#" 
                            class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Item
                            </a>
                            <button type="button" 
                                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 pt-0">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</span>
                            <span class="text-sm text-gray-900 dark:text-white capitalize">{{ $item->category }}</span>
                        </div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">₱{{ number_format($item->price_per_unit, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $item->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No inventory items</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding a new inventory item.</p>
                    <div class="mt-6">
                        <a href="{{ route('inventory.create') }}" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            New Item
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($inventoryItems->hasPages())
        <div class="mt-8">
            {{ $inventoryItems->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Dropdown Toggle Script with Animation -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('[data-dropdown-toggle]');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation();
                const card = this.closest('.bg-white, .dark\\:bg-gray-800'); // Find parent card
                const dropdown = card.querySelector('[data-dropdown-menu]');
                
                // Close all other dropdowns
                document.querySelectorAll('[data-dropdown-menu]').forEach(d => {
                    if (d !== dropdown) {
                        d.classList.add('hidden');
                        d.classList.remove('opacity-100', 'scale-100');
                        d.classList.add('opacity-0', 'scale-95');
                    }
                });

                // Calculate position relative to viewport
                const buttonRect = this.getBoundingClientRect();
                
                // Position the dropdown absolutely in the document
                dropdown.style.position = 'fixed';
                dropdown.style.top = `${buttonRect.bottom + window.scrollY}px`;
                dropdown.style.left = `${buttonRect.right - dropdown.offsetWidth + window.scrollX}px`;

                // Toggle current dropdown
                if (dropdown.classList.contains('hidden')) {
                    dropdown.classList.remove('hidden');
                    setTimeout(() => {
                        dropdown.classList.remove('opacity-0', 'scale-95');
                        dropdown.classList.add('opacity-100', 'scale-100');
                    }, 20);
                } else {
                    dropdown.classList.remove('opacity-100', 'scale-100');
                    dropdown.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        dropdown.classList.add('hidden');
                    }, 150);
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function () {
            document.querySelectorAll('[data-dropdown-menu]').forEach(dropdown => {
                dropdown.classList.remove('opacity-100', 'scale-100');
                dropdown.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 150);
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            document.querySelectorAll('[data-dropdown-menu]').forEach(dropdown => {
                if (!dropdown.classList.contains('hidden')) {
                    const button = dropdown.previousElementSibling;
                    const buttonRect = button.getBoundingClientRect();
                    
                    dropdown.style.top = `${buttonRect.bottom + window.scrollY}px`;
                    dropdown.style.left = `${buttonRect.right - dropdown.offsetWidth + window.scrollX}px`;
                }
            });
        });
    });
</script>
@endsection