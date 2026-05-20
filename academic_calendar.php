<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('academic_calendar');
global $isRTL;
?>

<div class="card-enter">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Academic Calendar', 'اکاډمیک کیلنڈر', 'تقویم اکادمیک') ?></h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Academic year schedule and important dates', 'د اکاډمیک کال مهالویش او مهمې نیټې', 'برنامه سال تحصیلی و تاریخ‌های مهم') ?></p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center">
        <i class="ri-calendar-event-line text-6xl text-indigo-500 mb-4 block"></i>
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2"><?= __t('Coming Soon', 'ژر راځي', 'به زودی') ?></h3>
        <p class="text-gray-500 dark:text-gray-400"><?= __t('Academic calendar feature is under development.', 'د اکاډمیک کیلنڈر خصوصیت د پراختیا لاندې دی.', 'ویژگی تقویم اکادمیک در حال توسعه است.') ?></p>
        <a href="index.php?route=planning/dashboard" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700">← <?= __t('Back to Dashboard', 'بیرته ډشبورډ ته', 'بازگشت به داشبورد') ?></a>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>