<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('view_change_request');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="index.php?route=planning/pending-change-requests" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Requests', 'بیرته غوښتنو ته', 'بازگشت به درخواست‌ها') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Mark Change Request Details', 'د نمرې د بدلون غوښتنې توضیحات', 'جزئیات درخواست تغییر نمره') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Request ID', 'د غوښتنې ID', 'شناسه درخواست') ?>: #<?= $request['id'] ?></p>
        </div>

        <!-- Status Banner -->
        <div class="p-4 rounded-lg mb-6 <?= 
            $request['status'] == 'PENDING' ? 'bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500' : 
            ($request['status'] == 'COMMITTEE_APPROVED' ? 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500' :
            ($request['status'] == 'PLANNING_APPROVED' ? 'bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500' : 
            'bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500')) ?>">
            <div class="flex items-center gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-information-line text-xl"></i>
                <div>
                    <p class="font-semibold"><?= __t('Current Status', 'اوسنی حالت', 'وضعیت فعلی') ?>: 
                        <?php if($request['status'] == 'PENDING'): ?>
                            <span class="text-yellow-600 dark:text-yellow-400"><?= __t('Pending Committee Approval', 'د کمیټې تصویب په انتظار', 'در انتظار تایید کمیته') ?></span>
                        <?php elseif($request['status'] == 'COMMITTEE_APPROVED'): ?>
                            <span class="text-blue-600 dark:text-blue-400"><?= __t('Committee Approved - Pending Planning', 'د کمیټې لخوا تصویب شوی - د پلان په انتظار', 'تایید شده توسط کمیته - در انتظار پلان') ?></span>
                        <?php elseif($request['status'] == 'PLANNING_APPROVED'): ?>
                            <span class="text-green-600 dark:text-green-400"><?= __t('Fully Approved - Changes Applied', 'په بشپړه توګه تصویب شوی - بدلونونه پلي شوي', 'کاملاً تایید شده - تغییرات اعمال شده') ?></span>
                        <?php else: ?>
                            <span class="text-red-600 dark:text-red-400"><?= __t('Rejected', 'رد شوی', 'رد شده') ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Student & Course Info -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-white"><?= __t('Student & Course Information', 'د زده کونکي او کورس معلومات', 'اطلاعات دانشجو و کورس') ?></h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Student Name', 'د زده کونکي نوم', 'نام دانشجو') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($request['first_name'] . ' ' . $request['last_name']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Enrollment Number', 'د نوم لیکنې شمیره', 'شماره ثبت') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($request['enrollment_number']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Course', 'کورس', 'کورس') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($request['course_code'] . ' - ' . $request['course_name']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Exam', 'ازموینه', 'آزمون') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($request['exam_name']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marks Comparison -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-white"><?= __t('Marks Comparison', 'د نمرو پرتله کول', 'مقایسه نمرات') ?></h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2"><?= __t('Current Marks', 'اوسنۍ نمرې', 'نمرات فعلی') ?></p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">
                            T: <?= $request['old_marks_theory'] ?? '-' ?> | P: <?= $request['old_marks_practical'] ?? '-'>
                        </p>
                    </div>
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2"><?= __t('Requested Marks', 'غوښتل شوي نمرې', 'نمرات درخواست شده') ?></p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            T: <?= $request['new_marks_theory'] ?> | P: <?= $request['new_marks_practical'] ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reason -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-white"><?= __t('Reason for Change', 'د بدلون دلیل', 'دلیل تغییر') ?></h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700 dark:text-gray-300"><?= nl2br(htmlspecialchars($request['reason'])) ?></p>
                <p class="text-xs text-gray-500 mt-4"><?= __t('Requested by', 'لخوا غوښتنه شوی', 'درخواست شده توسط') ?>: <?= htmlspecialchars($request['requested_by_name']) ?> | <?= date('F d, Y h:i A', strtotime($request['requested_at'])) ?></p>
            </div>
        </div>

        <!-- Approval Trail -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-white"><?= __t('Approval Trail', 'د تصویب لړۍ', 'ردیف تایید') ?></h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Committee Approval -->
                <div class="p-4 flex items-start gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center <?= $request['committee_approved'] ? 'bg-green-100 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' ?>">
                        <i class="ri-group-line <?= $request['committee_approved'] ? 'text-green-600 dark:text-green-400' : 'text-gray-400' ?>"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 dark:text-white"><?= __t('Exam Committee', 'د ازموینې کمیټه', 'کمیته امتحان') ?></p>
                        <?php if($request['committee_approved']): ?>
                            <p class="text-sm text-green-600 dark:text-green-400">✓ <?= __t('Approved by', 'لخوا تصویب شوی', 'تایید شده توسط') ?> <?= htmlspecialchars($request['committee_approved_by_name'] ?? 'N/A') ?></p>
                            <?php if($request['committee_remarks']): ?>
                                <p class="text-xs text-gray-500 mt-1"><?= __t('Remarks', 'تبصره', 'ملاحظات') ?>: <?= htmlspecialchars($request['committee_remarks']) ?></p>
                            <?php endif; ?>
                            <p class="text-xs text-gray-400 mt-1"><?= date('F d, Y h:i A', strtotime($request['committee_approved_at'])) ?></p>
                        <?php else: ?>
                            <p class="text-sm text-gray-500"><?= __t('Pending approval', 'د تصویب په انتظار', 'در انتظار تایید') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Planning Approval -->
                <div class="p-4 flex items-start gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center <?= $request['planning_approved'] ? 'bg-green-100 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' ?>">
                        <i class="ri-file-list-3-line <?= $request['planning_approved'] ? 'text-green-600 dark:text-green-400' : 'text-gray-400' ?>"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 dark:text-white"><?= __t('Planning Manager', 'د پلان مدیر', 'مدیر پلان') ?></p>
                        <?php if($request['planning_approved']): ?>
                            <p class="text-sm text-green-600 dark:text-green-400">✓ <?= __t('Approved by', 'لخوا تصویب شوی', 'تایید شده توسط') ?> <?= htmlspecialchars($request['planning_approved_by_name'] ?? 'N/A') ?></p>
                            <?php if($request['planning_remarks']): ?>
                                <p class="text-xs text-gray-500 mt-1"><?= __t('Remarks', 'تبصره', 'ملاحظات') ?>: <?= htmlspecialchars($request['planning_remarks']) ?></p>
                            <?php endif; ?>
                            <p class="text-xs text-gray-400 mt-1"><?= date('F d, Y h:i A', strtotime($request['planning_approved_at'])) ?></p>
                        <?php else: ?>
                            <p class="text-sm text-gray-500"><?= __t('Pending approval', 'د تصویب په انتظار', 'در انتظار تایید') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons (if pending) -->
        <?php if($request['status'] == 'PENDING' && $role === 'EXAM_COMMITTEE'): ?>
        <div class="mt-6 flex gap-3 justify-end">
            <button onclick="approveRequest(<?= $request['id'] ?>)" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-check-line"></i>
                <span><?= __t('Approve as Committee', 'د کمیټې په توګه تصویب کړئ', 'تایید به عنوان کمیته') ?></span>
            </button>
            <button onclick="rejectRequest(<?= $request['id'] ?>)" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-close-line"></i>
                <span><?= __t('Reject', 'رد', 'رد') ?></span>
            </button>
        </div>
        <?php elseif($request['status'] == 'COMMITTEE_APPROVED' && $role === 'PLANNING_MANAGER'): ?>
        <div class="mt-6 flex gap-3 justify-end">
            <button onclick="approveRequest(<?= $request['id'] ?>)" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-check-double-line"></i>
                <span><?= __t('Final Approve', 'وروستی تصویب', 'تایید نهایی') ?></span>
            </button>
            <button onclick="rejectRequest(<?= $request['id'] ?>)" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-close-line"></i>
                <span><?= __t('Reject', 'رد', 'رد') ?></span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function approveRequest(id) {
    let remarks = prompt('<?= __t('Enter approval remarks (optional):', 'د تصویب تبصرې دننه کړئ (اختیاري):', 'ملاحظات تایید را وارد کنید (اختیاری):') ?>');
    if (remarks !== null) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?route=planning/approve-change-request&id=' + id;
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remarks';
        input.value = remarks;
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

function rejectRequest(id) {
    let reason = prompt('<?= __t('Enter rejection reason:', 'د رد دلیل دننه کړئ:', 'دلیل رد را وارد کنید:') ?>');
    if (reason) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?route=planning/reject-change-request&id=' + id;
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'reason';
        input.value = reason;
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>