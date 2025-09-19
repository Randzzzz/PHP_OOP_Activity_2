<?php
include '../includes/navbar_admin.php';
require_once "../core/init.php";
require_once "../core/auth.php";
require_login('admin');

$courses = $courseObj->getCourse();
$filter_course_id = $_GET['course_id'] ?? null;
$excuse_letters = $excuseLetterObj->getExcuseLetters($filter_course_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Document</title>
</head>
<body>
<div class="max-w-5xl mx-auto mt-8 p-6 bg-white shadow rounded">
  <h2 class="text-2xl font-semibold mb-4">Excuse Letters</h2>
  <form method="GET" class="mb-6 flex gap-2">
    <select name="course_id" class="border rounded p-2">
      <option value="">-- All Courses --</option>
      <?php foreach ($courses as $course): ?>
        <option value="<?= $course['id'] ?>" <?= ($filter_course_id == $course['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($course['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="bg-[#829374] text-white px-4 rounded-md hover:bg-[#4b5b40] font-medium cursor-pointer">Filter</button>
  </form>

  <div class="grid gap-4">
    <?php if ($excuse_letters): ?>
      <?php foreach ($excuse_letters as $excuse): ?>
        <div class="relative bg-white/80 border border-gray-200 rounded-lg p-4 shadow flex flex-col overflow-hidden">
          <div class="flex justify-between items-start mb-2">
            <div class="flex-1 min-w-0">
              <span class="font-medium text-base text-gray-800 break-words whitespace-normal"><?= htmlspecialchars($excuse['content']); ?></span>
              <div class="text-sm text-gray-600 mt-1">
                Student: <?= htmlspecialchars($excuse['first_name'] . ' ' . $excuse['last_name']) ?>
                | <?= htmlspecialchars($excuse['course']) ?> 
              </div>
              <div class="text-sm text-gray-600 mt-1">
                
                Year Level: <?= htmlspecialchars($excuse['year_level']) ?>
              </div>
            </div>
            <div class="flex-shrink-0 ml-2">
              <span class="text-xs text-gray-500 ml-4 whitespace-nowrap"><?= htmlspecialchars($excuse['date_excused']); ?></span>
            </div>
          </div>
          <div class="mt-2 flex items-center justify-between">
            <div>
              <?php if ($excuse['status'] == 'Approved'): ?>
                <span class="text-green-600 font-semibold">Approved</span>
              <?php elseif ($excuse['status'] == 'Rejected'): ?>
                <span class="text-red-600 font-semibold">Rejected</span>
              <?php else: ?>
                <span class="text-yellow-600 font-semibold">Pending</span>
              <?php endif; ?>
            </div>
            <?php if ($excuse['status'] === 'Pending'): ?>
              <form action="../core/handleForms.php" method="POST" class="flex gap-2">
                <input type="hidden" name="excuse_id" value="<?= $excuse['id'] ?>">
                <button type="submit" name="approve_excuse" class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-700">Approve</button>
                <button type="submit" name="reject_excuse" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-700">Reject</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="text-gray-500">No excuse letters found.</div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>