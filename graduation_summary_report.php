<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('graduation_summary_report');

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
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Graduation Summary Report', 'د فراغت لنډیز رپوټ', 'گزارش خلاصه فارغ‌التحصیلی') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Complete graduation statistics and top performers', 'بشپړ د فراغت احصایې او غوره ترسره کوونکي', 'آمار کامل فارغ‌التحصیلی و برترین‌ها') ?></p>
        </div>
        <div class="flex gap-3">
            <select id="yearSelect" onchange="window.location.href='index.php?route=reports/graduation-summary&year='+this.value" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <?php for($y = $currentYear-2; $y <= $currentYear; $y++): ?>
                <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
            <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-printer-line"></i>
                <span><?= __t('Print', 'چاپول', 'چاپ') ?></span>
            </button>
        </div>
    </div>

    <!-- Key Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white text-center">
            <i class="ri-group-line text-4xl mb-3 block"></i>
            <p class="text-indigo-100 text-sm"><?= __t('Total Graduates', 'ټول فارغان', 'کل فارغ‌التحصیلان') ?></p>
            <p class="text-4xl font-bold mt-2"><?= number_format($summary['total_graduates'] ?? 0) ?></p>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white text-center">
            <i class="ri-award-line text-4xl mb-3 block"></i>
            <p class="text-green-100 text-sm"><?= __t('Diplomas Issued', 'صادر شوي ډیپلومونه', 'دیپلوم‌های صادر شده') ?></p>
            <p class="text-4xl font-bold mt-2"><?= number_format($summary['diplomas_issued'] ?? 0) ?></p>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white text-center">
            <i class="ri-bar-chart-line text-4xl mb-3 block"></i>
            <p class="text-purple-100 text-sm"><?= __t('Average CGPA', 'اوسط CGPA', 'معدل CGPA') ?></p>
            <p class="text-4xl font-bold mt-2"><?= number_format($summary['avg_cgpa'] ?? 0, 2) ?></p>
        </div>
    </div>

    <!-- Top Performers -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="ri-medal-line text-yellow-500"></i>
                <?= __t('Top Performers', 'غوره ترسره کوونکي', 'برترین‌ها') ?>
            </h3>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php if(!empty($summary['top_performers'])): ?>
                <?php 
                $medals = ['🥇', '🥈', '🥉', '📖', '📖', '📖', '📖', '📖', '📖', '📖'];
                $rank = 1;
                foreach($summary['top_performers'] as $performer): 
                ?>
                <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                            <div class="text-2xl"><?= $medals[$rank-1] ?></div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white"><?= htmlspecialchars($performer['first_name'] . ' ' . $performer['last_name']) ?></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars($performer['enrollment_number']) ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400"><?= number_format($performer['cgpa'], 2) ?></p>
                            <p class="text-xs text-gray-500">CGPA / 4.00</p>
                        </div>
                    </div>
                </div>
                <?php $rank++; endforeach; ?>
            <?php else: ?>
                <div class="px-6 py-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400"><?= __t('No graduate data available', 'د فراغت معلومات شتون نلري', 'اطلاعات فارغ‌التحصیلی موجود نیست') ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Graduation by Faculty -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Graduates by Faculty', 'د پوهنځي له مخې فارغان', 'فارغ‌التحصیلان بر اساس پوهنځی') ?></h3>
        </div>
        <div class="p-6">
            <canvas id="facultyChart" height="80"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const facultyCtx = document.getElementById('facultyChart').getContext('2d');
const faculties = <?= json_encode(array_column($summary['by_faculty'] ?? [], 'name')) ?>;
const graduates = <?= json_encode(array_column($summary['by_faculty'] ?? [], 'graduates_count')) ?>;

new Chart(facultyCtx, {
    type: 'pie',
    data: {
        labels: faculties,
        datasets: [{
            data: graduates,
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',
                'rgba(34, 197, 94, 0.8)',
                'rgba(168, 85, 247, 0.8)',
                'rgba(249, 115, 22, 0.8)',
                'rgba(236, 72, 153, 0.8)',
                'rgba(20, 184, 166, 0.8)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                rtl: <?= $isRTL ? 'true' : 'false' ?>
            }
        }
    }
});
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>