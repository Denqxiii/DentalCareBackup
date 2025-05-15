

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight mb-4 text-gray-800 dark:text-gray-100">Inventory List</h2>

        <!-- Search & Filter Form -->
        <form method="GET" action="<?php echo e(route('inventory.index')); ?>" class="flex flex-col md:flex-row gap-4 mb-6">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                placeholder="Search item name..."
                class="w-full md:w-1/2 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring focus:ring-purple-200 dark:bg-gray-800 dark:text-white">

            <select name="category" class="w-full md:w-1/4 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring focus:ring-purple-200 dark:bg-gray-800 dark:text-white">
                <option value="">All Categories</option>
                <option value="dental" <?php echo e(request('category') === 'dental' ? 'selected' : ''); ?>>Dental</option>
                <option value="hygiene" <?php echo e(request('category') === 'hygiene' ? 'selected' : ''); ?>>Hygiene</option>
                <option value="tools" <?php echo e(request('category') === 'tools' ? 'selected' : ''); ?>>Tools</option>
                <!-- Add more categories as needed -->
            </select>

            <button type="submit"
                class="px-4 py-2 text-sm font-medium text-green-100 border bg-green-600 rounded-lg hover:bg-green-700 dark:text-white">Filter</button>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Item Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100"><?php echo e($item->item_name); ?></td>
                            <td class="px-6 py-4 capitalize text-gray-900 dark:text-gray-100"><?php echo e($item->category); ?></td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100"><?php echo e($item->quantity_in_stock); ?></td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">₱<?php echo e(number_format($item->price_per_unit, 2)); ?></td>
                            <td class="px-6 py-4">
                                <a href="<?php echo e(route('stock-movements.create', ['inventory_id' => $item->id, 'movement_type' => 'in'])); ?>"
                                    class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">Stock In</a> |
                                <a href="<?php echo e(route('stock-movements.create', ['inventory_id' => $item->id, 'movement_type' => 'out'])); ?>"
                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Stock Out</a> |
                                <a href="<?php echo e(route('stock-movements.create', ['inventory_id' => $item->id, 'movement_type' => 'adjustment'])); ?>"
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">Adjust Stock</a> |
                                <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">Edit</a> |
                                <a href="#" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No inventory items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/inventory/inventory.blade.php ENDPATH**/ ?>