<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('view_diploma');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div class="<?= $isRTL ? 'text-right' : '' ?>">
                <a href="index.php?route=planning/diplomas" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-arrow-left-line"></i>
                    <span><?= __t('Back to Diplomas', 'بیرته ډیپلومونو ته', 'بازگشت به دیپلوم‌ها') ?></span>
                </a>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Diploma Details', 'د ډیپلوم توضیحات', 'جزئیات دیپلوم') ?></h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= htmlspecialchars($diploma['diploma_number']) ?></p>
            </div>
            <div class="flex gap-3">
                <?php if($diploma['status'] == 'ISSUED'): ?>
                <a href="index.php?route=planning/download-diploma&id=<?= $diploma['id'] ?>" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-download-line"></i>
                    <span><?= __t('Download PDF', 'PDF ډاونلوډ', 'دانلود PDF') ?></span>
                </a>
                <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-printer-line"></i>
                    <span><?= __t('Print', 'چاپول', 'چاپ') ?></span>
                </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Approval Chain Status -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="text-center p-4 rounded-lg <?= $diploma['status'] != 'PENDING' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-100 dark:bg-gray-700' ?>">
                <div class="text-2xl mb-2">📋</div>
                <p class="font-semibold"><?= __t('Planning', 'پلان', 'پلان') ?></p>
                <?php if($diploma['approved_by_planning_name']): ?>
                    <p class="text-xs text-green-600 mt-1">✓ <?= htmlspecialchars($diploma['approved_by_planning_name']) ?></p>
                <?php else: ?>
                    <p class="text-xs text-gray-500 mt-1"><?= __t('Pending', 'ځنډول شوی', 'در انتظار') ?></p>
                <?php endif; ?>
            </div>
            <div class="text-center p-4 rounded-lg <?= $diploma['status'] == 'ACADEMIC_APPROVED' || $diploma['status'] == 'COMMANDER_APPROVED' || $diploma['status'] == 'ISSUED' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-100 dark:bg-gray-700' ?>">
                <div class="text-2xl mb-2">🎓</div>
                <p class="font-semibold"><?= __t('Academic', 'اکاډمیک', 'اکادمیک') ?></p>
                <?php if($diploma['approved_by_academic_name']): ?>
                    <p class="text-xs text-green-600 mt-1">✓ <?= htmlspecialchars($diploma['approved_by_academic_name']) ?></p>
                <?php else: ?>
                    <p class="text-xs text-gray-500 mt-1"><?= __t('Pending', 'ځنډول شوی', 'در انتظار') ?></p>
                <?php endif; ?>
            </div>
            <div class="text-center p-4 rounded-lg <?= $diploma['status'] == 'COMMANDER_APPROVED' || $diploma['status'] == 'ISSUED' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-100 dark:bg-gray-700' ?>">
                <div class="text-2xl mb-2">👨‍✈️</div>
                <p class="font-semibold"><?= __t('Commander', 'قوماندان', 'فرماندهی') ?></p>
                <?php if($diploma['approved_by_commander_name']): ?>
                    <p class="text-xs text-green-600 mt-1">✓ <?= htmlspecialchars($diploma['approved_by_commander_name']) ?></p>
                <?php else: ?>
                    <p class="text-xs text-gray-500 mt-1"><?= __t('Pending', 'ځنډول شوی', 'در انتظار') ?></p>
                <?php endif; ?>
            </div>
            <div class="text-center p-4 rounded-lg <?= $diploma['status'] == 'ISSUED' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-100 dark:bg-gray-700' ?>">
                <div class="text-2xl mb-2">✅</div>
                <p class="font-semibold"><?= __t('Issued', 'صادر شوی', 'صادر شده') ?></p>
                <?php if($diploma['issued_date']): ?>
                    <p class="text-xs text-green-600 mt-1"><?= date('M d, Y', strtotime($diploma['issued_date'])) ?></p>
                <?php else: ?>
                    <p class="text-xs text-gray-500 mt-1"><?= __t('Pending', 'ځنډول شوی', 'در انتظار') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Diploma Content -->
        <div id="diploma-content" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="p-8 border-4 border-double border-indigo-300 dark:border-indigo-700 m-4">
                <div class="text-center">
                    <div class="text-5xl mb-4">🎓</div>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white"><?= __t('AFGHANISTAN POLICE ACADEMY', 'افغانستان پولیس اکاډمۍ', 'آکادمی پولیس افغانستان') ?></h2>
                    <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mt-2"><?= __t('Certificate of Graduation', 'د فراغت سند', 'گواهی فارغ‌التحصیلی') ?></h3>
                    
                    <div class="my-8">
                        <p class="text-lg"><?= __t('This is to certify that', 'دا تصدیق کیږي چې', 'این گواهی می‌دهد که') ?></p>
                        <p class="text-3xl font-bold text-indigo-700 dark:text-indigo-400 my-4 uppercase"><?= htmlspecialchars($diploma['first_name'] . ' ' . $diploma['last_name']) ?></p>
                        <p class="text-lg"><?= __t('has successfully completed the requirements for the degree of', 'په بریالیتوب سره د سان اړتیاوې پوره کړي دي', 'با موفقیت الزامات مدرک را تکمیل کرده است') ?></p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white my-4"><?= htmlspecialchars($diploma['degree']) ?></p>
                        <p class="text-lg"><?= __t('in', 'په', 'در') ?></p>
                        <p class="text-xl font-semibold text-gray-700 dark:text-gray-300 my-2"><?= htmlspecialchars($diploma['specialization'] ?? __t('General Studies', 'عمومي مطالعات', 'مطالعات عمومی')) ?></p>
                        <p class="text-lg mt-4"><?= __t('with all the rights, privileges, and responsibilities thereunto appertaining.', 'د ټولو حقونو، امتیازاتو او مسؤلیتونو سره.', 'با تمام حقوق، امتیازات و مسئولیت‌های مربوطه.') ?></p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div>
                            <div class="border-t border-gray-400 pt-2 mt-8"><?= date('F d, Y', strtotime($diploma['issued_date'] ?? $diploma['graduation_date'])) ?></div>
                            <p class="text-sm mt-2"><?= __t('Date', 'نیټه', 'تاریخ') ?></p>
                        </div>
                        <div>
                            <div class="border-t border-gray-400 pt-2 mt-8"></div>
                            <p class="text-sm mt-2"><?= __t('Planning Manager', 'د پلان مدیر', 'مدیر پلان') ?></p>
                        </div>
                        <div>
                            <div class="border-t border-gray-400 pt-2 mt-8"></div>
                            <p class="text-sm mt-2"><?= __t('Academic Director', 'اکاډمیک رییس', 'رئیس آکادمیک') ?></p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4">
                        <div class="border-t border-gray-400 pt-2 mt-8 w-64 mx-auto"></div>
                        <p class="text-sm mt-2"><?= __t('General Commandant', 'عمومي قوماندان', 'فرمانده عمومی') ?></p>
                    </div>

                    <div class="mt-8 pt-4 text-sm text-gray-500">
                        <p><?= __t('Diploma Number', 'ډیپلوم نمبر', 'شماره دیپلوم') ?>: <?= htmlspecialchars($diploma['diploma_number']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style media="print">
    body * { visibility: hidden; }
    #diploma-content, #diploma-content * { visibility: visible; }
    #diploma-content { position: absolute; top: 0; left: 0; width: 100%; margin: 0; padding: 0; }
    .no-print { display: none; }
    button, a { display: none; }
</style>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>