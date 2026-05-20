<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('add_meeting_report');

global $isRTL;
?>

<div class="card-enter">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="index.php?route=planning/meeting-reports" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Reports', 'بیرته رپوټونو ته', 'بازگشت به گزارشات') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Add Meeting Report', 'د غونډې رپوټ اضافه کړئ', 'افزودن گزارش جلسه') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Document official meeting minutes and decisions', 'رسمي غونډې دقیقې او پریکړې ثبت کړئ', 'ثبت صورتجلسه و تصمیمات جلسات رسمی') ?></p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <form method="POST" action="index.php?route=planning/add-meeting-report" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Meeting Title', 'د غونډې سرلیک', 'عنوان جلسه') ?> <span class="text-red-500">*</span></label>
                    <input type="text" name="meeting_title" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Enter meeting title', 'د غونډې سرلیک دننه کړئ', 'عنوان جلسه را وارد کنید') ?>">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Meeting Date', 'د غونډې نیټه', 'تاریخ جلسه') ?> <span class="text-red-500">*</span></label>
                        <input type="date" name="meeting_date" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Meeting Type', 'د غونډې ډول', 'نوع جلسه') ?> <span class="text-red-500">*</span></label>
                        <select name="meeting_type" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            <option value="ACADEMIC"><?= __t('Academic', 'اکاډمیک', 'آکادمیک') ?></option>
                            <option value="ADMINISTRATIVE"><?= __t('Administrative', 'اداري', 'اداری') ?></option>
                            <option value="DISCIPLINARY"><?= __t('Disciplinary', 'انضباطي', 'انضباطی') ?></option>
                            <option value="PLANNING"><?= __t('Planning', 'پلان', 'پلان‌سازی') ?></option>
                            <option value="OTHER"><?= __t('Other', 'نور', 'سایر') ?></option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Submitted To', 'ورکړل شوی', 'ارسال به') ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="submitted_to" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('e.g., Commander, Academic Director', 'د مثال په توګه: قوماندان، اکاډمیک رییس', 'مثال: فرماندهی، رئیس آکادمیک') ?>">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Agenda', 'اجنډا', 'دستور جلسه') ?> <span class="text-red-500">*</span></label>
                    <textarea name="agenda" rows="4" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('List the topics discussed in the meeting', 'په غونډه کې بحث شوي موضوعات لیست کړئ', 'لیست موضوعات مطرح شده در جلسه') ?>"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Minutes / Discussion Summary', 'دقیقې / د بحث لنډیز', 'صورتجلسه / خلاصه بحث') ?> <span class="text-red-500">*</span></label>
                    <textarea name="minutes" rows="6" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Detailed summary of the meeting discussions', 'د غونډې بحثونو مفصل لنډیز', 'خلاصه دقیق بحث‌های جلسه') ?>"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Decisions Made', 'شوي پریکړې', 'تصمیمات اتخاذ شده') ?></label>
                    <textarea name="decisions" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('List all decisions made during the meeting', 'په غونډه کې شوي ټول پریکړې لیست کړئ', 'لیست تمام تصمیمات اتخاذ شده در جلسه') ?>"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Action Items', 'عملي اقدامات', 'اقدامات عملی') ?></label>
                    <textarea name="action_items" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('List action items, responsible persons, and deadlines', 'عملي اقدامات، مسؤلین او وخت نیټې لیست کړئ', 'لیست اقدامات عملی، افراد مسئول و ضرب الاجل‌ها') ?>"></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-save-line"></i>
                        <span><?= __t('Save Report', 'رپوټ خوندي کړئ', 'ذخیره گزارش') ?></span>
                    </button>
                    <a href="index.php?route=planning/meeting-reports" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2.5 rounded-lg transition">
                        <?= __t('Cancel', 'لغوه کول', 'لغو') ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>