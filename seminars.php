<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('seminars_management');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Seminars Management', 'د سیمینارونو مدیریت', 'مدیریت سمینارها') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Organize and manage academic seminars and events', 'اکاډمیک سیمینارونه او پیښې تنظیم او اداره کړئ', 'سازماندهی و مدیریت سمینارها و رویدادهای آکادمیک') ?></p>
        </div>
        <?php if($role === 'PLANNING_MANAGER'): ?>
        <a href="index.php?route=planning/add-seminar" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
            <i class="ri-add-line text-xl"></i>
            <span><?= __t('Add Seminar', 'نوی سیمینار', 'افزودن سمینار') ?></span>
        </a>
        <?php endif; ?>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('Status', 'حالت', 'وضعیت') ?></label>
                <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value=""><?= __t('All', 'ټول', 'همه') ?></option>
                    <option value="PLANNED"><?= __t('Planned', 'پلان شوی', 'برنامه‌ریزی شده') ?></option>
                    <option value="COMPLETED"><?= __t('Completed', 'بشپړ شوی', 'تکمیل شده') ?></option>
                    <option value="CANCELLED"><?= __t('Cancelled', 'لغوه شوی', 'لغو شده') ?></option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('From Date', 'له نیټې', 'از تاریخ') ?></label>
                <input type="date" id="fromDate" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('To Date', 'تر نیټې', 'تا تاریخ') ?></label>
                <input type="date" id="toDate" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
        </div>
    </div>

    <!-- Seminars Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="seminarsGrid">
        <?php if(!empty($seminars)): ?>
            <?php foreach($seminars as $seminar): ?>
            <div class="seminar-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition" data-status="<?= $seminar['status'] ?>" data-date="<?= $seminar['schedule_date'] ?>">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-2">
                            <i class="ri-speaker-line text-2xl text-indigo-500"></i>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($seminar['title']) ?></h3>
                        </div>
                        <?php if($seminar['status'] == 'PLANNED'): ?>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200"><?= __t('Planned', 'پلان شوی', 'برنامه‌ریزی شده') ?></span>
                        <?php elseif($seminar['status'] == 'COMPLETED'): ?>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"><?= __t('Completed', 'بشپړ شوی', 'تکمیل شده') ?></span>
                        <?php else: ?>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200"><?= __t('Cancelled', 'لغوه شوی', 'لغو شده') ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2"><?= htmlspecialchars(substr($seminar['description'] ?? '', 0, 100)) ?>...</p>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                            <i class="ri-user-line text-gray-400"></i>
                            <span class="text-gray-600 dark:text-gray-400"><?= __t('Speaker', 'ویاند', 'سخنران') ?>:</span>
                            <span class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($seminar['speaker_name']) ?></span>
                        </div>
                        <div class="flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                            <i class="ri-map-pin-line text-gray-400"></i>
                            <span class="text-gray-600 dark:text-gray-400"><?= __t('Venue', 'ځای', 'مکان') ?>:</span>
                            <span class="font-medium text-gray-800 dark:text-white"><?= htmlspecialchars($seminar['venue']) ?></span>
                        </div>
                        <div class="flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                            <i class="ri-calendar-line text-gray-400"></i>
                            <span class="text-gray-600 dark:text-gray-400"><?= __t('Date', 'نیټه', 'تاریخ') ?>:</span>
                            <span class="font-medium text-gray-800 dark:text-white"><?= date('M d, Y', strtotime($seminar['schedule_date'])) ?></span>
                        </div>
                        <div class="flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                            <i class="ri-time-line text-gray-400"></i>
                            <span class="text-gray-600 dark:text-gray-400"><?= __t('Time', 'وخت', 'زمان') ?>:</span>
                            <span class="font-medium text-gray-800 dark:text-white"><?= date('h:i A', strtotime($seminar['start_time'])) ?> - <?= date('h:i A', strtotime($seminar['end_time'])) ?></span>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            <i class="ri-user-settings-line"></i> <?= htmlspecialchars($seminar['organizer_name']) ?>
                        </div>
                        <div class="flex gap-2">
                            <a href="index.php?route=planning/view-seminar&id=<?= $seminar['id'] ?>" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 transition">
                                <i class="ri-eye-line text-xl"></i>
                            </a>
                            <?php if($role === 'PLANNING_MANAGER' && $seminar['status'] == 'PLANNED'): ?>
                            <button onclick="completeSeminar(<?= $seminar['id'] ?>)" class="text-green-600 hover:text-green-900 dark:text-green-400 transition" title="<?= __t('Mark Complete', 'بشپړ په نښه کړئ', 'علامت گذاری به عنوان تکمیل') ?>">
                                <i class="ri-check-double-line text-xl"></i>
                            </button>
                            <?php endif; ?>
                            <?php if($role === 'PLANNING_MANAGER' && $seminar['status'] == 'COMPLETED' && !$seminar['report_path']): ?>
                            <button onclick="uploadReport(<?= $seminar['id'] ?>)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 transition" title="<?= __t('Upload Report', 'رپوټ اپلوډ کړئ', 'آپلود گزارش') ?>">
                                <i class="ri-upload-line text-xl"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-12 text-center">
                <i class="ri-speaker-line text-6xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                <p class="text-gray-500 dark:text-gray-400"><?= __t('No seminars found', 'هیچ سیمینار ونه موندل شو', 'هیچ سمیناری یافت نشد') ?></p>
                <?php if($role === 'PLANNING_MANAGER'): ?>
                <a href="index.php?route=planning/add-seminar" class="mt-3 inline-block text-indigo-600 hover:text-indigo-700 dark:text-indigo-400"><?= __t('Add your first seminar', 'خپل لومړی سیمینار اضافه کړئ', 'افزودن اولین سمینار') ?> →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Upload Report Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Upload Seminar Report', 'د سیمینار رپوټ اپلوډ کړئ', 'آپلود گزارش سمینار') ?></h3>
        </div>
        <form method="POST" action="" id="uploadForm" enctype="multipart/form-data" class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"><?= __t('Report File (PDF)', 'رپوټ فایل (PDF)', 'فایل گزارش (PDF)') ?> <span class="text-red-500">*</span></label>
                <input type="file" name="report" accept=".pdf" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <p class="text-xs text-gray-500 mt-1"><?= __t('Upload the seminar report in PDF format', 'د سیمینار رپوټ د PDF په بڼه اپلوډ کړئ', 'گزارش سمینار را با فرمت PDF آپلود کنید') ?></p>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition flex-1"><?= __t('Upload', 'اپلوډ', 'آپلود') ?></button>
                <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2 rounded-lg transition"><?= __t('Cancel', 'لغوه کول', 'لغو') ?></button>
            </div>
        </form>
    </div>
</div>

<script>
let currentSeminarId = null;

document.getElementById('statusFilter')?.addEventListener('change', filterSeminars);
document.getElementById('fromDate')?.addEventListener('change', filterSeminars);
document.getElementById('toDate')?.addEventListener('change', filterSeminars);

function filterSeminars() {
    const status = document.getElementById('statusFilter').value;
    const fromDate = document.getElementById('fromDate').value;
    const toDate = document.getElementById('toDate').value;
    
    const cards = document.querySelectorAll('.seminar-card');
    
    cards.forEach(card => {
        let show = true;
        
        if (status && card.dataset.status !== status) {
            show = false;
        }
        
        if (fromDate && card.dataset.date < fromDate) {
            show = false;
        }
        
        if (toDate && card.dataset.date > toDate) {
            show = false;
        }
        
        card.style.display = show ? '' : 'none';
    });
}

function completeSeminar(id) {
    if(confirm('<?= __t('Mark this seminar as completed?', 'آیا دا سیمینار بشپړ په نښه کوئ؟', 'آیا این سمینار را به عنوان تکمیل شده علامت گذاری می‌کنید؟') ?>')) {
        window.location.href = 'index.php?route=planning/complete-seminar&id=' + id;
    }
}

function uploadReport(id) {
    currentSeminarId = id;
    const modal = document.getElementById('uploadModal');
    const form = document.getElementById('uploadForm');
    form.action = 'index.php?route=planning/submit-seminar-report&id=' + id;
    modal.classList.remove('hidden');
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>