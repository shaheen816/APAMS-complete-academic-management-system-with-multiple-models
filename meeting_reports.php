<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('meeting_reports');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Meeting Reports', 'د غونډو رپوټونه', 'گزارشات جلسات') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Document and submit official meeting reports to leadership', 'رسمي غونډو رپوټونه مستند کړئ او مشرتابه ته یې وسپارئ', 'مستندسازی و ارسال گزارشات جلسات رسمی به رهبری') ?></p>
        </div>
        <?php if($role === 'PLANNING_MANAGER'): ?>
        <a href="index.php?route=planning/add-meeting-report" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
            <i class="ri-add-line text-xl"></i>
            <span><?= __t('Add Report', 'نوی رپوټ', 'افزودن گزارش') ?></span>
        </a>
        <?php endif; ?>
    </div>

    <!-- Search -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="ri-search-line absolute <?= $isRTL ? 'right-3' : 'left-3' ?> top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="<?= __t('Search by title or meeting code...', 'د سرلیک یا غونډې کوډ په واسطه لټون وکړئ...', 'جستجو بر اساس عنوان یا کد جلسه...') ?>" class="w-full <?= $isRTL ? 'pr-10' : 'pl-10' ?> px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
            <select id="typeFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <option value=""><?= __t('All Types', 'ټول ډولونه', 'همه انواع') ?></option>
                <option value="ACADEMIC"><?= __t('Academic', 'اکاډمیک', 'آکادمیک') ?></option>
                <option value="ADMINISTRATIVE"><?= __t('Administrative', 'اداري', 'اداری') ?></option>
                <option value="DISCIPLINARY"><?= __t('Disciplinary', 'انضباطي', 'انضباطی') ?></option>
                <option value="PLANNING"><?= __t('Planning', 'پلان', 'پلان‌سازی') ?></option>
                <option value="OTHER"><?= __t('Other', 'نور', 'سایر') ?></option>
            </select>
        </div>
    </div>

    <!-- Meeting Reports Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Meeting Code', 'د غونډې کوډ', 'کد جلسه') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Title', 'سرلیک', 'عنوان') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Type', 'ډول', 'نوع') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Meeting Date', 'د غونډې نیټه', 'تاریخ جلسه') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Submitted To', 'ورکړل شوی', 'ارسال به') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Actions', 'عملونه', 'عملیات') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="reportsTableBody">
                    <?php if(!empty($meetings)): ?>
                        <?php foreach($meetings as $meeting): ?>
                        <tr class="report-row hover:bg-gray-50 dark:hover:bg-gray-700 transition" data-type="<?= $meeting['meeting_type'] ?>">
                            <td class="px-6 py-4 text-sm font-mono font-medium text-indigo-600 dark:text-indigo-400"><?= htmlspecialchars($meeting['meeting_code']) ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($meeting['meeting_title']) ?></td>
                            <td class="px-6 py-4">
                                <?php if($meeting['meeting_type'] == 'ACADEMIC'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200"><?= __t('Academic', 'اکاډمیک', 'آکادمیک') ?></span>
                                <?php elseif($meeting['meeting_type'] == 'ADMINISTRATIVE'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"><?= __t('Administrative', 'اداري', 'اداری') ?></span>
                                <?php elseif($meeting['meeting_type'] == 'DISCIPLINARY'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200"><?= __t('Disciplinary', 'انضباطي', 'انضباطی') ?></span>
                                <?php elseif($meeting['meeting_type'] == 'PLANNING'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200"><?= __t('Planning', 'پلان', 'پلان‌سازی') ?></span>
                                <?php else: ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400"><?= __t('Other', 'نور', 'سایر') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= date('M d, Y', strtotime($meeting['meeting_date'])) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($meeting['submitted_to']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <button onclick="viewReport(<?= $meeting['id'] ?>)" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 transition" title="<?= __t('View', 'کتل', 'مشاهده') ?>">
                                        <i class="ri-eye-line text-xl"></i>
                                    </button>
                                    <button onclick="printReport(<?= $meeting['id'] ?>)" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 transition" title="<?= __t('Print', 'چاپول', 'چاپ') ?>">
                                        <i class="ri-printer-line text-xl"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="ri-file-copy-line text-5xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                                <p class="text-gray-500 dark:text-gray-400"><?= __t('No meeting reports found', 'د غونډو رپوټونه ونه موندل شول', 'هیچ گزارش جلسه‌ای یافت نشد') ?></p>
                                <?php if($role === 'PLANNING_MANAGER'): ?>
                                <a href="index.php?route=planning/add-meeting-report" class="mt-3 inline-block text-indigo-600 hover:text-indigo-700 dark:text-indigo-400"><?= __t('Add your first report', 'خپل لومړی رپوټ اضافه کړئ', 'افزودن اولین گزارش') ?> →</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View Report Modal -->
<div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white" id="viewTitle"><?= __t('Meeting Report', 'د غونډې رپوټ', 'گزارش جلسه') ?></h3>
            <button onclick="document.getElementById('viewModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>
        <div class="p-6" id="viewContent">
            <div class="text-center py-8">
                <i class="ri-loader-line text-4xl text-indigo-500 animate-spin"></i>
                <p class="mt-2 text-gray-500"><?= __t('Loading...', 'رالوډ کیږي...', 'در حال بارگذاری...') ?></p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.report-row');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

document.getElementById('typeFilter')?.addEventListener('change', function() {
    const type = this.value;
    const rows = document.querySelectorAll('.report-row');
    rows.forEach(row => {
        if (!type || row.dataset.type === type) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function viewReport(id) {
    const modal = document.getElementById('viewModal');
    const content = document.getElementById('viewContent');
    modal.classList.remove('hidden');
    
    // Fetch report details via AJAX
    fetch('index.php?route=planning/get-meeting-report&id=' + id)
        .then(response => response.text())
        .then(html => {
            content.innerHTML = html;
        })
        .catch(error => {
            content.innerHTML = '<div class="text-center py-8 text-red-500"><i class="ri-error-warning-line text-4xl"></i><p><?= __t('Error loading report', 'د رپوټ په لارښود کې تېروتنه', 'خطا در بارگذاری گزارش') ?></p></div>';
        });
}

function printReport(id) {
    window.open('index.php?route=planning/print-meeting-report&id=' + id, '_blank');
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>