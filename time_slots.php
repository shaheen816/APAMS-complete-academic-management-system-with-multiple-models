<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('time_slots_management');

global $isRTL;
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Time Slots Management', 'د وخت سلاټونو مدیریت', 'مدیریت بازه‌های زمانی') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Define available time slots for academic scheduling', 'د اکاډمیک مهالویش لپاره موجود وخت سلاټونه تعریف کړئ', 'تعریف بازه‌های زمانی موجود برای برنامه‌ریزی آموزشی') ?></p>
        </div>
        <a href="index.php?route=planning/add-time-slot" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
            <i class="ri-add-line text-xl"></i>
            <span><?= __t('Add Time Slot', 'نوی وخت سلاټ', 'افزودن بازه زمانی') ?></span>
        </a>
    </div>

    <!-- Time Slots Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Day', 'ورځ', 'روز') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Start Time', 'پیل وخت', 'زمان شروع') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('End Time', 'پای وخت', 'زمان پایان') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Status', 'حالت', 'وضعیت') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Actions', 'عملونه', 'عملیات') ?></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if(!empty($timeSlots)): ?>
                        <?php foreach($timeSlots as $slot): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"><?= __t($slot['day_of_week'], $slot['day_of_week'], $slot['day_of_week']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= date('h:i A', strtotime($slot['start_time'])) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= date('h:i A', strtotime($slot['end_time'])) ?></td>
                            <td class="px-6 py-4 text-center">
                                <?php if($slot['is_active']): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"><?= __t('Active', 'فعال', 'فعال') ?></span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200"><?= __t('Inactive', 'غیر فعال', 'غیرفعال') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <a href="index.php?route=planning/edit-time-slot&id=<?= $slot['id'] ?>" class="text-green-600 hover:text-green-900 dark:text-green-400 transition" title="<?= __t('Edit', 'سمول', 'ویرایش') ?>">
                                        <i class="ri-edit-line text-xl"></i>
                                    </a>
                                    <a href="index.php?route=planning/delete-time-slot&id=<?= $slot['id'] ?>" onclick="return confirm('<?= __t('Are you sure you want to delete this time slot?', 'ایا تاسو ډاډه یاست چې تاسو غواړئ دا وخت سلاټ حذف کړئ؟', 'آیا مطمئن هستید که می‌خواهید این بازه زمانی را حذف کنید؟') ?>')" class="text-red-600 hover:text-red-900 dark:text-red-400 transition" title="<?= __t('Delete', 'حذف', 'حذف') ?>">
                                        <i class="ri-delete-bin-line text-xl"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class="ri-time-line text-5xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                                <p class="text-gray-500 dark:text-gray-400"><?= __t('No time slots defined', 'هیچ وخت سلاټ تعریف شوی نه دی', 'هیچ بازه زمانی تعریف نشده است') ?></p>
                                <a href="index.php?route=planning/add-time-slot" class="mt-3 inline-block text-indigo-600 hover:text-indigo-700 dark:text-indigo-400"><?= __t('Add your first time slot', 'خپل لومړی وخت سلاټ اضافه کړئ', 'افزودن اولین بازه زمانی') ?> →</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>