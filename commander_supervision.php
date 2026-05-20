<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('commander_supervision');

global $isRTL;
?>

<div class="card-enter">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Commander Supervision Dashboard', 'د قوماندان نظارت ډشبورډ', 'داشبورد نظارت فرماندهی') ?></h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Monitor and supervise all academic and administrative activities', 'ټول اکاډمیک او اداري فعالیتونه څارنه او نظارت کړئ', 'نظارت و بررسی تمام فعالیت‌های آکادمیک و اداری') ?></p>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?= __t('Transcripts Issued', 'صادر شوي ټرانسکرپټونه', 'ریزنمرات صادر شده') ?></p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?= number_format($summary['transcripts_issued'] ?? 0) ?></p>
                </div>
                <i class="ri-file-copy-line text-3xl text-indigo-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?= __t('Diplomas Issued', 'صادر شوي ډیپلومونه', 'دیپلوم‌های صادر شده') ?></p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?= number_format($summary['diplomas_issued'] ?? 0) ?></p>
                </div>
                <i class="ri-award-line text-3xl text-green-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?= __t('Seminars Completed', 'بشپړ شوي سیمینارونه', 'سمینارهای تکمیل شده') ?></p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?= number_format($summary['seminars_completed'] ?? 0) ?></p>
                </div>
                <i class="ri-speaker-line text-3xl text-purple-500"></i>
            </div>
        </div>
    </div>

    <!-- Faculty-wise Timetable Status -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Faculty Timetable Status', 'د پوهنځي مهالویش حالت', 'وضعیت جدول زمانی پوهنځی‌ها') ?></h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Faculty', 'پوهنځی', 'پوهنځی') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Total Entries', 'ټول داخله', 'کل ورودی') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Pending', 'ځنډول شوی', 'در انتظار') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Approved', 'تصویب شوی', 'تایید شده') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Progress', 'پرمختګ', 'پیشرفت') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if(!empty($summary['faculties'])): ?>
                        <?php foreach($summary['faculties'] as $faculty): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($faculty['name']) ?></td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 dark:text-gray-300"><?= $faculty['total_timetable_entries'] ?></td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="<?= $faculty['pending_timetables'] > 0 ? 'text-yellow-600 dark:text-yellow-400 font-bold' : 'text-gray-500' ?>">
                                    <?= $faculty['pending_timetables'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="<?= $faculty['approved_timetables'] > 0 ? 'text-green-600 dark:text-green-400 font-bold' : 'text-gray-500' ?>">
                                    <?= $faculty['approved_timetables'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php $percentage = $faculty['total_timetable_entries'] > 0 ? round(($faculty['approved_timetables'] / $faculty['total_timetable_entries']) * 100) : 0; ?>
                                <div class="flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: <?= $percentage ?>%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 dark:text-gray-400"><?= $percentage ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500"><?= __t('No faculty data available', 'د پوهنځي معلومات شتون نلري', 'اطلاعاتی برای پوهنځی‌ها موجود نیست') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pending Marks by Faculty -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Pending Marks Approval by Faculty', 'د پوهنځي له مخې د نمرې تصویب ځنډول شوی', 'نمرات در انتظار تایید بر اساس پوهنځی') ?></h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Faculty', 'پوهنځی', 'پوهنځی') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Pending Exams', 'ځنډول شوې ازموینې', 'آزمون‌های در انتظار') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Status', 'حالت', 'وضعیت') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if(!empty($summary['marks_pending'])): ?>
                        <?php foreach($summary['marks_pending'] as $pending): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($pending['faculty_name']) ?></td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="inline-flex px-2 py-1 text-sm font-bold rounded-lg bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                    <?= $pending['pending_marks_count'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                    <?= __t('Awaiting Final Approval', 'د وروستي تصویب په انتظار', 'در انتظار تایید نهایی') ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500"><?= __t('No pending marks', 'ځنډول شوې نمرې نشته', 'نمرات در انتظاری وجود ندارد') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="index.php?route=reports/academic-year" class="bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-xl p-4 transition flex items-center justify-between group">
            <div>
                <p class="font-semibold text-indigo-700 dark:text-indigo-400"><?= __t('Academic Year Report', 'د اکاډمیک کال رپوټ', 'گزارش سال تحصیلی') ?></p>
                <p class="text-xs text-indigo-500 dark:text-indigo-500 mt-1"><?= __t('View complete academic summary', 'بشپړ اکاډمیک لنډیز وګورئ', 'مشاهده خلاصه کامل آکادمیک') ?></p>
            </div>
            <i class="ri-arrow-right-line text-indigo-500 group-hover:translate-x-1 transition"></i>
        </a>
        <a href="index.php?route=reports/faculty-performance" class="bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-xl p-4 transition flex items-center justify-between group">
            <div>
                <p class="font-semibold text-green-700 dark:text-green-400"><?= __t('Faculty Performance', 'د پوهنځي فعالیت', 'عملکرد پوهنځی‌ها') ?></p>
                <p class="text-xs text-green-500 dark:text-green-500 mt-1"><?= __t('Compare faculty performance metrics', 'د پوهنځي فعالیت میټریکونه پرتله کړئ', 'مقایسه معیارهای عملکرد پوهنځی‌ها') ?></p>
            </div>
            <i class="ri-arrow-right-line text-green-500 group-hover:translate-x-1 transition"></i>
        </a>
        <a href="index.php?route=reports/graduation-summary" class="bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-xl p-4 transition flex items-center justify-between group">
            <div>
                <p class="font-semibold text-purple-700 dark:text-purple-400"><?= __t('Graduation Summary', 'د فراغت لنډیز', 'خلاصه فارغ‌التحصیلی') ?></p>
                <p class="text-xs text-purple-500 dark:text-purple-500 mt-1"><?= __t('View graduation statistics', 'د فراغت احصایې وګورئ', 'مشاهده آمار فارغ‌التحصیلی') ?></p>
            </div>
            <i class="ri-arrow-right-line text-purple-500 group-hover:translate-x-1 transition"></i>
        </a>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>