<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('add_time_slot');

global $isRTL;
?>

<div class="card-enter">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="index.php?route=planning/time-slots" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Time Slots', 'بیرته وخت سلاټونو ته', 'بازگشت به بازه‌های زمانی') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Add New Time Slot', 'نوی وخت سلاټ اضافه کړئ', 'افزودن بازه زمانی جدید') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Define available time slot for academic scheduling', 'د اکاډمیک مهالویش لپاره موجود وخت سلاټ تعریف کړئ', 'تعریف بازه زمانی موجود برای برنامه‌ریزی آموزشی') ?></p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <form method="POST" action="index.php?route=planning/add-time-slot" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Day of Week', 'د اونۍ ورځ', 'روز هفته') ?> <span class="text-red-500">*</span></label>
                    <select name="day_of_week" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="Monday"><?= __t('Monday', 'دوشنبه', 'دوشنبه') ?></option>
                        <option value="Tuesday"><?= __t('Tuesday', 'سه شنبه', 'سه شنبه') ?></option>
                        <option value="Wednesday"><?= __t('Wednesday', 'چهارشنبه', 'چهارشنبه') ?></option>
                        <option value="Thursday"><?= __t('Thursday', 'پنجشنبه', 'پنجشنبه') ?></option>
                        <option value="Friday"><?= __t('Friday', 'جمعه', 'جمعه') ?></option>
                        <option value="Saturday"><?= __t('Saturday', 'شنبه', 'شنبه') ?></option>
                        <option value="Sunday"><?= __t('Sunday', 'یکشنبه', 'یکشنبه') ?></option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Start Time', 'پیل وخت', 'زمان شروع') ?> <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('End Time', 'پای وخت', 'زمان پایان') ?> <span class="text-red-500">*</span></label>
                        <input type="time" name="end_time" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg transition shadow-sm flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-save-line"></i>
                        <span><?= __t('Save Time Slot', 'وخت سلاټ خوندي کړئ', 'ذخیره بازه زمانی') ?></span>
                    </button>
                    <a href="index.php?route=planning/time-slots" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2.5 rounded-lg transition">
                        <?= __t('Cancel', 'لغوه کول', 'لغو') ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>