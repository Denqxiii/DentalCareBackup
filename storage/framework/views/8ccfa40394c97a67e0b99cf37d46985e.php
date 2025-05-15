<?php $__env->startSection('content'); ?>
    <style>
        #toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 16px;
            border-radius: 4px;
            background-color: #48BB78;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        #toast.error {
            background-color: #F56565;
        }
    </style>
    
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                PATIENT'S REGISTRATION
            </h2>

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <?php if(session('success')): ?>
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('patients.store')); ?>">
                    <?php echo csrf_field(); ?>
                    
                    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">First Name</span>
                            <input name="first_name" value="<?php echo e(old('first_name')); ?>" required class="block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Middle Name</span>
                            <input name="middle_name" value="<?php echo e(old('middle_name')); ?>" class="block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Last Name</span>
                            <input name="last_name" value="<?php echo e(old('last_name')); ?>" required class="block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Birth Date</span>
                            <input type="date" name="birth_date" value="<?php echo e(old('birth_date')); ?>" required class="block mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
                        </label>

                        <div class="mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Gender</span>
                            <div class="mt-2">
                                <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                                    <input type="radio" name="gender" value="Male" <?php echo e(old('gender') == 'Male' ? 'checked' : ''); ?> required class="form-radio text-purple-600">
                                    <span class="ml-2">Male</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                                    <input type="radio" name="gender" value="Female" <?php echo e(old('gender') == 'Female' ? 'checked' : ''); ?> required class="form-radio text-purple-600">
                                    <span class="ml-2">Female</span>
                                </label>
                            </div>
                        </div>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Address</span>
                            <input name="address" value="<?php echo e(old('address')); ?>" required class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input" placeholder="Address">
                        </label>

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Email Address</span>
                            <input type="email" name="email" value="<?php echo e(old('email')); ?>" required class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input" placeholder="Email">
                        </label>   

                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Phone Number</span>
                            <input name="phone" value="<?php echo e(old('phone')); ?>" required class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input" placeholder="Phone Number">
                        </label>
                    </div>

                    <button 
                        type="submit" 
                        class="px-4 py-2 text-sm font-medium text-green-100 border bg-green-600 rounded-lg hover:bg-green-700 dark:text-white">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/register_patients.blade.php ENDPATH**/ ?>