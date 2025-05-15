

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 dark:text-gray-300">Appointment Reports</h1>

    <!-- Report Filter Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="<?php echo e(route('reports.appointments')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Report Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-chart-bar mr-2"></i>Report Type
                    </label>
                    <select name="report_type" id="report_type" 
                        class="w-full p-2.5 border border-gray-300 dark:border-gray-600 rounded-lg 
                        bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-300
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="daily" <?php echo e(request('report_type') == 'daily' ? 'selected' : ''); ?>>Daily Report</option>
                        <option value="monthly" <?php echo e(request('report_type') == 'monthly' ? 'selected' : ''); ?>>Monthly Report</option>
                        <option value="yearly" <?php echo e(request('report_type') == 'yearly' ? 'selected' : ''); ?>>Yearly Report</option>
                        <option value="treatment" <?php echo e(request('report_type') == 'treatment' ? 'selected' : ''); ?>>Treatment Type Report</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar mr-2"></i>Start Date
                    </label>
                    <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>"
                        class="w-full p-2.5 border border-gray-300 dark:border-gray-600 rounded-lg 
                        bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-300
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar mr-2"></i>End Date
                    </label>
                    <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>"
                        class="w-full p-2.5 border border-gray-300 dark:border-gray-600 rounded-lg 
                        bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-300
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                    class="px-6 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 
                    focus:ring-4 focus:ring-blue-300 transition duration-200
                    flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Generate Report
                </button>

                <a href="<?php echo e(route('reports.appointments.export', request()->query())); ?>" 
                    class="px-6 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 
                    focus:ring-4 focus:ring-green-300 transition duration-200
                    flex items-center gap-2">
                    <i class="fas fa-file-export"></i>
                    Export to Excel
                </a>

                <a href="<?php echo e(route('reports.appointments.pdf', request()->query())); ?>" 
                    class="px-6 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 
                    focus:ring-4 focus:ring-red-300 transition duration-200
                    flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i>
                    Export to PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Report Summary -->
    <?php if(isset($summary)): ?>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 dark:text-gray-300">Report Summary</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Total Appointments</h3>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-300"><?php echo e($summary['total_appointments']); ?></p>
            </div>
            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-green-800 dark:text-green-200">Completed</h3>
                <p class="text-2xl font-bold text-green-600 dark:text-green-300"><?php echo e($summary['completed']); ?></p>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Pending</h3>
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-300"><?php echo e($summary['pending']); ?></p>
            </div>
            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Cancelled</h3>
                <p class="text-2xl font-bold text-red-600 dark:text-red-300"><?php echo e($summary['cancelled']); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Report Data Table -->
    <?php if(isset($appointments)): ?>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left bg-gray-50 dark:bg-gray-700">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Patient</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Treatment</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                            <?php echo e($appointment->patient ? $appointment->patient->first_name . ' ' . $appointment->patient->last_name : 'N/A'); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                            <?php echo e($appointment->treatmentType ? $appointment->treatmentType->name : 'N/A'); ?>

                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php echo e($appointment->status === 'Completed' ? 'bg-green-100 text-green-800' : ''); ?>

                                <?php echo e($appointment->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                <?php echo e($appointment->status === 'Cancelled' ? 'bg-red-100 text-red-800' : ''); ?>">
                                <?php echo e($appointment->status); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                            ₱<?php echo e($appointment->treatmentType ? number_format($appointment->treatmentType->price, 2) : '0.00'); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No appointments found for the selected criteria.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/reports/appointments.blade.php ENDPATH**/ ?>