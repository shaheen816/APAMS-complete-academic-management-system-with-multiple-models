<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('planning_dashboard');

global $isRTL;
$role = $_SESSION['role'] ?? '';
$currentYear = date('Y');
$selectedYear = $_GET['year'] ?? $currentYear;
$selectedSemester = $_GET['semester'] ?? (date('n') <= 6 ? 2 : 1);
?>

<div class="card-enter">
    <!-- Header with Filters -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Planning Management Dashboard', 'د پلان جوړونې مدیریت ډشبورډ', 'داشبورد مدیریت پلان‌سازی') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Complete overview of all planning activities', 'د ټولو پلان جوړونې فعالیتونو بشپړه کتنه', 'نمای کامل از تمام فعالیت‌های پلان‌سازی') ?></p>
        </div>
        <div class="flex gap-3">
            <!-- Filters -->
            <select id="yearFilter" onchange="applyFilters()" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <?php for($y = $currentYear-1; $y <= $currentYear+1; $y++): ?>
                <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>><?= $y ?>-<?= $y+1 ?></option>
                <?php endfor; ?>
            </select>
            <select id="semesterFilter" onchange="applyFilters()" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <option value="1" <?= $selectedSemester == 1 ? 'selected' : '' ?>><?= __t('Semester 1', 'لومړی سمستر', 'سمستر اول') ?></option>
                <option value="2" <?= $selectedSemester == 2 ? 'selected' : '' ?>><?= __t('Semester 2', 'دوهم سمستر', 'سمستر دوم') ?></option>
            </select>
            <button onclick="window.location.reload()" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-2 rounded-lg transition" title="<?= __t('Refresh', 'تازه کول', 'تازه سازی') ?>">
                <i class="ri-refresh-line text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Quick Actions Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 mb-6">
        <div class="flex flex-wrap gap-3 justify-between items-center">
            <div class="flex flex-wrap gap-3">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 py-2"><?= __t('Quick Actions:', 'چټک اقدامات:', 'اقدامات سریع:') ?></span>
                <button onclick="generateAllTranscripts()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2 text-sm">
                    <i class="ri-file-copy-line"></i>
                    <span><?= __t('Generate All Transcripts', 'ټول ټرانسکرپټونه جوړ کړئ', 'ایجاد همه ریزنمرات') ?></span>
                </button>
                <button onclick="exportMarksReport()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2 text-sm">
                    <i class="ri-file-excel-line"></i>
                    <span><?= __t('Export Marks Report', 'د نمرې رپوټ صادر کړئ', 'خروجی گزارش نمرات') ?></span>
                </button>
                <button onclick="viewPendingApprovals()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2 text-sm">
                    <i class="ri-hourglass-line"></i>
                    <span><?= __t('Pending Approvals', 'ځنډول شوي تصویبونه', 'تاییدهای در انتظار') ?></span>
                    <?php if(($stats['pending_marks'] ?? 0) > 0 || ($stats['pending_timetables'] ?? 0) > 0): ?>
                    <span class="bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 ml-1"><?= ($stats['pending_marks'] ?? 0) + ($stats['pending_timetables'] ?? 0) ?></span>
                    <?php endif; ?>
                </button>
            </div>
            <div class="text-sm text-gray-500">
                <i class="ri-calendar-line"></i> <?= __t('Academic Year', 'اکاډمیک کال', 'سال تحصیلی') ?>: <?= $selectedYear ?>-<?= $selectedYear+1 ?> | <?= __t('Semester', 'سمستر', 'سمستر') ?>: <?= $selectedSemester ?>
            </div>
        </div>
    </div>

    <!-- Alert System for Stalled Items -->
    <?php if(($stats['marks_stalled'] ?? 0) > 0 || ($stats['timetables_stalled'] ?? 0) > 0): ?>
    <div class="mb-6 space-y-2">
        <?php if(($stats['marks_stalled'] ?? 0) > 0): ?>
        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-alert-line text-red-500 text-xl"></i>
                    <div>
                        <p class="font-semibold text-red-800 dark:text-red-300"><?= __t('Stalled Marks Approval', 'ځنډول شوي نمرې تصویب', 'تایید نمرات متوقف شده') ?></p>
                        <p class="text-sm text-red-700 dark:text-red-400"><?= sprintf(__t('%d exams have been pending committee approval for more than 7 days', '%d ازموینې د 7 ورځو څخه ډیر وخت لپاره د کمیټې تصویب ته ځنډول شوي', '%d آزمون بیش از 7 روز در انتظار تایید کمیته هستند'), $stats['marks_stalled'] ?? 0) ?></p>
                    </div>
                </div>
                <a href="index.php?route=planning/marks-workflow" class="text-red-600 hover:text-red-800 dark:text-red-400 text-sm font-medium"><?= __t('Review Now', 'اوس بیاکتنه وکړئ', 'بررسی الان') ?> →</a>
            </div>
        </div>
        <?php endif; ?>
        <?php if(($stats['timetables_stalled'] ?? 0) > 0): ?>
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-alert-line text-yellow-500 text-xl"></i>
                    <div>
                        <p class="font-semibold text-yellow-800 dark:text-yellow-300"><?= __t('Unsubmitted Timetables', 'نه سپارل شوي مهالویشونه', 'جدول‌های زمانی ارسال نشده') ?></p>
                        <p class="text-sm text-yellow-700 dark:text-yellow-400"><?= sprintf(__t('%d faculties have not submitted their timetables for this semester', '%d پوهنځیو د دې سمستر لپاره خپل مهالویشونه نه دي سپارلي', '%d پوهنځی جدول زمانی خود را برای این سمستر ارسال نکرده‌اند'), $stats['timetables_stalled'] ?? 0) ?></p>
                    </div>
                </div>
                <a href="index.php?route=planning/faculty-timetables" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 text-sm font-medium"><?= __t('Review Now', 'اوس بیاکتنه وکړئ', 'بررسی الان') ?> →</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Stats Cards Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pending Timetables -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 hover:shadow-md transition <?= $isRTL ? 'border-r-4 border-l-0' : '' ?>">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?= __t('Pending Timetables', 'ځنډول شوي مهالویشونه', 'جدول‌های زمانی در انتظار') ?></p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?= number_format($stats['pending_timetables'] ?? 0) ?></p>
                </div>
                <div class="w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                    <i class="ri-calendar-schedule-line text-2xl text-yellow-500"></i>
                </div>
            </div>
            <div class="text-xs text-gray-500 mt-2">
                <?php if(($stats['total_faculties'] ?? 0) > 0): ?>
                <?= round((($stats['pending_timetables'] ?? 0) / ($stats['total_faculties'] ?? 1)) * 100) ?>% <?= __t('of faculties', 'د پوهنځیو', 'از پوهنځی‌ها') ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pending Marks -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition <?= $isRTL ? 'border-r-4 border-l-0' : '' ?>">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?= __t('Pending Marks', 'ځنډول شوي نمرې', 'نمرات در انتظار') ?></p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?= number_format($stats['pending_marks'] ?? 0) ?></p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <i class="ri-file-list-3-line text-2xl text-blue-500"></i>
                </div>
            </div>
            <div class="text-xs text-gray-500 mt-2">
                <?= ($stats['pending_marks_committee'] ?? 0) ?> <?= __t('with committee', 'د کمیټې سره', 'با کمیته') ?>, 
                <?= ($stats['pending_marks_planning'] ?? 0) ?> <?= __t('with planning', 'د پلان سره', 'با پلان') ?>
            </div>
        </div>

        <!-- Pending Diplomas -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition <?= $isRTL ? 'border-r-4 border-l-0' : '' ?>">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?= __t('Pending Diplomas', 'ځنډول شوي ډیپلومونه', 'دیپلوم‌های در انتظار') ?></p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?= number_format($stats['pending_diplomas'] ?? 0) ?></p>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <i class="ri-award-line text-2xl text-purple-500"></i>
                </div>
            </div>
            <div class="text-xs text-gray-500 mt-2">
                <?= __t('Awaiting approval chain', 'د تصویب لړۍ په انتظار کې', 'در انتظار زنجیره تایید') ?>
            </div>
        </div>

        <!-- Upcoming Seminars -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition <?= $isRTL ? 'border-r-4 border-l-0' : '' ?>">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?= __t('Upcoming Seminars', 'راتلونکي سیمینارونه', 'سمینارهای پیش رو') ?></p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?= number_format($stats['upcoming_seminars'] ?? 0) ?></p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <i class="ri-speaker-line text-2xl text-green-500"></i>
                </div>
            </div>
            <div class="text-xs text-gray-500 mt-2">
                <?php if(($stats['next_seminar_date'] ?? '')): ?>
                <?= __t('Next', 'راتلونکی', 'بعدی') ?>: <?= date('M d', strtotime($stats['next_seminar_date'])) ?>
                <?php else: ?>
                <?= __t('No upcoming seminars', 'راتلونکي سیمینارونه نشته', 'سمینار پیش روی وجود ندارد') ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 2 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Time Slots', 'وخت سلاټونه', 'بازه‌های زمانی') ?></p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white"><?= number_format($stats['total_time_slots'] ?? 0) ?></p>
                </div>
                <i class="ri-time-line text-2xl text-indigo-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Transcripts', 'ټرانسکرپټونه', 'ریزنمرات') ?></p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white"><?= number_format($stats['approved_transcripts'] ?? 0) ?></p>
                </div>
                <i class="ri-file-copy-line text-2xl text-green-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Total Cadets', 'ټول کاډیټان', 'کل کادت‌ها') ?></p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white"><?= number_format($stats['total_cadets'] ?? 0) ?></p>
                </div>
                <i class="ri-user-line text-2xl text-blue-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Courses', 'کورسونه', 'کورس‌ها') ?></p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white"><?= number_format($stats['total_courses'] ?? 0) ?></p>
                </div>
                <i class="ri-book-line text-2xl text-purple-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Faculties', 'پوهنځي', 'پوهنځی‌ها') ?></p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white"><?= number_format($stats['total_faculties'] ?? 0) ?></p>
                </div>
                <i class="ri-building-line text-2xl text-orange-500"></i>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Marks Approval Trend Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Marks Approval Trend', 'د نمرې تصویب رجحان', 'روند تایید نمرات') ?></h3>
                <select id="trendYearSelect" onchange="updateTrendChart()" class="px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700">
                    <?php for($y = $currentYear-1; $y <= $currentYear; $y++): ?>
                    <option value="<?= $y ?>" <?= $y == $currentYear ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <canvas id="approvalTrendChart" height="200"></canvas>
        </div>

        <!-- Faculty Performance Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Faculty Performance', 'د پوهنځي فعالیت', 'عملکرد پوهنځی‌ها') ?></h3>
                <button onclick="window.location.href='index.php?route=reports/faculty-performance'" class="text-indigo-600 hover:text-indigo-700 text-sm"><?= __t('View Details', 'تفصیلات وګورئ', 'مشاهده جزئیات') ?> →</button>
            </div>
            <canvas id="facultyPerformanceChart" height="200"></canvas>
        </div>
    </div>

    <!-- Faculty-wise Timetable Status -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Faculty Timetable Status', 'د پوهنځي مهالویش حالت', 'وضعیت جدول زمانی پوهنځی‌ها') ?></h3>
            <a href="index.php?route=planning/faculty-timetables" class="text-indigo-600 hover:text-indigo-700 text-sm"><?= __t('Manage', 'مدیریت', 'مدیریت') ?> →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Faculty', 'پوهنځی', 'پوهنځی') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Total', 'ټول', 'کل') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Draft', 'مسوده', 'پیش‌نویس') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Submitted', 'سپارل شوی', 'ارسال شده') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Approved', 'تصویب شوی', 'تایید شده') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Progress', 'پرمختګ', 'پیشرفت') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if(!empty($facultyTimetableStats)): ?>
                        <?php foreach($facultyTimetableStats as $faculty): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($faculty['name']) ?></td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 dark:text-gray-300"><?= $faculty['total'] ?></td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="<?= $faculty['draft'] > 0 ? 'text-yellow-600 dark:text-yellow-400 font-bold' : 'text-gray-500' ?>"><?= $faculty['draft'] ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="<?= $faculty['submitted'] > 0 ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-gray-500' ?>"><?= $faculty['submitted'] ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="<?= $faculty['approved'] > 0 ? 'text-green-600 dark:text-green-400 font-bold' : 'text-gray-500' ?>"><?= $faculty['approved'] ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <?php $percentage = $faculty['total'] > 0 ? round(($faculty['approved'] / $faculty['total']) * 100) : 0; ?>
                                <div class="flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full transition-all" style="width: <?= $percentage ?>%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 dark:text-gray-400 w-10"><?= $percentage ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500"><?= __t('No faculty data available', 'د پوهنځي معلومات شتون نلري', 'اطلاعاتی برای پوهنځی‌ها موجود نیست') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Marks by Faculty -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Marks Pending by Faculty', 'د پوهنځي له مخې ځنډول شوي نمرې', 'نمرات در انتظار بر اساس پوهنځی') ?></h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php if(!empty($marksByFaculty)): ?>
                    <?php foreach($marksByFaculty as $faculty): ?>
                    <div class="px-6 py-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300"><?= htmlspecialchars($faculty['name']) ?></span>
                        <div class="flex items-center gap-3">
                            <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <?php $maxPending = max(array_column($marksByFaculty, 'pending')) ?: 1; ?>
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: <?= ($faculty['pending'] / $maxPending) * 100 ?>%"></div>
                            </div>
                            <span class="text-sm font-bold <?= $faculty['pending'] > 0 ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400' ?>">
                                <?= $faculty['pending'] ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="px-6 py-8 text-center text-gray-500"><?= __t('No pending marks', 'ځنډول شوي نمرې نشته', 'نمرات در انتظاری وجود ندارد') ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Upcoming Deadlines', 'راتلونکي وخت نیټې', 'ضرب الاجل‌های پیش رو') ?></h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php if(!empty($upcomingDeadlines)): ?>
                    <?php foreach($upcomingDeadlines as $deadline): ?>
                    <div class="px-6 py-3 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($deadline['title']) ?></p>
                            <p class="text-xs text-gray-500"><?= htmlspecialchars($deadline['description']) ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold <?= $deadline['days_left'] <= 3 ? 'text-red-600 dark:text-red-400' : ($deadline['days_left'] <= 7 ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400') ?>">
                                <?= $deadline['days_left'] ?> <?= __t('days left', 'ورځې پاتې', 'روز مانده') ?>
                            </p>
                            <p class="text-xs text-gray-400"><?= date('M d, Y', strtotime($deadline['date'])) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="px-6 py-8 text-center text-gray-500"><?= __t('No upcoming deadlines', 'راتلونکي وخت نیټې نشته', 'ضرب الاجل پیش روی وجود ندارد') ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Recent Activities', 'وروستي فعالیتونه', 'فعالیت‌های اخیر') ?></h3>
            <button onclick="loadMoreActivities()" class="text-indigo-600 hover:text-indigo-700 text-sm"><?= __t('Load More', 'نور بار کړئ', 'بارگذاری بیشتر') ?></button>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700" id="activitiesContainer">
            <?php if(!empty($recentActivities)): ?>
                <?php foreach(array_slice($recentActivities, 0, 10) as $activity): ?>
                <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center <?php
                                if($activity['type'] == 'timetable') echo 'bg-yellow-100 dark:bg-yellow-900/30';
                                elseif($activity['type'] == 'marks') echo 'bg-blue-100 dark:bg-blue-900/30';
                                elseif($activity['type'] == 'diploma') echo 'bg-purple-100 dark:bg-purple-900/30';
                                elseif($activity['type'] == 'transcript') echo 'bg-green-100 dark:bg-green-900/30';
                                else echo 'bg-gray-100 dark:bg-gray-700';
                            ?>">
                                <?php if($activity['type'] == 'timetable'): ?>
                                    <i class="ri-calendar-schedule-line text-yellow-500"></i>
                                <?php elseif($activity['type'] == 'marks'): ?>
                                    <i class="ri-file-list-3-line text-blue-500"></i>
                                <?php elseif($activity['type'] == 'diploma'): ?>
                                    <i class="ri-award-line text-purple-500"></i>
                                <?php elseif($activity['type'] == 'transcript'): ?>
                                    <i class="ri-file-copy-line text-green-500"></i>
                                <?php else: ?>
                                    <i class="ri-information-line text-gray-500"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($activity['title']) ?></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($activity['description']) ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400"><?= $activity['time_ago'] ?></p>
                            <?php if(isset($activity['status']) && $activity['status'] == 'pending'): ?>
                            <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 mt-1"><?= __t('Pending', 'ځنډول شوی', 'در انتظار') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="px-6 py-12 text-center">
                    <i class="ri-inbox-line text-5xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                    <p class="text-gray-500 dark:text-gray-400"><?= __t('No recent activities', 'وروستي فعالیتونه نشته', 'فعالیت اخیری وجود ندارد') ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let trendChart = null;
let facultyChart = null;

// Initialize charts on page load
document.addEventListener('DOMContentLoaded', function() {
    initTrendChart();
    initFacultyChart();
    setInterval(refreshDashboard, 60000); // Refresh every minute
});

function initTrendChart() {
    const ctx = document.getElementById('approvalTrendChart').getContext('2d');
    const year = document.getElementById('trendYearSelect')?.value || <?= $currentYear ?>;
    
    // Fetch trend data via AJAX
    fetch(`index.php?route=planning/get-trend-data&year=${year}`)
        .then(response => response.json())
        .then(data => {
            if (trendChart) trendChart.destroy();
            trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: '<?= __t('Marks Submitted', 'سپارل شوي نمرې', 'نمرات ارسال شده') ?>',
                        data: data.submitted || [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: '<?= __t('Marks Approved', 'تصویب شوي نمرې', 'نمرات تایید شده') ?>',
                        data: data.approved || [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'top', rtl: <?= $isRTL ? 'true' : 'false' ?> }
                    }
                }
            });
        });
}

function initFacultyChart() {
    const ctx = document.getElementById('facultyPerformanceChart').getContext('2d');
    
    <?php if(!empty($facultyPerformanceData)): ?>
    facultyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($facultyPerformanceData, 'name')) ?>,
            datasets: [{
                label: '<?= __t('Pass Rate (%)', 'د بریالیتوب کچه (٪)', 'نرخ قبولی (٪)') ?>',
                data: <?= json_encode(array_column($facultyPerformanceData, 'pass_rate')) ?>,
                backgroundColor: 'rgba(168, 85, 247, 0.7)',
                borderColor: 'rgb(168, 85, 247)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: { beginAtZero: true, max: 100, title: { display: true, text: '<?= __t('Percentage (%)', 'سلنه (٪)', 'درصد (٪)') ?>' } }
            },
            plugins: {
                legend: { position: 'top', rtl: <?= $isRTL ? 'true' : 'false' ?> }
            }
        }
    });
    <?php endif; ?>
}

function updateTrendChart() {
    initTrendChart();
}

function applyFilters() {
    const year = document.getElementById('yearFilter').value;
    const semester = document.getElementById('semesterFilter').value;
    window.location.href = `index.php?route=planning/dashboard&year=${year}&semester=${semester}`;
}

function generateAllTranscripts() {
    if(confirm('<?= __t('Generate transcripts for all eligible cadets? This may take a few moments.', 'د ټولو وړ کاډیټانو لپاره ټرانسکرپټونه جوړ کړئ؟ دا ممکن څو شیبې وخت ونیسي.', 'آیا برای تمام کادت‌های واجد شرایط ریزنمرات ایجاد شود؟ این ممکن چند لحظه طول بکشد.') ?>')) {
        window.location.href = 'index.php?route=planning/generate-all-transcripts';
    }
}

function exportMarksReport() {
    const year = document.getElementById('yearFilter').value;
    const semester = document.getElementById('semesterFilter').value;
    window.location.href = `index.php?route=planning/export-marks-report&year=${year}&semester=${semester}`;
}

function viewPendingApprovals() {
    window.location.href = 'index.php?route=planning/marks-workflow';
}

function loadMoreActivities() {
    const container = document.getElementById('activitiesContainer');
    const loadingHtml = '<div class="px-6 py-4 text-center"><i class="ri-loader-line animate-spin"></i> <?= __t('Loading...', 'رالوډ کیږي...', 'در حال بارگذاری...') ?></div>';
    container.insertAdjacentHTML('beforeend', loadingHtml);
    
    // Fetch more activities via AJAX
    setTimeout(() => {
        document.querySelector('#activitiesContainer .text-center')?.remove();
    }, 1000);
}

function refreshDashboard() {
    // Silently refresh data (you can implement partial refresh via AJAX)
    console.log('Dashboard auto-refreshed');
}
</script>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.animate-spin {
    animation: spin 1s linear infinite;
    display: inline-block;
}
</style>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>