

<?php $__env->startSection('content'); ?>
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Prescriptions
        </h2>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6">
            <a href="<?php echo e(route('admin.prescriptions.create')); ?>"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                <i class="fas fa-plus mr-2"></i>New Prescription
            </a>

            <!-- Search Form -->
            <form action="<?php echo e(route('admin.prescriptions.index')); ?>" method="GET" class="flex items-center">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    class="block w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="Search prescriptions...">
                <button type="submit"
                    class="ml-2 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Prescriptions Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Patient</th>
                            <th class="px-4 py-3">Medication</th>
                            <th class="px-4 py-3">Prescribed By</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Issued Date</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <?php $__empty_1 = true; $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold"><?php echo e($prescription->patient->first_name); ?> <?php echo e($prescription->patient->last_name); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <?php echo e($prescription->medication_name); ?>

                            </td>
                            <td class="px-4 py-3 text-sm">
                                <?php echo e($prescription->prescriber->name); ?>

                            </td>
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight rounded-full
                                    <?php if($prescription->status === 'active'): ?> bg-green-100 text-green-700
                                    <?php elseif($prescription->status === 'completed'): ?> bg-blue-100 text-blue-700
                                    <?php else: ?> bg-red-100 text-red-700 <?php endif; ?>">
                                    <?php echo e(ucfirst($prescription->status)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <?php echo e($prescription->issued_date->format('M d, Y')); ?>

                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center space-x-3">
                                    <a href="<?php echo e(route('admin.prescriptions.show', $prescription)); ?>"
                                        class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.prescriptions.edit', $prescription)); ?>"
                                        class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.prescriptions.print', $prescription)); ?>"
                                        class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.prescriptions.destroy', $prescription)); ?>" method="POST"
                                        class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Are you sure you want to delete this prescription?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-sm text-center text-gray-500">
                                No prescriptions found.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-4 py-3 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                <?php echo e($prescriptions->links()); ?>

            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/admin/prescriptions/index.blade.php ENDPATH**/ ?>