<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('request_diploma');

global $isRTL;
$cadetId = $_GET['cadet_id'] ?? 0;
?>

<div class="card-enter">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="index.php?route=planning/diplomas" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Diplomas', 'بیرته ډیپلومونو ته', 'بازگشت به دیپلوم‌ها') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Request Diploma', 'د ډیپلوم غوښتنه', 'درخواست دیپلوم') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Submit a request for your diploma after completing all requirements', 'د ټولو اړتیاوو بشپړولو وروسته د خپل ډیپلوم لپاره غوښتنه وسپارئ', 'درخواست دیپلوم خود را پس از تکمیل تمام الزامات ارسال کنید') ?></p>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-lg mb-6 <?= $isRTL ? 'border-r-4 border-l-0' : '' ?>">
            <div class="flex items-start gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-information-line text-blue-600 dark:text-blue-400 text-xl"></i>
                <div class="text-sm text-blue-700 dark:text-blue-300">
                    <p class="font-medium mb-1"><?= __t('Before requesting your diploma:', 'د ډیپلوم غوښتنه کولو دمخه:', 'قبل از درخواست دیپلوم:') ?></p>
                    <ul class="list-disc <?= $isRTL ? 'mr-4' : 'ml-4' ?> space-y-1">
                        <li><?= __t('Ensure all marks are approved by Planning Department', 'ډاډ ترلاسه کړئ چې ټولې نمرې د پلان ریاست لخوا تصویب شوي', 'اطمینان حاصل کنید که تمام نمرات توسط ریاست پلان تایید شده است') ?></li>
                        <li><?= __t('Your transcript must be generated and locked', 'ستاسو ټرانسکرپټ باید جوړ او تال شوی وي', 'ریزنمرات شما باید ایجاد و قفل شده باشد') ?></li>
                        <li><?= __t('All fees and library dues must be cleared', 'ټولې فیسان او کتابتون پورونه باید تصفیه شوي وي', 'تمام شهریه‌ها و بدهی‌های کتابخانه باید تسویه شده باشد') ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <form method="POST" action="index.php?route=planning/request-diploma&cadet_id=<?= $cadetId ?>" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Graduation Date', 'د فراغت نیټه', 'تاریخ فارغ‌التحصیلی') ?> <span class="text-red-500">*</span></label>
                    <input type="date" name="graduation_date" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Degree', 'سان', 'مدرک') ?> <span class="text-red-500">*</span></label>
                    <select name="degree" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value=""><?= __t('Select Degree', 'سان انتخاب کړئ', 'انتخاب مدرک') ?></option>
                        <option value="Bachelor of Science"><?= __t('Bachelor of Science', 'د ساینس لیسانس', 'لیسانس علوم') ?></option>
                        <option value="Bachelor of Arts"><?= __t('Bachelor of Arts', 'د هنر لیسانس', 'لیسانس هنر') ?></option>
                        <option value="Diploma"><?= __t('Diploma', 'ډیپلوم', 'دیپلوم') ?></option>
                        <option value="Certificate"><?= __t('Certificate', 'تصدیق پاڼه', 'گواهینامه') ?></option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Specialization', 'تخصص', 'تخصص') ?></label>
                    <input type="text" name="specialization" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="<?= __t('e.g., Computer Science, Law, Criminal Justice', 'د مثال په توګه: کمپیوټر ساینس، حقوق، عدلي تحقیق', 'مثال: علوم کامپیوتر، حقوق، عدالت کیفری') ?>">
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 rounded <?= $isRTL ? 'border-r-4 border-l-0' : '' ?>">
                    <div class="flex items-start gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-alert-line text-yellow-600 dark:text-yellow-400 text-xl"></i>
                        <div class="text-sm text-yellow-700 dark:text-yellow-300">
                            <p class="font-medium mb-1"><?= __t('Approval Process', 'د تصویب پروسه', 'فرآیند تایید') ?>:</p>
                            <ul class="list-disc <?= $isRTL ? 'mr-4' : 'ml-4' ?> space-y-1">
                                <li><?= __t('Planning Manager reviews and approves first', 'د پلان مدیر لومړی بیاکتنه او تصویب کوي', 'مدیر پلان ابتدا بررسی و تایید می‌کند') ?></li>
                                <li><?= __t('Academic Directorate gives second approval', 'اکاډمیک ریاست دوهم تصویب ورکوي', 'ریاست اکادمیک تایید دوم را ارائه می‌دهد') ?></li>
                                <li><?= __t('General Commandant gives final approval', 'عمومي قوماندان وروستی تصویب ورکوي', 'فرمانده عمومی تایید نهایی را ارائه می‌دهد') ?></li>
                                <li><?= __t('Diploma is issued and can be printed', 'ډیپلوم صادر او چاپ کیدی شي', 'دیپلوم صادر و قابل چاپ می‌شود') ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                        <i class="ri-send-plane-line"></i>
                        <span><?= __t('Submit Request', 'غوښتنه وسپارئ', 'ارسال درخواست') ?></span>
                    </button>
                    <a href="index.php?route=planning/diplomas" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2.5 rounded-lg transition">
                        <?= __t('Cancel', 'لغوه کول', 'لغو') ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>