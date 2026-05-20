<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('view_meeting_report');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div class="<?= $isRTL ? 'text-right' : '' ?>">
                <a href="index.php?route=planning/meeting-reports" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-arrow-left-line"></i>
                    <span><?= __t('Back to Reports', 'بیرته رپوټونو ته', 'بازگشت به گزارشات') ?></span>
                </a>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= htmlspecialchars($report['meeting_title']) ?></h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Meeting Code', 'د غونډې کوډ', 'کد جلسه') ?>: <?= htmlspecialchars($report['meeting_code']) ?></p>
            </div>
            <div class="flex gap-3">
                <?php if($role === 'PLANNING_MANAGER'): ?>
                    <a href="index.php?route=planning/edit-meeting-report&id=<?= $report['id'] ?>" class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-edit-line"></i>
                        <span><?= __t('Edit', 'سمول', 'ویرایش') ?></span>
                    </a>
                    <button onclick="printReport(<?= $report['id'] ?>)" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-printer-line"></i>
                        <span><?= __t('Print', 'چاپول', 'چاپ') ?></span>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Meeting Details -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 space-y-6">
                <!-- Meta Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Meeting Type', 'د غونډې ډول', 'نوع جلسه') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white">
                            <?php if($report['meeting_type'] == 'ACADEMIC'): ?>
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200"><?= __t('Academic', 'اکاډمیک', 'آکادمیک') ?></span>
                            <?php elseif($report['meeting_type'] == 'ADMINISTRATIVE'): ?>
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"><?= __t('Administrative', 'اداري', 'اداری') ?></span>
                            <?php elseif($report['meeting_type'] == 'DISCIPLINARY'): ?>
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200"><?= __t('Disciplinary', 'انضباطي', 'انضباطی') ?></span>
                            <?php elseif($report['meeting_type'] == 'PLANNING'): ?>
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200"><?= __t('Planning', 'پلان', 'پلان‌سازی') ?></span>
                            <?php else: ?>
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400"><?= __t('Other', 'نور', 'سایر') ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Meeting Date', 'د غونډې نیټه', 'تاریخ جلسه') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= date('l, F d, Y', strtotime($report['meeting_date'])) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Submitted To', 'ورکړل شوی', 'ارسال به') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($report['submitted_to']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Submitted By', 'لخوا سپارل شوی', 'ارسال شده توسط') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($report['submitted_by_name']) ?></p>
                    </div>
                </div>

                <!-- Agenda -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 flex items-center gap-2">
                        <i class="ri-list-check text-indigo-500"></i>
                        <?= __t('Agenda', 'اجنډا', 'دستور جلسه') ?>
                    </h3>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <?= nl2br(htmlspecialchars($report['agenda'])) ?>
                    </div>
                </div>

                <!-- Minutes -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 flex items-center gap-2">
                        <i class="ri-file-text-line text-indigo-500"></i>
                        <?= __t('Minutes / Discussion Summary', 'دقیقې / د بحث لنډیز', 'صورتجلسه / خلاصه بحث') ?>
                    </h3>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <?= nl2br(htmlspecialchars($report['minutes'])) ?>
                    </div>
                </div>

                <!-- Decisions -->
                <?php if($report['decisions']): ?>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 flex items-center gap-2">
                        <i class="ri-gavel-line text-indigo-500"></i>
                        <?= __t('Decisions Made', 'شوي پریکړې', 'تصمیمات اتخاذ شده') ?>
                    </h3>
                    <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <?= nl2br(htmlspecialchars($report['decisions'])) ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Items -->
                <?php if($report['action_items']): ?>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 flex items-center gap-2">
                        <i class="ri-task-line text-indigo-500"></i>
                        <?= __t('Action Items', 'عملي اقدامات', 'اقدامات عملی') ?>
                    </h3>
                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <?= nl2br(htmlspecialchars($report['action_items'])) ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Footer -->
                <div class="text-right text-sm text-gray-500 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <?= __t('Report generated on', 'رپوټ په جوړ شوی', 'گزارش تولید شده در') ?>: <?= date('F d, Y h:i A', strtotime($report['submitted_at'])) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printReport(id) {
    window.open('index.php?route=planning/print-meeting-report&id=' + id, '_blank');
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>