<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('edit_meeting_report');

global $isRTL;
?>

<div class="card-enter">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="index.php?route=planning/view-meeting-report&id=<?= $report['id'] ?>" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Report', 'بیرته رپوټ ته', 'بازگشت به گزارش') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Edit Meeting Report', 'د غونډې رپوټ سمول', 'ویرایش گزارش جلسه') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Update meeting report details', 'د غونډې رپوټ توضیحات تازه کړئ', 'به‌روزرسانی جزئیات گزارش جلسه') ?></p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <form method="POST" action="index.php?route=planning/edit-meeting-report&id=<?= $report['id'] ?>" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Meeting Title', 'د غونډې سرلیک', 'عنوان جلسه') ?> <span class="text-red-500">*</span></label>
                    <input type="text" name="meeting_title" value="<?= htmlspecialchars($report['meeting_title']) ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Meeting Date', 'د غونډې نیټه', 'تاریخ جلسه') ?> <span class="text-red-500">*</span></label>
                        <input type="date" name="meeting_date" value="<?= $report['meeting_date'] ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Meeting Type', 'د غونډې ډول', 'نوع جلسه') ?> <span class="text-red-500">*</span></label>
                        <select name="meeting_type" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            <option value="ACADEMIC" <?= $report['meeting_type'] == 'ACADEMIC' ? 'selected' : '' ?>><?= __t('Academic', 'اکاډمیک', 'آکادمیک') ?></option>
                            <option value="ADMINISTRATIVE" <?= $report['meeting_type'] == 'ADMINISTRATIVE' ? 'selected' : '' ?>><?= __t('Administrative', 'اداري', 'اداری') ?></option>
                            <option value="DISCIPLINARY" <?= $report['meeting_type'] == 'DISCIPLINARY' ? 'selected' : '' ?>><?= __t('Disciplinary', 'انضباطي', 'انضباطی') ?></option>
                            <option value="PLANNING" <?= $report['meeting_type'] == 'PLANNING' ? 'selected' : '' ?>><?= __t('Planning', 'پلان', 'پلان‌سازی') ?></option>
                            <option value="OTHER" <?= $report['meeting_type'] == 'OTHER' ? 'selected' : '' ?>><?= __t('Other', 'نور', 'سایر') ?></option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Submitted To', 'ورکړل شوی', 'ارسال به') ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="submitted_to" value="<?= htmlspecialchars($report['submitted_to']) ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Agenda', 'اجنډا', 'دستور جلسه') ?> <span class="text-red-500">*</span></label>
                    <textarea name="agenda" rows="4" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"><?= htmlspecialchars($report['agenda']) ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Minutes / Discussion Summary', 'دقیقې / د بحث لنډیز', 'صورتجلسه / خلاصه بحث') ?> <span class="text-red-500">*</span></label>
                    <textarea name="minutes" rows="6" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"><?= htmlspecialchars($report['minutes']) ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Decisions Made', 'شوي پریکړې', 'تصمیمات اتخاذ شده') ?></label>
                    <textarea name="decisions" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"><?= htmlspecialchars($report['decisions'] ?? '') ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Action Items', 'عملي اقدامات', 'اقدامات عملی') ?></label>
                    <textarea name="action_items" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"><?= htmlspecialchars($report['action_items'] ?? '') ?></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-save-line"></i>
                        <span><?= __t('Update Report', 'رپوټ تازه کړئ', 'به‌روزرسانی گزارش') ?></span>
                    </button>
                    <a href="index.php?route=planning/view-meeting-report&id=<?= $report['id'] ?>" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2.5 rounded-lg transition">
                        <?= __t('Cancel', 'لغوه کول', 'لغو') ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>