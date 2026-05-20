<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('request_mark_change');

global $isRTL;
?>

<div class="card-enter">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="index.php?route=planning/view-marks&exam_id=<?= $mark['exam_id'] ?>" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Marks', 'بیرته نمرې ته', 'بازگشت به نمرات') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Request Mark Change', 'د نمرې د بدلون غوښتنه', 'درخواست تغییر نمره') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Submit a request to modify marks. Changes require committee and planning approval.', 'د نمرې د بدلون لپاره غوښتنه وسپارئ. بدلونونه د کمیټې او پلان تصویب ته اړتیا لري.', 'درخواست تغییر نمره ارسال کنید. تغییرات نیاز به تایید کمیته و پلان دارد.') ?></p>
        </div>

        <!-- Student Info -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Student', 'زده کونکی', 'دانشجو') ?></p>
                    <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($mark['first_name'] . ' ' . $mark['last_name']) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Enrollment', 'نوم لیکنه', 'شماره ثبت') ?></p>
                    <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($mark['enrollment_number']) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Exam', 'ازموینه', 'آزمون') ?></p>
                    <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($mark['exam_name']) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Course', 'کورس', 'کورس') ?></p>
                    <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($mark['course_name']) ?></p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <form method="POST" action="index.php?route=planning/request-mark-change" class="space-y-6">
                <input type="hidden" name="exam_mark_id" value="<?= $_GET['exam_mark_id'] ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Current Theory Marks', 'اوسنۍ نظري نمرې', 'نمرات تیوری فعلی') ?></label>
                        <input type="text" value="<?= $mark['marks_theory'] ?? '-' ?>" disabled class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('New Theory Marks', 'نوي نظري نمرې', 'نمرات تیوری جدید') ?> <span class="text-red-500">*</span></label>
                        <input type="number" name="new_marks_theory" step="0.01" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Current Practical Marks', 'اوسنۍ عملي نمرې', 'نمرات عملی فعلی') ?></label>
                        <input type="text" value="<?= $mark['marks_practical'] ?? '-' ?>" disabled class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('New Practical Marks', 'نوي عملي نمرې', 'نمرات عملی جدید') ?> <span class="text-red-500">*</span></label>
                        <input type="number" name="new_marks_practical" step="0.01" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Reason for Change', 'د بدلون دلیل', 'دلیل تغییر') ?> <span class="text-red-500">*</span></label>
                    <textarea name="reason" rows="4" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Explain why the marks need to be changed...', 'تشریح کړئ چې ولې نمرې بدلولو ته اړتیا لري...', 'توضیح دهید چرا نمرات نیاز به تغییر دارند...') ?>"></textarea>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 rounded <?= $isRTL ? 'border-r-4 border-l-0' : '' ?>">
                    <div class="flex items-start gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-alert-line text-yellow-600 dark:text-yellow-400 text-xl"></i>
                        <div class="text-sm text-yellow-700 dark:text-yellow-300">
                            <p class="font-medium mb-1"><?= __t('Approval Process', 'د تصویب پروسه', 'فرآیند تایید') ?>:</p>
                            <ul class="list-disc <?= $isRTL ? 'mr-4' : 'ml-4' ?> space-y-1">
                                <li><?= __t('Your request will be reviewed by the Exam Committee', 'ستاسو غوښتنه د ازموینې کمیټې لخوا بیاکتنه کیږي', 'درخواست شما توسط کمیته امتحان بررسی می‌شود') ?></li>
                                <li><?= __t('After committee approval, Planning Manager will review', 'د کمیټې له تصویب وروسته، د پلان مدیر بیاکتنه کوي', 'پس از تایید کمیته، مدیر پلان بررسی می‌کند') ?></li>
                                <li><?= __t('Once approved, marks will be updated and transcript will reflect changes', 'یوځل تصویب شو، نمرې به تازه شي او ټرانسکرپټ به بدلونونه منعکس کړي', 'پس از تایید، نمرات به‌روز می‌شوند و ریزنمرات تغییرات را نشان می‌دهد') ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-send-plane-line"></i>
                        <span><?= __t('Submit Request', 'غوښتنه وسپارئ', 'ارسال درخواست') ?></span>
                    </button>
                    <a href="index.php?route=planning/view-marks&exam_id=<?= $mark['exam_id'] ?>" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2.5 rounded-lg transition">
                        <?= __t('Cancel', 'لغوه کول', 'لغو') ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>