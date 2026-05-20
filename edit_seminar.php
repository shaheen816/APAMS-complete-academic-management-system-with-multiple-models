<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('edit_seminar');

global $isRTL;
?>

<div class="card-enter">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="index.php?route=planning/view-seminar&id=<?= $seminar['id'] ?>" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Seminar', 'بیرته سیمینار ته', 'بازگشت به سمینار') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Edit Seminar', 'سیمینار سمول', 'ویرایش سمینار') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Update seminar details', 'د سیمینار توضیحات تازه کړئ', 'به‌روزرسانی جزئیات سمینار') ?></p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <form method="POST" action="index.php?route=planning/edit-seminar&id=<?= $seminar['id'] ?>" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Seminar Title', 'د سیمینار سرلیک', 'عنوان سمینار') ?> <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="<?= htmlspecialchars($seminar['title']) ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Description', 'تشریح', 'توضیحات') ?></label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"><?= htmlspecialchars($seminar['description'] ?? '') ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Speaker Name', 'د ویاند نوم', 'نام سخنران') ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="speaker_name" value="<?= htmlspecialchars($seminar['speaker_name']) ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Speaker Designation', 'د ویاند دنده', 'سمت سخنران') ?></label>
                        <input type="text" name="speaker_designation" value="<?= htmlspecialchars($seminar['speaker_designation'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Venue', 'ځای', 'مکان') ?> <span class="text-red-500">*</span></label>
                    <input type="text" name="venue" value="<?= htmlspecialchars($seminar['venue']) ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Date', 'نیټه', 'تاریخ') ?> <span class="text-red-500">*</span></label>
                        <input type="date" name="schedule_date" value="<?= $seminar['schedule_date'] ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Start Time', 'پیل وخت', 'زمان شروع') ?> <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" value="<?= $seminar['start_time'] ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('End Time', 'پای وخت', 'زمان پایان') ?> <span class="text-red-500">*</span></label>
                        <input type="time" name="end_time" value="<?= $seminar['end_time'] ?>" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Target Audience', 'هدف لیدونکي', 'مخاطبین هدف') ?></label>
                    <textarea name="target_audience" rows="2" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"><?= htmlspecialchars($seminar['target_audience'] ?? '') ?></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-save-line"></i>
                        <span><?= __t('Update Seminar', 'سیمینار تازه کړئ', 'به‌روزرسانی سمینار') ?></span>
                    </button>
                    <a href="index.php?route=planning/view-seminar&id=<?= $seminar['id'] ?>" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2.5 rounded-lg transition">
                        <?= __t('Cancel', 'لغوه کول', 'لغو') ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>