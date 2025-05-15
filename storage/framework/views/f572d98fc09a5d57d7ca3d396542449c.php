<?php $__env->startSection('content'); ?>
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Registered Patients
        </h2>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">Patient ID</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Gender</th>
                            <th class="px-4 py-3">Birth Date</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone</th>
                            <th class="px-4 py-3">Address</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm"><?php echo e($patient->patient_id); ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <?php echo e($patient->first_name); ?> <?php echo e($patient->middle_name); ?> <?php echo e($patient->last_name); ?>

                                </td>
                                <td class="px-4 py-3 text-sm"><?php echo e($patient->gender); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo e($patient->birth_date); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo e($patient->email); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo e($patient->phone); ?></td>
                                <td class="px-4 py-3 text-sm"><?php echo e($patient->address); ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <!-- View Button -->
                                    <a href="<?php echo e(route('patients.show_details', $patient->patient_id)); ?>" class="text-blue-600 dark:text-blue-400">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/patients/registered_patients.blade.php ENDPATH**/ ?>