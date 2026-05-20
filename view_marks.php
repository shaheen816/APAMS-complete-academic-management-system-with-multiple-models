<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('enter_marks');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <a href="index.php?route=planning/marks-workflow" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Workflow', 'بیرته کاري بهیر ته', 'بازگشت به جریان کاری') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= htmlspecialchars($exam['exam_name']) ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                <?= htmlspecialchars($exam['course_code']) ?> - <?= htmlspecialchars($exam['course_name']) ?> 
                (<?= $exam['credits'] ?> <?= __t('credits', 'کریډیټونه', 'کریڈٹ') ?>)
            </p>
        </div>
        
        <?php if($canEdit): ?>
        <button type="submit" form="marksForm" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
            <i class="ri-save-line"></i>
            <span><?= __t('Save Marks', 'نمرې خوندي کړئ', 'ذخیره نمرات') ?></span>
        </button>
        <?php elseif($canApproveCommittee): ?>
        <button onclick="openApproveModal('committee')" class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
            <i class="ri-check-line"></i>
            <span><?= __t('Approve as Committee', 'د کمیټې په توګه تصویب کړئ', 'تایید به عنوان کمیته') ?></span>
        </button>
        <?php elseif($canApprovePlanning): ?>
        <button onclick="openApproveModal('planning')" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
            <i class="ri-check-double-line"></i>
            <span><?= __t('Final Approval', 'وروستی تصویب', 'تایید نهایی') ?></span>
        </button>
        <?php endif; ?>
    </div>

    <!-- Exam Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
            <div class="flex items-center gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-group-line text-2xl text-indigo-500"></i>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Total Students', 'ټول زده کونکي', 'کل دانشجویان') ?></p>
                    <p class="text-xl font-bold text-gray-800 dark:text-white"><?= count($marks) ?></p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
            <div class="flex items-center gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-edit-line text-2xl text-green-500"></i>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Marks Entered', 'نمرې داخلې شوې', 'نمرات وارد شده') ?></p>
                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                        <?php $enteredCount = count(array_filter($marks, fn($m) => $m['marks_theory'] !== null || $m['marks_practical'] !== null)); ?>
                        <?= $enteredCount ?> / <?= count($marks) ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
            <div class="flex items-center gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-file-list-line text-2xl text-purple-500"></i>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Completion', 'بشپړتیا', 'تکمیل') ?></p>
                    <p class="text-xl font-bold text-gray-800 dark:text-white"><?= round(($enteredCount / max(count($marks), 1)) * 100) ?>%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Marks Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <form method="POST" action="index.php?route=planning/save-marks" id="marksForm">
                <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Enrollment', 'نوم لیکنه', 'شماره ثبت') ?></th>
                            <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Name', 'نوم', 'نام') ?></th>
                            <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Block', 'بلاک', 'بلاک') ?></th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Theory Marks', 'نظري نمرې', 'نمرات تیوری') ?></th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Practical Marks', 'عملي نمرې', 'نمرات عملی') ?></th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Total', 'ټول', 'مجموع') ?></th>
                            <?php if($canEdit): ?>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Actions', 'عملونه', 'عملیات') ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php foreach($marks as $mark): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-3 text-sm font-mono text-indigo-600 dark:text-indigo-400"><?= htmlspecialchars($mark['enrollment_number']) ?></td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($mark['first_name'] . ' ' . $mark['last_name']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($mark['block_code'] ?? '-') ?></td>
                            <td class="px-4 py-3 text-center">
                                <?php if($canEdit): ?>
                                    <input type="number" name="marks[<?= $mark['cadet_id'] ?>][theory]" value="<?= $mark['marks_theory'] ?>" step="0.01" class="w-24 px-2 py-1 text-center border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                                <?php else: ?>
                                    <span class="text-sm font-medium"><?= $mark['marks_theory'] ?? '-' ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <?php if($canEdit): ?>
                                    <input type="number" name="marks[<?= $mark['cadet_id'] ?>][practical]" value="<?= $mark['marks_practical'] ?>" step="0.01" class="w-24 px-2 py-1 text-center border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                                <?php else: ?>
                                    <span class="text-sm font-medium"><?= $mark['marks_practical'] ?? '-' ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex px-2 py-1 text-sm font-bold rounded-lg <?= ($mark['total_marks'] ?? 0) >= 50 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' ?>">
                                    <?= $mark['total_marks'] ?? '-' ?>
                                </span>
                            </td>
                            <?php if($canEdit): ?>
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="requestChange(<?= $mark['id'] ?>)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 transition" title="<?= __t('Request Change', 'د بدلون غوښتنه', 'درخواست تغییر') ?>">
                                    <i class="ri-chat-history-line text-lg"></i>
                                </button>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white" id="modalTitle"><?= __t('Approve Marks', 'نمرې تصویب کړئ', 'تایید نمرات') ?></h3>
        </div>
        <form method="POST" action="" id="approveForm" class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Remarks', 'تبصره', 'ملاحظات') ?></label>
                <textarea name="remarks" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Optional remarks...', 'اختیاري تبصرې...', 'ملاحظات اختیاری...') ?>"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition flex-1"><?= __t('Confirm Approval', 'تصویب تایید کړئ', 'تایید نهایی') ?></button>
                <button type="button" onclick="document.getElementById('approveModal').classList.add('hidden')" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2 rounded-lg transition"><?= __t('Cancel', 'لغوه کول', 'لغو') ?></button>
            </div>
        </form>
    </div>
</div>

<script>
function openApproveModal(type) {
    const modal = document.getElementById('approveModal');
    const form = document.getElementById('approveForm');
    const examId = <?= $exam['id'] ?>;
    
    if (type === 'committee') {
        form.action = 'index.php?route=planning/approve-committee-marks&exam_id=' + examId;
    } else {
        form.action = 'index.php?route=planning/approve-planning-marks&exam_id=' + examId;
    }
    
    modal.classList.remove('hidden');
}

function requestChange(markId) {
    window.location.href = 'index.php?route=planning/request-mark-change&exam_mark_id=' + markId;
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>