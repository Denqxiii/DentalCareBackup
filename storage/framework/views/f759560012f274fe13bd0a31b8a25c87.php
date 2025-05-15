<?php $__env->startSection('content'); ?>
    <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Dashboard Overview
            </h2>

            <!-- Stats Cards -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                <!-- Total Patients Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Patients
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            <?php echo e($totalPatients ?? 0); ?>

                        </p>
                    </div>
                </div>

                <!-- Today's Appointments Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <i class="fas fa-calendar-check text-xl"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Today's Appointments
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            <?php echo e($todayAppointments ?? 0); ?>

                        </p>
                    </div>
                </div>

                <!-- Pending Appointments Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Pending Appointments
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            <?php echo e($pendingAppointments ?? 0); ?>

                        </p>
                    </div>
                </div>

                <!-- Total Revenue Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                        <i class="fas fa-money-bill-wave text-xl"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Monthly Revenue
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            ₱<?php echo e(number_format($monthlyRevenue ?? 0, 2)); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity and Upcoming Appointments -->
            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <!-- Upcoming Appointments -->
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        Upcoming Appointments
                    </h4>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Patient</th>
                                    <th class="px-4 py-3">Time</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                <?php $__empty_1 = true; $__currentLoopData = $upcomingAppointments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <div>
                                                <p class="font-semibold"><?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->middle_name); ?> <?php echo e($appointment->patient->last_name); ?></p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                                    <?php echo e($appointment->treatmentType->name); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A')); ?>

                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        <span class="px-2 py-1 font-semibold leading-tight rounded-full 
                                            <?php if($appointment->status === 'Pending'): ?> bg-yellow-100 text-yellow-700
                                            <?php elseif($appointment->status === 'Completed'): ?> bg-green-100 text-green-700
                                            <?php else: ?> bg-red-100 text-red-700 <?php endif; ?>">
                                            <?php echo e($appointment->status); ?>

                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-sm text-center text-gray-500">
                                        No upcoming appointments
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        Recent Activities
                    </h4>
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $recentActivities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center space-x-4">
                            <div class="p-2 rounded-full 
                                <?php if($activity->type === 'appointment'): ?> bg-blue-100 text-blue-500
                                <?php elseif($activity->type === 'payment'): ?> bg-green-100 text-green-500
                                <?php else: ?> bg-gray-100 text-gray-500 <?php endif; ?>">
                                <i class="fas 
                                    <?php if($activity->type === 'appointment'): ?> fa-calendar-check
                                    <?php elseif($activity->type === 'payment'): ?> fa-money-bill
                                    <?php else: ?> fa-info-circle <?php endif; ?>">
                                </i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <?php echo e($activity->description); ?>

                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    <?php echo e($activity->created_at->diffForHumans()); ?>

                                </p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-500 text-center">
                            No recent activities
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
                <a href="<?php echo e(route('patients.create')); ?>" class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <i class="fas fa-user-plus text-xl"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Register New Patient
                        </p>
                    </div>
                </a>

                <a href="<?php echo e(route('admin.payments.create')); ?>" class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
                        <i class="fas fa-money-bill text-xl"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Record Payment
                        </p>
                    </div>
                </a>

                <a href="<?php echo e(route('admin.reports.index')); ?>" class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <i class="fas fa-chart-bar text-xl"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            View Reports
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/dashboard.blade.php ENDPATH**/ ?>