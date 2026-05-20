<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('faculty_performance_report');

global $isRTL;
$currentYear = date('Y');
$selectedYear = $_GET['year'] ?? $currentYear;
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <a href="index.php?route=planning/dashboard" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-2 mb-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-arrow-left-line"></i>
                <span><?= __t('Back to Dashboard', 'بیرته ډشبورډ ته', 'بازگشت به داشبورد') ?></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Faculty Performance Report', 'د پوهنځي فعالیت رپوټ', 'گزارش عملکرد پوهنځی‌ها') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Comparative analysis of faculty performance metrics', 'د پوهنځي فعالیت میټریکونو پرتله کولو تحلیل', 'تحلیل مقایسه‌ای معیارهای عملکرد پوهنځی‌ها') ?></p>
        </div>
        <div class="flex gap-3">
            <select id="yearSelect" onchange="window.location.href='index.php?route=reports/faculty-performance&year='+this.value" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <?php for($y = $currentYear-1; $y <= $currentYear; $y++): ?>
                <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>><?= $y ?> - <?= $y+1 ?></option>
                <?php endfor; ?>
            </select>
            <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-printer-line"></i>
                <span><?= __t('Print', 'چاپول', 'چاپ') ?></span>
            </button>
        </div>
    </div>

    <!-- Performance Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Faculty', 'پوهنځی', 'پوهنځی') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Departments', 'څانګې', 'دیپارتمنت‌ها') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Courses', 'کورسونه', 'کورس‌ها') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Students', 'زده کونکي', 'دانشجویان') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Pass Rate', 'د بریالیتوب کچه', 'نرخ قبولی') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Performance', 'فعالیت', 'عملکرد') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if(!empty($faculties)): ?>
                        <?php 
                        $rank = 1;
                        foreach($faculties as $faculty): 
                            $passRate = round($faculty['pass_percentage'] ?? 0);
                            $performanceClass = $passRate >= 80 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : ($passRate >= 60 ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200');
                        ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold"><?= $rank++ ?></div>
                                    <span class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($faculty['name']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 dark:text-gray-300"><?= $faculty['departments_count'] ?? 0 ?></td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 dark:text-gray-300"><?= $faculty['courses_count'] ?? 0 ?></td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 dark:text-gray-300"><?= $faculty['students_enrolled'] ?? 0 ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-2 py-1 text-sm font-bold rounded-lg <?= $performanceClass ?>">
                                    <?= $passRate ?>%
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="h-2 rounded-full <?= $passRate >= 80 ? 'bg-green-500' : ($passRate >= 60 ? 'bg-yellow-500' : 'bg-red-500') ?>" style="width: <?= $passRate ?>%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 dark:text-gray-400"><?= $passRate ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="ri-bar-chart-line text-5xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                                <p class="text-gray-500 dark:text-gray-400"><?= __t('No faculty performance data available', 'د پوهنځي فعالیت معلومات شتون نلري', 'اطلاعات عملکرد پوهنځی‌ها موجود نیست') ?></p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4"><?= __t('Faculty Performance Comparison', 'د پوهنځي فعالیت پرتله کول', 'مقایسه عملکرد پوهنځی‌ها') ?></h3>
        <canvas id="performanceChart" height="80"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('performanceChart').getContext('2d');
const faculties = <?= json_encode(array_column($faculties, 'name')) ?>;
const passRates = <?= json_encode(array_map(function($f) { return round($f['pass_percentage'] ?? 0); }, $faculties)) ?>;

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: faculties,
        datasets: [{
            label: '<?= __t('Pass Rate (%)', 'د بریالیتوب کچه (٪)', 'نرخ قبولی (٪)') ?>',
            data: passRates,
            backgroundColor: passRates.map(rate => 
                rate >= 80 ? 'rgba(34, 197, 94, 0.7)' : (rate >= 60 ? 'rgba(234, 179, 8, 0.7)' : 'rgba(239, 68, 68, 0.7)')
            ),
            borderColor: passRates.map(rate => 
                rate >= 80 ? 'rgb(34, 197, 94)' : (rate >= 60 ? 'rgb(234, 179, 8)' : 'rgb(239, 68, 68)')
            ),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                title: {
                    display: true,
                    text: '<?= __t('Percentage (%)', 'سلنه (٪)', 'درصد (٪)') ?>'
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                rtl: <?= $isRTL ? 'true' : 'false' ?>
            }
        }
    }
});
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>