<?php $__env->startSection('content'); ?>
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        <!-- Cards -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Total Patients -->
            <div class="flex items-center p-5 bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </div>
                <div class="w-full">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Patients</p>
                    <div class="flex items-center justify-between">
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-200"><?php echo e($totalPatients); ?></p>
                        <div class="flex items-center text-green-500 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 10l5-5 5 5H5z" clip-rule="evenodd" />
                            </svg>
                            <span><?php echo e($patientsPercent ?? '0'); ?>%</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Since last month</p>
                </div>
            </div>

            <!-- Total Appointments -->
            <div class="flex items-center p-5 bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="w-full">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Appointments</p>
                    <div class="flex items-center justify-between">
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-200"><?php echo e($totalAppointments); ?></p>
                        <div class="flex items-center text-red-500 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 10l5 5 5-5H5z" clip-rule="evenodd" />
                            </svg>
                            <span><?php echo e($appointmentsPercent); ?>%</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Compared to last month</p>
                </div>
            </div>

            <!-- Completed Treatments -->
            <div class="flex items-center p-5 bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </div>
                <div class="w-full">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Completed Treatments</p>
                    <div class="flex items-center justify-between">
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-200"><?php echo e($completedTreatments); ?></p>
                        <div class="flex items-center text-green-500 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 10l5-5 5 5H5z" clip-rule="evenodd" />
                            </svg>
                            <span><?php echo e($completedPercent); ?>%</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">This month</p>
                </div>
            </div>

            <!-- New Patients -->
            <div class="flex items-center p-5 bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="p-3 mr-4 text-pink-500 bg-pink-100 rounded-full dark:text-pink-100 dark:bg-pink-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </div>
                <div class="w-full">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">New Patients</p>
                    <div class="flex items-center justify-between">
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-200"><?php echo e($newPatients); ?></p>
                        <div class="flex items-center text-green-500 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 10l5-5 5 5H5z" clip-rule="evenodd" />
                            </svg>
                            <span><?php echo e($newPatientsPercent); ?>%</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">This month</p>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointment (Bigger Card) -->
        <div class="mb-10">
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-xl font-bold text-blue-700 mb-4">Upcoming Appointments</h3>

                <?php if(is_countable($upcomingAppointments) && count($upcomingAppointments) > 0): ?>
                    <ul class="space-y-4">
                        <?php $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <?php echo e($appointment->appointment_date->format('M d, Y h:i A')); ?> - 
                                <?php if($appointment->patient): ?>
                                    <?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?>

                                <?php else: ?>
                                    <span class="text-red-500">Patient info missing</span>
                                <?php endif; ?>
                                - 
                                <?php echo e($appointment->service->name ?? 'No Service'); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">No upcoming appointments.</p>
                <?php endif; ?>
            </div>
        </div>


        <!-- Recent Activity (Bigger Card) -->
        <div class="mb-10">
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Activities</h3>

                <?php if(!empty($activities) && count($activities) > 0): ?>
                    <ul class="space-y-3">
                        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-start gap-3">
                                <div class="w-2 h-2 mt-2 rounded-full bg-blue-600"></div>
                                <div>
                                    <p class="text-gray-700"><?php echo e($activity->description); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo e($activity->created_at->diffForHumans()); ?></p>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">No recent activities to show.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/dashboard.blade.php ENDPATH**/ ?>