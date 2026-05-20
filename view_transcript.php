<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('view_transcript');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <a href="index.php?route=planning/transcripts" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Transcripts', 'بیرته ټرانسکرپټونو ته', 'بازگشت به ریزنمرات') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Academic Transcript', 'اکاډمیک ټرانسکرپټ', 'ریزنمرات تحصیلی') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= htmlspecialchars($transcript['transcript_number']) ?></p>
        </div>
        <div class="flex gap-3">
            <a href="index.php?route=planning/download-transcript&id=<?= $transcript['id'] ?>" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-download-line"></i>
                <span><?= __t('Download PDF', 'PDF ډاونلوډ', 'دانلود PDF') ?></span>
            </a>
            <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-printer-line"></i>
                <span><?= __t('Print', 'چاپول', 'چاپ') ?></span>
            </button>
        </div>
    </div>

    <!-- Transcript Content -->
    <div id="transcript-content" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="p-8">
            <!-- Header -->
            <div class="text-center mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                <div class="text-4xl mb-2">🎓</div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('AFGHANISTAN POLICE ACADEMY', 'افغانستان پولیس اکاډمۍ', 'آکادمی پولیس افغانستان') ?></h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1"><?= __t('Academic Transcript', 'اکاډمیک ټرانسکرپټ', 'ریزنمرات تحصیلی') ?></p>
                <p class="text-sm text-gray-500 mt-2"><?= __t('Transcript Number', 'ټرانسکرپټ نمبر', 'شماره ریزنمرات') ?>: <?= htmlspecialchars($transcript['transcript_number']) ?></p>
            </div>

            <!-- Student Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Student Name', 'د زده کونکي نوم', 'نام دانشجو') ?></p>
                    <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($transcript['first_name'] . ' ' . $transcript['last_name']) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Enrollment Number', 'د نوم لیکنې شمیره', 'شماره ثبت') ?></p>
                    <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($transcript['enrollment_number']) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Father\'s Name', 'د پلار نوم', 'نام پدر') ?></p>
                    <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($transcript['father_name'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Program', 'برنامه', 'برنامه') ?></p>
                    <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($transcript['program_name'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Date of Birth', 'د زیږون نیټه', 'تاریخ تولد') ?></p>
                    <p class="font-semibold text-gray-800 dark:text-white"><?= $transcript['date_of_birth'] ?? '-' ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= __t('Block', 'بلاک', 'بلاک') ?></p>
                    <p class="font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($transcript['block_name'] ?? '-') ?></p>
                </div>
            </div>

            <!-- Courses Table -->
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full border border-gray-200 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-sm font-semibold"><?= __t('Course Code', 'کورس کوډ', 'کد کورس') ?></th>
                            <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-sm font-semibold"><?= __t('Course Name', 'کورس نوم', 'نام کورس') ?></th>
                            <th class="px-4 py-3 text-center text-sm font-semibold"><?= __t('Credits', 'کریډیټونه', 'کریڈٹ') ?></th>
                            <th class="px-4 py-3 text-center text-sm font-semibold"><?= __t('Semester', 'سمستر', 'سمستر') ?></th>
                            <th class="px-4 py-3 text-center text-sm font-semibold"><?= __t('Grade', 'درجه', 'نمره') ?></th>
                            <th class="px-4 py-3 text-center text-sm font-semibold"><?= __t('Result', 'پایله', 'نتیجه') ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php 
                        $semesterGroups = [];
                        foreach($courses as $course) {
                            $semesterGroups[$course['semester']][] = $course;
                        }
                        ksort($semesterGroups);
                        ?>
                        <?php foreach($semesterGroups as $semNum => $semCourses): ?>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <td colspan="6" class="px-4 py-2 font-bold text-gray-800 dark:text-white"><?= __t('Semester', 'سمستر', 'سمستر') ?> <?= $semNum ?></td>
                            </tr>
                            <?php foreach($semCourses as $course): ?>
                            <tr>
                                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($course['course_code']) ?></td>
                                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($course['course_name']) ?></td>
                                <td class="px-4 py-2 text-sm text-center"><?= $course['credits'] ?></td>
                                <td class="px-4 py-2 text-sm text-center"><?= $course['semester'] ?></td>
                                <td class="px-4 py-2 text-sm text-center">
                                    <span class="font-bold <?= $course['grade_points'] >= 3.0 ? 'text-green-600 dark:text-green-400' : ($course['grade_points'] >= 2.0 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') ?>">
                                        <?= number_format($course['grade_points'], 2) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-center">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full <?= $course['result'] == 'PASS' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' ?>">
                                        <?= $course['result'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- CGPA Summary -->
            <div class="text-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                <p class="text-lg font-bold text-gray-800 dark:text-white">
                    <?= __t('Cumulative GPA (CGPA)', 'ټولیز GPA', 'معدل کل') ?>: 
                    <span class="text-2xl text-indigo-600 dark:text-indigo-400"><?= number_format($transcript['cgpa'] ?? 0, 2) ?></span> / 4.00
                </p>
                <p class="text-sm text-gray-500 mt-1"><?= __t('Total Credits Earned', 'ټول ترلاسه شوي کریډیټونه', 'کل کریڈٹ کسب شده') ?>: <?= $transcript['total_credits'] ?? 0 ?></p>
            </div>

            <!-- Signatures & Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="mb-2">_________________</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><?= __t('Registrar', 'ثبت کوونکی', 'ثبت') ?></p>
                    </div>
                    <div>
                        <div class="mb-2">_________________</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><?= __t('Academic Director', 'اکاډمیک رییس', 'رئیس آکادمیک') ?></p>
                    </div>
                    <div>
                        <div class="mb-2">_________________</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><?= __t('Date', 'نیټه', 'تاریخ') ?></p>
                    </div>
                </div>
                <p class="text-center text-xs text-gray-400 mt-6"><?= __t('This is a computer-generated transcript. No signature is required.', 'دا د کمپیوټر لخوا تولید شوی ټرانسکرپټ دی. لاسلیک ته اړتیا نشته.', 'این ریزنمرات به صورت کامپیوتری تولید شده است. نیازی به امضا نیست.') ?></p>
            </div>
        </div>
    </div>
</div>

<style media="print">
    body * { visibility: hidden; }
    #transcript-content, #transcript-content * { visibility: visible; }
    #transcript-content { position: absolute; top: 0; left: 0; width: 100%; margin: 0; padding: 0; }
    .no-print { display: none; }
    button, a { display: none; }
</style>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>