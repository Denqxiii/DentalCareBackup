<!-- resources/views/reports/treatment_report.blade.php -->


<?php $__env->startSection('content'); ?>
<div class="container px-6 mx-auto grid" x-data="{ dark: false }" x-init="dark = document.documentElement.classList.contains('dark')">
    <!-- Page Header -->
    <div class="flex items-center justify-between my-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 transition-colors duration-200">
            Treatment Reports
        </h2>
        <div class="flex space-x-3">
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple transform hover:scale-105 transition-transform dark:bg-purple-500 dark:hover:bg-purple-600 dark:active:bg-purple-700">
                <i class="fas fa-print mr-2 text-white"></i>Print Report
            </button>
            <a href="<?php echo e(route('reports.treatment_report')); ?>?export=excel" class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-100 dark:text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green transform hover:scale-105 transition-transform dark:bg-green-500 dark:hover:bg-green-600 dark:active:bg-green-700">
                <i class="fas fa-file-excel mr-2 text-gray-100 dark:text-white"></i>Export Excel
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="px-6 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 transition-all duration-300 hover:shadow-lg dark:shadow-gray-700">
        <form action="<?php echo e(route('reports.treatment_report')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-200">
                    Start Date
                </label>
                <div class="relative">
                    <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>"
                        class="block w-full px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:border-purple-400 transition-colors duration-200">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-calendar text-gray-400 dark:text-gray-500 transition-colors duration-200"></i>
                    </div>
                </div>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-200">
                    End Date
                </label>
                <div class="relative">
                    <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>"
                        class="block w-full px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:border-purple-400 transition-colors duration-200">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-calendar text-gray-400 dark:text-gray-500 transition-colors duration-200"></i>
                    </div>
                </div>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-200">
                    Treatment Type
                </label>
                <div class="relative">
                    <select name="treatment_type" 
                        class="block w-full px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:focus:border-purple-400 transition-colors duration-200 appearance-none">
                        <option value="">All Types</option>
                        <option value="Cleaning" <?php echo e(request('treatment_type') == 'Cleaning' ? 'selected' : ''); ?>>Cleaning</option>
                        <option value="Filling" <?php echo e(request('treatment_type') == 'Filling' ? 'selected' : ''); ?>>Filling</option>
                        <option value="Extraction" <?php echo e(request('treatment_type') == 'Extraction' ? 'selected' : ''); ?>>Extraction</option>
                        <option value="Root Canal" <?php echo e(request('treatment_type') == 'Root Canal' ? 'selected' : ''); ?>>Root Canal</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400 dark:text-gray-500 transition-colors duration-200"></i>
                    </div>
                </div>
            </div>
            <div class="flex items-end space-x-3">
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple transform hover:scale-105 transition-transform dark:bg-purple-500 dark:hover:bg-purple-600 dark:active:bg-purple-700">
                    <i class="fas fa-filter mr-2 text-white"></i>Filter
                </button>
                <a href="<?php echo e(route('reports.treatment_report')); ?>" 
                    class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-100 dark:text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray transform hover:scale-105 transition-transform dark:bg-gray-500 dark:hover:bg-gray-600 dark:active:bg-gray-700">
                    <i class="fas fa-redo mr-2 text-gray-100 dark:text-white"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Total Treatments -->
        <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800 transform hover:scale-105 transition-transform">
            <div class="p-4 flex items-center">
                <div class="p-3 rounded-full text-orange-500 bg-orange-100 mr-4 dark:text-orange-100 dark:bg-orange-500 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors duration-200">
                        Total Treatments
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 transition-colors duration-200">
                        <?php echo e($treatments->count()); ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- Completed Treatments -->
        <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800 transform hover:scale-105 transition-transform">
            <div class="p-4 flex items-center">
                <div class="p-3 rounded-full text-green-500 bg-green-100 mr-4 dark:text-green-100 dark:bg-green-500 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors duration-200">
                        Completed
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 transition-colors duration-200">
                        <?php echo e($treatments->where('status', 'Completed')->count()); ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- Pending Treatments -->
        <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800 transform hover:scale-105 transition-transform">
            <div class="p-4 flex items-center">
                <div class="p-3 rounded-full text-yellow-500 bg-yellow-100 mr-4 dark:text-yellow-100 dark:bg-yellow-500 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors duration-200">
                        Pending
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 transition-colors duration-200">
                        <?php echo e($treatments->where('status', 'Pending')->count()); ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- Cancelled Treatments -->
        <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800 transform hover:scale-105 transition-transform">
            <div class="p-4 flex items-center">
                <div class="p-3 rounded-full text-red-500 bg-red-100 mr-4 dark:text-red-100 dark:bg-red-500 transition-colors duration-200">
                    <svg class="w-5 h-5 text-red-500 dark:text-red-100" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors duration-200">
                        Cancelled
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200 transition-colors duration-200">
                        <?php echo e($treatments->where('status', 'Cancelled')->count()); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Treatments Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800 transition-colors duration-200">
                        <th class="px-4 py-3">Patient</th>
                        <th class="px-4 py-3">Treatment Type</th>
                        <th class="px-4 py-3">Procedure Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 transition-colors duration-200">
                    <?php $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                    <div class="absolute inset-0 rounded-full shadow-inner bg-gray-100 dark:bg-gray-700 transition-colors duration-200"></div>
                                    <div class="flex items-center justify-center h-full text-gray-600 dark:text-gray-300 transition-colors duration-200">
                                        <?php echo e(substr($treatment->patient->name, 0, 1)); ?>

                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold"><?php echo e($treatment->patient->first_name); ?> <?php echo e($treatment->patient->middle_name); ?> <?php echo e($treatment->patient->last_name); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <?php echo e($treatment->treatment_type); ?>

                        </td>
                        <td class="px-4 py-3 text-sm">
                            <?php echo e(\Carbon\Carbon::parse($treatment->procedure_date)->format('M d, Y')); ?>

                        </td>
                        <td class="px-4 py-3 text-xs">
                            <?php if($treatment->status == 'Completed'): ?>
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100 transition-colors duration-200">
                                    <i class="fas fa-check-circle mr-1"></i>Completed
                                </span>
                            <?php elseif($treatment->status == 'Pending'): ?>
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100 transition-colors duration-200">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            <?php else: ?>
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100 transition-colors duration-200">
                                    <i class="fas fa-times-circle mr-1"></i>Cancelled
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <a href="<?php echo e(route('treatments.show', $treatment->id)); ?>" 
                               class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i>View Details
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800 transition-colors duration-200">
            <span class="flex items-center col-span-3">
                <?php if($treatments instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                    Showing <?php echo e($treatments->firstItem()); ?> - <?php echo e($treatments->lastItem()); ?> of <?php echo e($treatments->total()); ?>

                <?php else: ?>
                    Total Records: <?php echo e($treatments->count()); ?>

                <?php endif; ?>
            </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <?php if($treatments instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                    <?php echo e($treatments->links()); ?>

                <?php endif; ?>
            </span>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* Custom styles for inputs and buttons */
    input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0;
        cursor: pointer;
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
    }

    select {
        background-image: none !important;
    }

    /* Hover effects for inputs */
    input:hover, select:hover {
        border-color: #9f7aea;
    }

    /* Focus effects for inputs */
    input:focus, select:focus {
        box-shadow: 0 0 0 3px rgba(159, 122, 234, 0.2);
    }

    /* Dark mode focus effects */
    .dark input:focus, .dark select:focus {
        box-shadow: 0 0 0 3px rgba(159, 122, 234, 0.3);
    }

    /* Button hover effects */
    button:hover, a:hover {
        transform: translateY(-1px);
    }

    /* Dark mode transitions */
    .dark .transition-colors {
        transition-property: background-color, border-color, color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    /* Dark mode shadows */
    .dark .shadow-md {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    }

    .dark .hover\:shadow-lg:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
    }

    /* Print styles */
    @media print {
        .no-print {
            display: none;
        }
        .container {
            width: 100%;
            max-width: 100%;
            padding: 0;
            margin: 0;
        }
        /* Force light mode for printing */
        .dark * {
            color: #000 !important;
            background-color: #fff !important;
            border-color: #ddd !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/reports/treatment_report.blade.php ENDPATH**/ ?>