<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('diplomas_management');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Diplomas Management', 'د ډیپلوم مدیریت', 'مدیریت دیپلوم') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Process diploma requests through approval chain', 'د تصویب لړۍ له لارې د ډیپلوم غوښتنې پروسس کړئ', 'پردازش درخواست‌های دیپلوم از طریق زنجیره تایید') ?></p>
        </div>
    </div>

    <!-- Approval Chain Status -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 text-center">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400"><?= __t('Planning', 'پلان', 'پلان') ?></div>
            <div class="text-2xl font-bold text-blue-600">1</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 text-center">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400"><?= __t('Academic', 'اکاډمیک', 'اکادمیک') ?></div>
            <div class="text-2xl font-bold text-yellow-600">2</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 text-center">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400"><?= __t('Commander', 'قوماندان', 'فرماندهی') ?></div>
            <div class="text-2xl font-bold text-purple-600">3</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 text-center">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400"><?= __t('Issued', 'صادر شوی', 'صادر شده') ?></div>
            <div class="text-2xl font-bold text-green-600">4</div>
        </div>
    </div>

    <!-- Diplomas Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Diploma No.', 'ډیپلوم نمبر', 'شماره دیپلوم') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Student', 'زده کونکی', 'دانشجو') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Degree', 'سان', 'مدرک') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Graduation Date', 'د فراغت نیټه', 'تاریخ فارغ‌التحصیلی') ?></th>
                        <th class="px-6 py-4 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Status', 'حالت', 'وضعیت') ?></th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Actions', 'عملونه', 'عملیات') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if(!empty($diplomas)): ?>
                        <?php foreach($diplomas as $diploma): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm font-mono font-medium text-indigo-600 dark:text-indigo-400"><?= htmlspecialchars($diploma['diploma_number']) ?></td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($diploma['first_name'] . ' ' . $diploma['last_name']) ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars($diploma['enrollment_number']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($diploma['degree']) ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars($diploma['specialization'] ?? '-') ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300"><?= date('M d, Y', strtotime($diploma['graduation_date'])) ?></td>
                            <td class="px-6 py-4">
                                <?php if($diploma['status'] == 'PENDING'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400"><?= __t('Pending', 'ځنډول شوی', 'در انتظار') ?></span>
                                <?php elseif($diploma['status'] == 'PLANNING_APPROVED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200"><?= __t('Planning Approved', 'د پلان لخوا تصویب شوی', 'تایید شده توسط پلان') ?></span>
                                <?php elseif($diploma['status'] == 'ACADEMIC_APPROVED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200"><?= __t('Academic Approved', 'د اکاډمیک لخوا تصویب شوی', 'تایید شده توسط اکادمیک') ?></span>
                                <?php elseif($diploma['status'] == 'COMMANDER_APPROVED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200"><?= __t('Commander Approved', 'د قوماندان لخوا تصویب شوی', 'تایید شده توسط فرماندهی') ?></span>
                                <?php elseif($diploma['status'] == 'ISSUED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"><?= __t('Issued', 'صادر شوی', 'صادر شده') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <a href="index.php?route=planning/view-diploma&id=<?= $diploma['id'] ?>" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 transition" title="<?= __t('View', 'کتل', 'مشاهده') ?>">
                                        <i class="ri-eye-line text-xl"></i>
                                    </a>
                                    <?php if($role === 'PLANNING_MANAGER' && $diploma['status'] == 'PENDING'): ?>
                                    <button onclick="approveDiploma('planning', <?= $diploma['id'] ?>)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 transition" title="<?= __t('Approve', 'تصویب', 'تایید') ?>">
                                        <i class="ri-check-double-line text-xl"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if($role === 'DIRECTOR_ACADEMIC' && $diploma['status'] == 'PLANNING_APPROVED'): ?>
                                    <button onclick="approveDiploma('academic', <?= $diploma['id'] ?>)" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 transition" title="<?= __t('Approve', 'تصویب', 'تایید') ?>">
                                        <i class="ri-check-double-line text-xl"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if($role === 'COMMANDER' && $diploma['status'] == 'ACADEMIC_APPROVED'): ?>
                                    <button onclick="approveDiploma('commander', <?= $diploma['id'] ?>)" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 transition" title="<?= __t('Approve', 'تصویب', 'تایید') ?>">
                                        <i class="ri-check-double-line text-xl"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if($role === 'PLANNING_MANAGER' && $diploma['status'] == 'COMMANDER_APPROVED'): ?>
                                    <button onclick="issueDiploma(<?= $diploma['id'] ?>)" class="text-green-600 hover:text-green-900 dark:text-green-400 transition" title="<?= __t('Issue', 'صادرول', 'صادر کردن') ?>">
                                        <i class="ri-printer-line text-xl"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="ri-award-line text-5xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                                <p class="text-gray-500 dark:text-gray-400"><?= __t('No diploma requests found', 'د ډیپلوم غوښتنې ونه موندل شوې', 'هیچ درخواست دیپلومی یافت نشد') ?></p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function approveDiploma(stage, id) {
    let message = '';
    if(stage === 'planning') message = '<?= __t('Approve this diploma at planning level?', 'آیا دا ډیپلوم د پلان په کچه تصویب کوئ؟', 'آیا این دیپلوم را در سطح پلان تایید می‌کنید؟') ?>';
    else if(stage === 'academic') message = '<?= __t('Approve this diploma at academic level?', 'آیا دا ډیپلوم د اکاډمیک په کچه تصویب کوئ؟', 'آیا این دیپلوم را در سطح اکادمیک تایید می‌کنید؟') ?>';
    else message = '<?= __t('Approve this diploma at commander level?', 'آیا دا ډیپلوم د قوماندان په کچه تصویب کوئ؟', 'آیا این دیپلوم را در سطح فرماندهی تایید می‌کنید؟') ?>';
    
    if(confirm(message)) {
        window.location.href = 'index.php?route=planning/approve-diploma-' + stage + '&id=' + id;
    }
}

function issueDiploma(id) {
    if(confirm('<?= __t('Issue this diploma to the student?', 'آیا دا ډیپلوم زده کونکي ته صادر کوئ؟', 'آیا این دیپلوم را به دانشجو صادر می‌کنید؟') ?>')) {
        window.location.href = 'index.php?route=planning/issue-diploma&id=' + id;
    }
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>