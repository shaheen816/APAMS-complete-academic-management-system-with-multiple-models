<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('marks_workflow');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Marks Workflow', 'د نمرې کاري بهیر', 'جریان کاری نمرات') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                <?php if($role === 'INSTRUCTOR'): ?>
                    <?= __t('Submit your entered marks for committee approval', 'خپل داخل شوي نمرې د کمیټې تصویب لپاره وسپارئ', 'نمرات وارد شده خود را برای تایید کمیته ارسال کنید') ?>
                <?php elseif($role === 'EXAM_COMMITTEE'): ?>
                    <?= __t('Review and approve marks submitted by instructors', 'د ښوونکو لخوا سپارل شوي نمرې بیاکتنه او تصویب کړئ', 'بررسی و تایید نمرات ارسال شده توسط استادان') ?>
                <?php elseif($role === 'PLANNING_MANAGER'): ?>
                    <?= __t('Final approval of marks before they appear in transcripts', 'د نمرې وروستی تصویب مخکې له دې چې په ټرانسکرپټ کې ښکاره شي', 'تایید نهایی نمرات قبل از نمایش در ریزنمرات') ?>
                <?php else: ?>
                    <?= __t('Track marks approval process across all faculties', 'د ټولو پوهنځیو د نمرې تصویب پروسه تعقیب کړئ', 'پیگیری فرآیند تایید نمرات در تمام پوهنځی‌ها') ?>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Workflow Stages -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 text-center border-t-4 border-gray-400">
            <div class="text-2xl font-bold text-gray-400">1</div>
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mt-1"><?= __t('Teacher Entry', 'د ښوونکي لخوا داخلول', 'ورود توسط استاد') ?></div>
            <div class="text-xs text-gray-500"><?= __t('Marks entered', 'نمرې داخلې شوې', 'نمرات وارد شده') ?></div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 text-center border-t-4 border-yellow-500">
            <div class="text-2xl font-bold text-yellow-500">2</div>
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mt-1"><?= __t('Committee Review', 'د کمیټې بیاکتنه', 'بررسی کمیته') ?></div>
            <div class="text-xs text-gray-500"><?= __t('Pending approval', 'د تصویب په انتظار', 'در انتظار تایید') ?></div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 text-center border-t-4 border-blue-500">
            <div class="text-2xl font-bold text-blue-500">3</div>
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mt-1"><?= __t('Planning Approval', 'د پلان تصویب', 'تایید پلان') ?></div>
            <div class="text-xs text-gray-500"><?= __t('Final review', 'وروستۍ بیاکتنه', 'بررسی نهایی') ?></div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 text-center border-t-4 border-green-500">
            <div class="text-2xl font-bold text-green-500">4</div>
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mt-1"><?= __t('Transcript Ready', 'ټرانسکرپټ چمتو دی', 'ریزنمرات آماده') ?></div>
            <div class="text-xs text-gray-500"><?= __t('Marks locked', 'نمرې لاک شوې', 'نمرات قفل شد') ?></div>
        </div>
    </div>

    <!-- Workflow Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Exams Pending Action', 'هغه ازموینې چې عمل ته اړتیا لري', 'آزمون‌های نیازمند اقدام') ?></h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Exam', 'ازموینه', 'آزمون') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Course', 'کورس', 'کورس') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Students', 'زده کونکي', 'دانشجویان') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Marks Entered', 'نمرې داخلې شوې', 'نمرات وارد شده') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Status', 'حالت', 'وضعیت') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Actions', 'عملونه', 'عملیات') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if(!empty($workflows)): ?>
                        <?php foreach($workflows as $workflow): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($workflow['exam_name']) ?></td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($workflow['course_code']) ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars($workflow['course_name']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 dark:text-gray-300"><?= $workflow['total_students'] ?></td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-medium">
                                    <?php $percentage = ($workflow['marks_entered'] / max($workflow['total_students'], 1)) * 100; ?>
                                    <span class="<?= $percentage == 100 ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' ?>">
                                        <?= $workflow['marks_entered'] ?>/<?= $workflow['total_students'] ?>
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5 mt-1">
                                    <div class="bg-indigo-600 h-1.5 rounded-full" style="width: <?= $percentage ?>%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <?php if($workflow['workflow_status'] == 'DRAFT'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400"><?= __t('Draft', 'مسوده', 'پیش‌نویس') ?></span>
                                <?php elseif($workflow['workflow_status'] == 'TEACHER_SUBMITTED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200"><?= __t('Pending Committee', 'د کمیټې په انتظار', 'در انتظار کمیته') ?></span>
                                <?php elseif($workflow['workflow_status'] == 'COMMITTEE_APPROVED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200"><?= __t('Pending Planning', 'د پلان په انتظار', 'در انتظار پلان') ?></span>
                                <?php elseif($workflow['workflow_status'] == 'PLANNING_APPROVED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"><?= __t('Approved', 'تصویب شوی', 'تایید شده') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="index.php?route=planning/view-marks&exam_id=<?= $workflow['exam_id'] ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg text-sm transition inline-flex items-center gap-1 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <i class="ri-eye-line"></i>
                                    <span><?= __t('View', 'کتل', 'مشاهده') ?></span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="ri-checkbox-circle-line text-5xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                                <p class="text-gray-500 dark:text-gray-400"><?= __t('No pending exams found', 'هیچ ځنډول شوې ازموینه ونه موندل شوه', 'هیچ آزمون در انتظاری یافت نشد') ?></p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>