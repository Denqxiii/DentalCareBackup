<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-3xl font-bold leading-tight mb-6 text-gray-900 dark:text-white">Inventory List</h2>

        <!-- Search & Filter Form -->
        <form method="GET" action="<?php echo e(route('inventory.index')); ?>" 
              class="flex flex-col md:flex-row items-center gap-4 mb-8"
              role="search" aria-label="Inventory Search and Filter">
            
            <div class="relative w-full md:w-1/2">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    placeholder="Search item name..."
                    class="w-full pl-10 pr-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-purple-500 focus:outline-none dark:bg-gray-800 dark:text-white"
                    aria-label="Search item name">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 dark:text-gray-300 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>

            <select name="category" class="w-full md:w-1/4 px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-purple-500 focus:outline-none dark:bg-gray-800 dark:text-white" aria-label="Filter by category">
                <option value="">All Categories</option>
                <option value="dental" <?php echo e(request('category') === 'dental' ? 'selected' : ''); ?>>Dental</option>
                <option value="hygiene" <?php echo e(request('category') === 'hygiene' ? 'selected' : ''); ?>>Hygiene</option>
                <option value="tools" <?php echo e(request('category') === 'tools' ? 'selected' : ''); ?>>Tools</option>
            </select>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:ring-4 focus:ring-purple-300 focus:outline-none transition">
                    Filter
                </button>
                <a href="<?php echo e(route('inventory.index')); ?>" 
                   class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:ring-4 focus:ring-gray-400 focus:outline-none transition"
                   role="button" aria-label="Reset filters">
                   Reset
                </a>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg shadow border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" role="table" aria-label="Inventory items">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Item Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-purple-50 dark:hover:bg-purple-900 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100 font-medium"><?php echo e($item->item_name); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize text-gray-700 dark:text-gray-300"><?php echo e($item->category); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300"><?php echo e($item->quantity_in_stock); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">₱<?php echo e(number_format($item->price_per_unit, 2)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap flex flex-wrap gap-2">
                            <a href="<?php echo e(route('stock-movements.create', ['inventory_id' => $item->id, 'movement_type' => 'in'])); ?>"
                               class="px-3 py-1 text-green-700 bg-green-100 rounded-md hover:bg-green-200 focus:ring-2 focus:ring-green-400 focus:outline-none transition" 
                               title="Add stock" aria-label="Stock In for <?php echo e($item->item_name); ?>">
                               Stock In
                            </a>
                            <a href="<?php echo e(route('stock-movements.create', ['inventory_id' => $item->id, 'movement_type' => 'out'])); ?>"
                               class="px-3 py-1 text-red-700 bg-red-100 rounded-md hover:bg-red-200 focus:ring-2 focus:ring-red-400 focus:outline-none transition" 
                               title="Remove stock" aria-label="Stock Out for <?php echo e($item->item_name); ?>">
                               Stock Out
                            </a>
                            <a href="<?php echo e(route('stock-movements.create', ['inventory_id' => $item->id, 'movement_type' => 'adjustment'])); ?>"
                               class="px-3 py-1 text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 focus:ring-2 focus:ring-blue-400 focus:outline-none transition" 
                               title="Adjust stock quantity" aria-label="Adjust Stock for <?php echo e($item->item_name); ?>">
                               Adjust Stock
                            </a>
                            <a href="#"
                               class="px-3 py-1 text-indigo-700 bg-indigo-100 rounded-md hover:bg-indigo-200 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                               title="Edit item" aria-label="Edit <?php echo e($item->item_name); ?>">
                               Edit
                            </a>
                            <button type="button"
                                    class="px-3 py-1 text-red-700 bg-red-100 rounded-md hover:bg-red-200 focus:ring-2 focus:ring-red-400 focus:outline-none transition"
                                    title="Delete item" aria-label="Delete <?php echo e($item->item_name); ?>">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                            No inventory items found.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination (optional) -->
        <div class="mt-6">
            <?php echo e($inventoryItems->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DentalCare\resources\views/inventory/inventory.blade.php ENDPATH**/ ?>