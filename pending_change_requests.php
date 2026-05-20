<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('pending_change_requests');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Pending Mark Change Requests', 'د نمرې د بدلون ځنډول شوي غوښتنې', 'درخواست‌های تغییر نمره در انتظار') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                <?php if($role === 'EXAM_COMMITTEE'): ?>
                    <?= __t('Review and approve/reject mark change requests from instructors', 'د ښوونکو څخه د نمرې د بدلون غوښتنې بیاکتنه او تصویب/رد کړئ', 'بررسی و تایید/رد درخواست‌های تغییر نمره از استادان') ?>
                <?php else: ?>
                    <?= __t('Final approval of mark changes after committee review', 'د کمیټې له بیاکتنې وروسته د نمرې د بدلون وروستی تصویب', 'تایید نهایی تغییرات نمرات پس از بررسی کمیته') ?>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Change Requests Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Student', 'زده کونکی', 'دانشجو') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Course', 'کورس', 'کورس') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Old Marks', 'پخوانۍ نمرې', 'نمرات قدیم') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('New Marks', 'نوي نمرې', 'نمرات جدید') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Reason', 'دلیل', 'دلیل') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Requested By', 'غوښتونکی', 'درخواست دهنده') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Actions', 'عملونه', 'عملیات') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if(!empty($requests)): ?>
                        <?php foreach($requests as $request): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($request['first_name'] . ' ' . $request['last_name']) ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars($request['enrollment_number']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($request['course_code']) ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars($request['course_name']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm">T: <?= $request['old_marks_theory'] ?? '-' ?></span><br>
                                <span class="text-sm">P: <?= $request['old_marks_practical'] ?? '-' ?></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-green-600 dark:text-green-400">T: <?= $request['new_marks_theory'] ?></span><br>
                                <span class="text-sm font-bold text-green-600 dark:text-green-400">P: <?= $request['new_marks_practical'] ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 max-w-xs">
                                <?= nl2br(htmlspecialchars(substr($request['reason'], 0, 100))) ?>
                                <?php if(strlen($request['reason']) > 100): ?>...<?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($request['requested_by_name']) ?><br><span class="text-xs text-gray-500"><?= date('M d, Y', strtotime($request['requested_at'])) ?></span></td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <button onclick="openApproveModal(<?= $request['id'] ?>)" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm transition inline-flex items-center gap-1">
                                        <i class="ri-check-line"></i>
                                        <span><?= __t('Approve', 'تصویب', 'تایید') ?></span>
                                    </button>
                                    <button onclick="openRejectModal(<?= $request['id'] ?>)" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-sm transition inline-flex items-center gap-1">
                                        <i class="ri-close-line"></i>
                                        <span><?= __t('Reject', 'رد', 'رد') ?></span>
                                    </button>
                                    <button onclick="viewDetails(<?= $request['id'] ?>)" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded-lg text-sm transition inline-flex items-center gap-1">
                                        <i class="ri-eye-line"></i>
                                        <span><?= __t('View', 'کتل', 'مشاهده') ?></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class="ri-chat-check-line text-5xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                                <p class="text-gray-500 dark:text-gray-400"><?= __t('No pending change requests', 'د بدلون ځنډول شوې غوښتنې نشته', 'هیچ درخواست تغییر در انتظاری وجود ندارد') ?></p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Approve Change Request', 'د بدلون غوښتنه تصویب کړئ', 'تایید درخواست تغییر') ?></h3>
        </div>
        <form method="POST" action="" id="approveForm" class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Remarks', 'تبصره', 'ملاحظات') ?></label>
                <textarea name="remarks" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Add your approval remarks...', 'د خپل تصویب تبصرې اضافه کړئ...', 'ملاحظات تایید خود را اضافه کنید...') ?>"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition flex-1"><?= __t('Approve', 'تصویب', 'تایید') ?></button>
                <button type="button" onclick="document.getElementById('approveModal').classList.add('hidden')" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2 rounded-lg transition"><?= __t('Cancel', 'لغوه کول', 'لغو') ?></button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Reject Change Request', 'د بدلون غوښتنه رد کړئ', 'رد درخواست تغییر') ?></h3>
        </div>
        <form method="POST" action="" id="rejectForm" class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Rejection Reason', 'د رد دلیل', 'دلیل رد') ?> <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="3" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Explain why this request is rejected...', 'تشریح کړئ چې ولې دا غوښتنه رد شوې...', 'توضیح دهید چرا این درخواست رد می‌شود...') ?>"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition flex-1"><?= __t('Reject', 'رد', 'رد') ?></button>
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2 rounded-lg transition"><?= __t('Cancel', 'لغوه کول', 'لغو') ?></button>
            </div>
        </form>
    </div>
</div>

<script>
let currentRequestId = null;

function openApproveModal(requestId) {
    currentRequestId = requestId;
    const modal = document.getElementById('approveModal');
    const form = document.getElementById('approveForm');
    form.action = 'index.php?route=planning/approve-change-request&id=' + requestId;
    modal.classList.remove('hidden');
}

function openRejectModal(requestId) {
    currentRequestId = requestId;
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = 'index.php?route=planning/reject-change-request&id=' + requestId;
    modal.classList.remove('hidden');
}

function viewDetails(requestId) {
    window.location.href = 'index.php?route=planning/view-change-request&id=' + requestId;
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>