<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('view_seminar');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div class="<?= $isRTL ? 'text-right' : '' ?>">
                <a href="index.php?route=planning/seminars" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-arrow-left-line"></i>
                    <span><?= __t('Back to Seminars', 'بیرته سیمینارونو ته', 'بازگشت به سمینارها') ?></span>
                </a>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= htmlspecialchars($seminar['title']) ?></h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Seminar Code', 'د سیمینار کوډ', 'کد سمینار') ?>: <?= htmlspecialchars($seminar['seminar_code']) ?></p>
            </div>
            <div class="flex gap-3">
                <?php if($role === 'PLANNING_MANAGER'): ?>
                    <a href="index.php?route=planning/edit-seminar&id=<?= $seminar['id'] ?>" class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-edit-line"></i>
                        <span><?= __t('Edit', 'سمول', 'ویرایش') ?></span>
                    </a>
                    <?php if($seminar['status'] == 'PLANNED'): ?>
                    <button onclick="completeSeminar(<?= $seminar['id'] ?>)" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-check-double-line"></i>
                        <span><?= __t('Mark Complete', 'بشپړ په نښه کړئ', 'علامت گذاری به عنوان تکمیل') ?></span>
                    </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Seminar Details -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 space-y-6">
                <!-- Status Banner -->
                <div class="p-4 rounded-lg <?= $seminar['status'] == 'PLANNED' ? 'bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500' : ($seminar['status'] == 'COMPLETED' ? 'bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500' : 'bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500') ?>">
                    <div class="flex items-center gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-information-line text-xl"></i>
                        <div>
                            <p class="font-semibold"><?= __t('Status', 'حالت', 'وضعیت') ?>: 
                                <?php if($seminar['status'] == 'PLANNED'): ?>
                                    <span class="text-yellow-600 dark:text-yellow-400"><?= __t('Planned', 'پلان شوی', 'برنامه‌ریزی شده') ?></span>
                                <?php elseif($seminar['status'] == 'COMPLETED'): ?>
                                    <span class="text-green-600 dark:text-green-400"><?= __t('Completed', 'بشپړ شوی', 'تکمیل شده') ?></span>
                                <?php else: ?>
                                    <span class="text-red-600 dark:text-red-400"><?= __t('Cancelled', 'لغوه شوی', 'لغو شده') ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2"><?= __t('Description', 'تشریح', 'توضیحات') ?></h3>
                    <p class="text-gray-600 dark:text-gray-300"><?= nl2br(htmlspecialchars($seminar['description'] ?? '')) ?></p>
                </div>

                <!-- Speaker Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Speaker Name', 'د ویاند نوم', 'نام سخنران') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($seminar['speaker_name']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Speaker Designation', 'د ویاند دنده', 'سمت سخنران') ?></p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($seminar['speaker_designation'] ?? '-') ?></p>
                    </div>
                </div>

                <!-- Venue & Time -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center gap-3 p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <i class="ri-map-pin-line text-2xl text-indigo-500"></i>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Venue', 'ځای', 'مکان') ?></p>
                            <p class="font-semibold"><?= htmlspecialchars($seminar['venue']) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <i class="ri-calendar-line text-2xl text-indigo-500"></i>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Date', 'نیټه', 'تاریخ') ?></p>
                            <p class="font-semibold"><?= date('l, F d, Y', strtotime($seminar['schedule_date'])) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <i class="ri-time-line text-2xl text-indigo-500"></i>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Time', 'وخت', 'زمان') ?></p>
                            <p class="font-semibold"><?= date('h:i A', strtotime($seminar['start_time'])) ?> - <?= date('h:i A', strtotime($seminar['end_time'])) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Target Audience -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2"><?= __t('Target Audience', 'هدف لیدونکي', 'مخاطبین هدف') ?></h3>
                    <p class="text-gray-600 dark:text-gray-300"><?= nl2br(htmlspecialchars($seminar['target_audience'] ?? '-')) ?></p>
                </div>

                <!-- Report Section -->
                <?php if($seminar['report_path']): ?>
                <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex items-center justify-between <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <div class="flex items-center gap-3">
                            <i class="ri-file-pdf-line text-2xl text-red-500"></i>
                            <div>
                                <p class="font-semibold"><?= __t('Seminar Report', 'د سیمینار رپوټ', 'گزارش سمینار') ?></p>
                                <p class="text-xs text-gray-500"><?= __t('Submitted on', 'سپارل شوی په', 'ارسال شده در') ?>: <?= date('M d, Y', strtotime($seminar['report_submitted_at'])) ?></p>
                            </div>
                        </div>
                        <a href="<?= $seminar['report_path'] ?>" target="_blank" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                            <i class="ri-download-line"></i>
                            <span><?= __t('Download Report', 'رپوټ ډاونلوډ کړئ', 'دانلود گزارش') ?></span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Organizer -->
                <div class="text-right text-sm text-gray-500 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <?= __t('Organized by', 'لخوا تنظیم شوی', 'سازماندهی شده توسط') ?>: <?= htmlspecialchars($seminar['organizer_name']) ?> | 
                    <?= __t('Created on', 'په جوړ شوی', 'ایجاد شده در') ?>: <?= date('M d, Y', strtotime($seminar['created_at'])) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function completeSeminar(id) {
    if(confirm('<?= __t('Mark this seminar as completed?', 'آیا دا سیمینار بشپړ په نښه کوئ؟', 'آیا این سمینار را به عنوان تکمیل شده علامت گذاری می‌کنید؟') ?>')) {
        window.location.href = 'index.php?route=planning/complete-seminar&id=' + id;
    }
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>