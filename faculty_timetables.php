<?php
$rootPath = realpath(__DIR__ . '/../../..');
require $rootPath . '/src/Views/layouts/header.php';
$pageTitle = __('faculty_timetables');

global $isRTL;
$role = $_SESSION['role'] ?? '';
?>

<div class="card-enter">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="<?= $isRTL ? 'text-right' : '' ?>">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?= __t('Faculty Timetables', 'د پوهنځي مهالویشونه', 'جدول‌های زمانی پوهنځی') ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= __t('Manage faculty-specific timetables within defined time slots', 'د تعریف شوي وخت سلاټونو دننه د پوهنځي ځانګړي مهالویشونه اداره کړئ', 'مدیریت جدول‌های زمانی مختص پوهنځی در بازه‌های زمانی تعریف شده') ?></p>
        </div>
        <?php if(in_array($role, ['FACULTY_DEAN', 'PLANNING_MANAGER'])): ?>
        <button onclick="document.getElementById('addEntryModal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2 shadow-sm <?= $isRTL ? 'flex-row-reverse' : '' ?>">
            <i class="ri-add-line text-xl"></i>
            <span><?= __t('Add Entry', 'نوی داخله', 'افزودن ورودی') ?></span>
        </button>
        <?php endif; ?>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('Faculty', 'پوهنځی', 'پوهنځی') ?></label>
                <select id="facultySelect" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" onchange="window.location.href='index.php?route=planning/faculty-timetables&faculty_id='+this.value+'&semester=<?= $semester ?>&academic_year=<?= $academic_year ?>'">
                    <option value=""><?= __t('Select Faculty', 'پوهنځی انتخاب کړئ', 'انتخاب پوهنځی') ?></option>
                    <?php foreach($faculties as $faculty): ?>
                    <option value="<?= $faculty['id'] ?>" <?= ($facultyId == $faculty['id']) ? 'selected' : '' ?>><?= htmlspecialchars($faculty['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('Academic Year', 'اکاډمیک کال', 'سال تحصیلی') ?></label>
                <select id="yearSelect" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" onchange="window.location.href='index.php?route=planning/faculty-timetables&faculty_id=<?= $facultyId ?>&semester=<?= $semester ?>&academic_year='+this.value">
                    <?php for($y = date('Y')-1; $y <= date('Y')+2; $y++): ?>
                    <option value="<?= $y ?>" <?= ($academic_year == $y) ? 'selected' : '' ?>><?= $y ?>-<?= $y+1 ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('Semester', 'سمستر', 'سمستر') ?></label>
                <select id="semesterSelect" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" onchange="window.location.href='index.php?route=planning/faculty-timetables&faculty_id=<?= $facultyId ?>&academic_year=<?= $academic_year ?>&semester='+this.value">
                    <option value="1" <?= ($semester == 1) ? 'selected' : '' ?>><?= __t('Semester 1', 'لومړی سمستر', 'سمستر اول') ?></option>
                    <option value="2" <?= ($semester == 2) ? 'selected' : '' ?>><?= __t('Semester 2', 'دوهم سمستر', 'سمستر دوم') ?></option>
                </select>
            </div>
            <div class="flex items-end">
                <?php if($facultyId && in_array($role, ['FACULTY_DEAN'])): ?>
                <button onclick="submitTimetable()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition w-full flex items-center justify-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-send-plane-line"></i>
                    <span><?= __t('Submit for Approval', 'د تصویب لپاره سپارل', 'ارسال برای تایید') ?></span>
                </button>
                <?php elseif($facultyId && $role === 'PLANNING_MANAGER'): ?>
                <button onclick="approveTimetable()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition w-full flex items-center justify-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-check-line"></i>
                    <span><?= __t('Approve All', 'ټول تصویب کړئ', 'تایید همه') ?></span>
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($facultyId && !empty($timetables)): ?>
    <!-- Timetable Display -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Day', 'ورځ', 'روز') ?></th>
                        <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Time', 'وخت', 'زمان') ?></th>
                        <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Course', 'کورس', 'کورس') ?></th>
                        <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Instructor', 'ښوونکی', 'استاد') ?></th>
                        <th class="px-4 py-3 text-<?= $isRTL ? 'right' : 'left' ?> text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Room', 'خونه', 'اتاق') ?></th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Status', 'حالت', 'وضعیت') ?></th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300"><?= __t('Actions', 'عملونه', 'عملیات') ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php 
                    $days = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY'];
                    foreach($days as $day):
                        $daySlots = array_filter($timetables, fn($t) => $t['day_of_week'] == $day);
                        if(empty($daySlots)) continue;
                    ?>
                        <?php foreach($daySlots as $slot): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white"><?= __t($day, $day, $day) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300"><?= date('h:i A', strtotime($slot['start_time'])) ?> - <?= date('h:i A', strtotime($slot['end_time'])) ?></td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($slot['course_code']) ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400"><?= htmlspecialchars($slot['course_name']) ?></div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($slot['instructor_name']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300"><?= htmlspecialchars($slot['room_code'] ?? $slot['room_name'] ?? '-') ?></td>
                            <td class="px-4 py-3 text-center">
                                <?php if($slot['status'] == 'APPROVED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200"><?= __t('Approved', 'تصویب شوی', 'تایید شده') ?></span>
                                <?php elseif($slot['status'] == 'SUBMITTED'): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200"><?= __t('Submitted', 'سپارل شوی', 'ارسال شده') ?></span>
                                <?php else: ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400"><?= __t('Draft', 'مسوده', 'پیش‌نویس') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                                    <button onclick="editEntry(<?= $slot['id'] ?>)" class="text-green-600 hover:text-green-900 dark:text-green-400" title="<?= __t('Edit', 'سمول', 'ویرایش') ?>">
                                        <i class="ri-edit-line text-lg"></i>
                                    </button>
                                    <button onclick="deleteEntry(<?= $slot['id'] ?>)" class="text-red-600 hover:text-red-900 dark:text-red-400" title="<?= __t('Delete', 'حذف', 'حذف') ?>">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php elseif($facultyId): ?>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-12 text-center">
        <i class="ri-calendar-schedule-line text-6xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
        <p class="text-gray-500 dark:text-gray-400"><?= __t('No timetable entries found for this faculty', 'د دې پوهنځي لپاره د مهالویش داخله ونه موندل شوه', 'هیچ ورودی جدول زمانی برای این پوهنځی یافت نشد') ?></p>
        <?php if(in_array($role, ['FACULTY_DEAN', 'PLANNING_MANAGER'])): ?>
        <button onclick="document.getElementById('addEntryModal').classList.remove('hidden')" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
            <?= __t('Add your first timetable entry', 'خپل لومړی مهالویش داخله اضافه کړئ', 'افزودن اولین ورودی جدول زمانی') ?> →
        </button>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Add Entry Modal -->
<div id="addEntryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><?= __t('Add Timetable Entry', 'د مهالویش داخله اضافه کړئ', 'افزودن ورودی جدول زمانی') ?></h3>
            <button onclick="document.getElementById('addEntryModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>
        <form method="POST" action="index.php?route=planning/add-timetable-entry" class="p-6 space-y-4">
            <input type="hidden" name="faculty_id" value="<?= $facultyId ?>">
            <input type="hidden" name="academic_year" value="<?= $academic_year ?>">
            <input type="hidden" name="semester" value="<?= $semester ?>">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('Course', 'کورس', 'کورس') ?> <span class="text-red-500">*</span></label>
                <select name="course_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value=""><?= __t('Select Course', 'کورس انتخاب کړئ', 'انتخاب کورس') ?></option>
                    <?php foreach($courses as $course): ?>
                    <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['course_code'] . ' - ' . $course['course_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('Time Slot', 'وخت سلاټ', 'بازه زمانی') ?> <span class="text-red-500">*</span></label>
                <select name="time_slot_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value=""><?= __t('Select Time Slot', 'وخت سلاټ انتخاب کړئ', 'انتخاب بازه زمانی') ?></option>
                    <?php foreach($timeSlots as $slot): ?>
                    <option value="<?= $slot['id'] ?>"><?= __t($slot['day_of_week'], $slot['day_of_week'], $slot['day_of_week']) ?> - <?= date('h:i A', strtotime($slot['start_time'])) ?> to <?= date('h:i A', strtotime($slot['end_time'])) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('Instructor', 'ښوونکی', 'استاد') ?> <span class="text-red-500">*</span></label>
                <select name="instructor_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value=""><?= __t('Select Instructor', 'ښوونکی انتخاب کړئ', 'انتخاب استاد') ?></option>
                    <?php foreach($instructors as $instructor): ?>
                    <option value="<?= $instructor['id'] ?>"><?= htmlspecialchars($instructor['username']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('Room', 'خونه', 'اتاق') ?> <span class="text-red-500">*</span></label>
                <select name="room_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value=""><?= __t('Select Room', 'خونه انتخاب کړئ', 'انتخاب اتاق') ?></option>
                    <?php foreach($rooms as $room): ?>
                    <option value="<?= $room['id'] ?>"><?= htmlspecialchars($room['room_code'] . ' - ' . $room['room_name'] . ' (Capacity: ' . $room['capacity'] . ')') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"><?= __t('Batch Year', 'د فراغت کال', 'سال ورودی') ?></label>
                <input type="number" name="batch_year" value="<?= date('Y') ?>" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2 <?= $isRTL ? 'flex-row-reverse' : '' ?>">
                    <i class="ri-save-line"></i>
                    <span><?= __t('Save', 'خوندي کول', 'ذخیره') ?></span>
                </button>
                <button type="button" onclick="document.getElementById('addEntryModal').classList.add('hidden')" class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white px-6 py-2 rounded-lg transition">
                    <?= __t('Cancel', 'لغوه کول', 'لغو') ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function submitTimetable() {
    if(confirm('<?= __t('Are you sure you want to submit this timetable for approval?', 'ایا تاسو ډاډه یاست چې تاسو غواړئ دا مهالویش د تصویب لپاره وسپارئ؟', 'آیا مطمئن هستید که می‌خواهید این جدول زمانی را برای تایید ارسال کنید؟') ?>')) {
        window.location.href = 'index.php?route=planning/submit-timetable&faculty_id=<?= $facultyId ?>';
    }
}

function approveTimetable() {
    if(confirm('<?= __t('Are you sure you want to approve this timetable?', 'ایا تاسو ډاډه یاست چې تاسو غواړئ دا مهالویش تصویب کړئ؟', 'آیا مطمئن هستید که می‌خواهید این جدول زمانی را تایید کنید؟') ?>')) {
        window.location.href = 'index.php?route=planning/approve-timetable&faculty_id=<?= $facultyId ?>';
    }
}

function editEntry(id) {
    window.location.href = 'index.php?route=timetable/edit/' + id;
}

function deleteEntry(id) {
    if(confirm('<?= __t('Are you sure you want to delete this entry?', 'ایا تاسو ډاډه یاست چې تاسو غواړئ دا داخله حذف کړئ؟', 'آیا مطمئن هستید که می‌خواهید این ورودی را حذف کنید؟') ?>')) {
        window.location.href = 'index.php?route=timetable/delete/' + id;
    }
}
</script>

<?php require $rootPath . '/src/Views/layouts/footer.php'; ?>