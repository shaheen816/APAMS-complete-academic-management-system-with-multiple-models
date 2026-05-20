<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('transcripts_management');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Transcripts Management', 'د ټرانسکرپټ مدیریت', 'مدیریت ریزنمرات') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Generate, approve, and manage student academic transcripts', 'د زده کونکو اکاډمیک ټرانسکرپټونه جوړ کړئ، تصویب کړئ او اداره کړئ', 'ایجاد، تایید و مدیریت ریزنمرات تحصیلی دانشجویان') ?></p>
        </div>
        <?php if($role === 'PLANNING_MANAGER'): ?>
        <div class="flex gap-3">
            <button onclick="window.location.href='index.php?route=planning/generate-all-transcripts'" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-file-copy-line"></i>
                <span><?= __t('Generate All', 'ټول جوړ کړئ', 'ایجاد همه') ?></span>
            </button>
            <button onclick="window.location.href='index.php?route=planning/export-transcripts'" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                <i class="ri-download-line"></i>
                <span><?= __t('Export', 'صادرول', 'خروجی') ?></span>
            </button>
        </div>
        <?php endif; ?>
    </div>

    <!-- Search -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="ri-search-line absolute <?= $isRTL ? 'right-3' : 'left-3' ?> top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="<?= __t('Search by name or enrollment number...', 'د نوم یا نوم لیکنې شمیرې په واسطه لټون وکړئ...', 'جستجو بر اساس نام یا شماره ثبت...') ?>" class="w-full <?= $isRTL ? 'pr-10' : 'pl-10' ?> px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
            <select id="statusFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <option value=""><?= __t('All Statuses', 'ټول حالتونه', 'همه وضعیت‌ها') ?></option>
                <option value="DRAFT"><?= __t('Draft', 'مسوده', 'پیش‌نویس') ?></option>
                <option value="ACADEMIC_APPROVED"><?= __t('Academic Approved', 'اکاډمیک تصویب شوی', 'تایید شده توسط اکادمیک') ?></option>
                <option value="LOCKED"><?= __t('Locked', 'تالاشوی', 'قفل شده') ?></option>
                <option value="ISSUED"><?= __t('Issued', 'صادر شوی', 'صادر شده') ?></option>
            </select>
        </div>
    </div>

    <!-- Transcripts Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Transcript No.', 'ټرانسکرپټ نمبر', 'شماره ریزنمرات') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Student', 'زده کونکی', 'دانشجو') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Semester', 'سمستر', 'سمستر') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Total Credits', 'ټول کریډیټونه', 'کل کریڈٹ') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('CGPA', 'سی جی پی ای', 'CGPA') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Status', 'حالت', 'وضعیت') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"><?= __t('Actions', 'عملونه', 'عملیات') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="transcriptsTableBody">
                    <?php if(!empty($transcripts)): ?>
                        <?php foreach($transcripts as $transcript): ?>
                        <tr class="transcript-row hover:bg-gray-50 dark:hover:bg-gray-700 transition" data-status="<?= $transcript['status'] ?>">
                            <td class="px-6 py-4 text-sm font-mono font-medium text-indigo-600 dark:text-indigo-400"><?= htmlspecialchars($transcript['transcript_number']) ?></td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($transcript['first_name'] . ' ' . $transcript['last_name']) ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars($transcript['enrollment_number']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 dark:text-gray-300"><?= $transcript['semester'] ?></td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 dark:text-gray-300"><?= $transcript['total_credits'] ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-2 py-1 text-sm font-bold rounded-lg <?= ($transcript['cgpa'] ?? 0) >= 3.5 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : (($transcript['cgpa'] ?? 0) >= 2.5 ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200') ?>">
                                    <?= number_format($transcript['cgpa'] ?? 0, 2) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if($transcript['status'] == 'DRAFT'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400"><?= __t('Draft', 'مسوده', 'پیش‌نویس') ?></span>
                                <?php elseif($transcript['status'] == 'ACADEMIC_APPROVED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200"><?= __t('Academic Approved', 'اکاډمیک تصویب شوی', 'تایید شده توسط اکادمیک') ?></span>
                                <?php elseif($transcript['status'] == 'LOCKED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"><?= __t('Locked', 'تالاشوی', 'قفل شده') ?></span>
                                <?php elseif($transcript['status'] == 'ISSUED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200"><?= __t('Issued', 'صادر شوی', 'صادر شده') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <a href="index.php?route=planning/view-transcript&id=<?= $transcript['id'] ?>" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 transition" title="<?= __t('View', 'کتل', 'مشاهده') ?>">
                                        <i class="ri-eye-line text-xl"></i>
                                    </a>
                                    <?php if($role === 'DIRECTOR_ACADEMIC' && $transcript['status'] == 'DRAFT'): ?>
                                    <button onclick="approveTranscript(<?= $transcript['id'] ?>)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 transition" title="<?= __t('Approve', 'تصویب', 'تایید') ?>">
                                        <i class="ri-check-double-line text-xl"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if($role === 'PLANNING_MANAGER' && $transcript['status'] == 'ACADEMIC_APPROVED'): ?>
                                    <button onclick="lockTranscript(<?= $transcript['id'] ?>)" class="text-green-600 hover:text-green-900 dark:text-green-400 transition" title="<?= __t('Lock', 'تالول', 'قفل') ?>">
                                        <i class="ri-lock-line text-xl"></i>
                                    </button>
                                    <?php endif; ?>
                                    <a href="index.php?route=planning/download-transcript&id=<?= $transcript['id'] ?>" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 transition" title="<?= __t('Download PDF', 'PDF ډاونلوډ کړئ', 'دانلود PDF') ?>">
                                        <i class="ri-file-pdf-line text-xl"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class="ri-file-copy-line text-5xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                                <p class="text-gray-500 dark:text-gray-400"><?= __t('No transcripts found', 'هیچ ټرانسکرپټ ونه موندل شو', 'هیچ ریزنمراتی یافت نشد') ?></p>
                                <?php if($role === 'PLANNING_MANAGER'): ?>
                                <a href="index.php?route=planning/generate-all-transcripts" class="mt-3 inline-block text-indigo-600 hover:text-indigo-700 dark:text-indigo-400"><?= __t('Generate transcripts', 'ټرانسکرپټونه جوړ کړئ', 'ایجاد ریزنمرات') ?> →</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.transcript-row');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

document.getElementById('statusFilter')?.addEventListener('change', function() {
    const status = this.value;
    const rows = document.querySelectorAll('.transcript-row');
    rows.forEach(row => {
        if (!status || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function approveTranscript(id) {
    if(confirm('<?= __t('Approve this transcript?', 'آیا دا ټرانسکرپټ تصویب کوئ؟', 'آیا این ریزنمرات را تایید می‌کنید؟') ?>')) {
        window.location.href = 'index.php?route=planning/approve-transcript&id=' + id;
    }
}

function lockTranscript(id) {
    if(confirm('<?= __t('Lock this transcript? This action cannot be undone.', 'آیا دا ټرانسکرپټ تالئ کوئ؟ دا عمل بیرته نه راګرځیدونکی دی.', 'آیا این ریزنمرات را قفل می‌کنید؟ این عمل قابل بازگشت نیست.') ?>')) {
        window.location.href = 'index.php?route=planning/lock-transcript&id=' + id;
    }
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>