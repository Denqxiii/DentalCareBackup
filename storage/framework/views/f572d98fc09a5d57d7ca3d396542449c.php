

<?php $__env->startSection('content'); ?>
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Registered Patients
        </h2>

        <div class="w-full overflow-hidden rounded-lg shadow-md bg-white dark:bg-gray-800">
            <div class="w-full overflow-x-auto">
                <table class="w-full table-auto whitespace-nowrap">
                    <thead class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Patient ID</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Gender</th>
                            <th class="px-4 py-3">Birth Date</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone</th>
                            <th class="px-4 py-3">Address</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-sm">
                        <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                <td class="px-4 py-3"><?php echo e($patient->patient_id); ?></td>
                                <td class="px-4 py-3">
                                    <?php echo e($patient->first_name); ?> <?php echo e($patient->middle_name); ?> <?php echo e($patient->last_name); ?>

                                </td>
                                <td class="px-4 py-3"><?php echo e($patient->gender); ?></td>
                                <td class="px-4 py-3">
                                    <?php echo e(\Carbon\Carbon::parse($patient->birth_date)->format('F d, Y')); ?>

                                </td>
                                <td class="px-4 py-3"><?php echo e($patient->email); ?></td>
                                <td class="px-4 py-3"><?php echo e($patient->phone); ?></td>
                                <td class="px-4 py-3"><?php echo e($patient->address); ?></td>
                                <td class="px-4 py-3 text-center">
                                    <a href="<?php echo e(route('patients.show_details', $patient->patient_id)); ?>"
                                    class="inline-block text-gray-600 hover:text-blue-600 transition"
                                    title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    No patients found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Optional Pagination -->
        <?php if(method_exists($patients, 'links')): ?>
        <div class="mt-6">
            <?php echo e($patients->links('pagination::tailwind')); ?>

        </div>
        <?php endif; ?>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/patients/registered_patients.blade.php ENDPATH**/ ?>