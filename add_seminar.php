<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('add_seminar');

global $isRTL;
?>

<div class="card-enter">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="index.php?route=planning/seminars" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Seminars', 'بیرته سیمینارونو ته', 'بازگشت به سمینارها') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Add New Seminar', 'نوی سیمینار اضافه کړئ', 'افزودن سمینار جدید') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Organize an academic seminar or event', 'یو اکاډمیک سیمینار یا پیښه تنظیم کړئ', 'سازماندهی یک سمینار یا رویداد آکادمیک') ?></p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <form method="POST" action="index.php?route=planning/add-seminar" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Seminar Title', 'د سیمینار سرلیک', 'عنوان سمینار') ?> <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Enter seminar title', 'د سیمینار سرلیک دننه کړئ', 'عنوان سمینار را وارد کنید') ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Description', 'تشریح', 'توضیحات') ?></label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Describe the seminar purpose and content...', 'د سیمینار هدف او محتوا تشریح کړئ...', 'هدف و محتوای سمینار را توضیح دهید...') ?>"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Speaker Name', 'د ویاند نوم', 'نام سخنران') ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="speaker_name" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Full name of speaker', 'د ویاند بشپړ نوم', 'نام کامل سخنران') ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Speaker Designation', 'د ویاند دنده', 'سمت سخنران') ?></label>
                        <input type="text" name="speaker_designation" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('e.g., Professor, Director, Expert', 'د مثال په توګه: پروفیسور، مدیر، متخصص', 'مثال: پروفیسور، مدیر، متخصص') ?>">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Venue', 'ځای', 'مکان') ?> <span class="text-red-500">*</span></label>
                    <input type="text" name="venue" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Conference Hall, Auditorium, etc.', 'کنفرانس تالار، آډیټوریم، او نور', 'سالن کنفرانس، آمفی تئاتر و غیره') ?>">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Date', 'نیټه', 'تاریخ') ?> <span class="text-red-500">*</span></label>
                        <input type="date" name="schedule_date" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Start Time', 'پیل وخت', 'زمان شروع') ?> <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('End Time', 'پای وخت', 'زمان پایان') ?> <span class="text-red-500">*</span></label>
                        <input type="time" name="end_time" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Target Audience', 'هدف لیدونکي', 'مخاطبین هدف') ?></label>
                    <textarea name="target_audience" rows="2" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('Students, Faculty, Staff, etc.', 'زده کونکي، پوهنځي، کارکوونکي، او نور', 'دانشجویان، اساتید، کارکنان و غیره') ?>"></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-save-line"></i>
                        <span><?= __t('Create Seminar', 'سیمینار جوړ کړئ', 'ایجاد سمینار') ?></span>
                    </button>
                    <a href="index.php?route=planning/seminars" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2.5 rounded-lg transition">
                        <?= __t('Cancel', 'لغوه کول', 'لغو') ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>