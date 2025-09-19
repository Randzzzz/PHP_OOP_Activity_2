<?php 
include '../includes/navbar_student.php';

require_once "../core/init.php";
require_once "../core/auth.php";
require_login('student');

$user_id = $_SESSION['user']['id'];
$student = $studentObj->getStudentByUserId($user_id);
$courses = $courseObj->getCourse();

// Fetch student's submitted excuse letters
$my_excuses = $excuseLetterObj->getStudentExcuseLetters($student['id']);
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

  <div class="max-w-4xl mx-auto mt-8 p-6 bg-white shadow rounded">
    <h2 class="text-xl font-semibold mb-4">Create an Excuse Letter</h2>
    <form action="../core/handleForms.php" method="POST">
      <input type="hidden" name="student_id" value="<?= $student['id']; ?>">
      <input type="hidden" name="course_id" value="<?= $student['course_id']; ?>">
      <div class="mb-4">
        <label for="date_excused" class="block text-sm font-medium text-gray-700">Date to Excuse</label>
        <input type="date" name="date_excused" required class="mt-1 block w-1/3 border border-gray-500/50 rounded-md p-2">
      </div>
      <div class="mb-4">
        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
        <textarea name="content" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2" rows="3" placeholder="State your reason..."></textarea>
      </div>
      <button type="submit" name="submit_excuse_letter" class="w-full bg-[#829374] text-white font-medium py-2 rounded-md shadow-sm hover:bg-[#4b5b40] cursor-pointer">Submit Excuse Letter</button>
    </form>
  </div>


  <div class="max-w-6xl mx-auto my-8 p-6 bg-white shadow rounded overflow-hidden">
    <h2 class="text-xl font-semibold mb-4">My Excuse Letters</h2>
    <div class="grid gap-4">
      <?php if (!empty($my_excuses)): ?>
        <?php foreach ($my_excuses as $excuse): ?>
          <div class="relative bg-white/80 border border-gray-200 rounded-lg p-4 shadow flex flex-col overflow-hidden ">
            <div class="flex justify-between items-start mb-2">
              <div class="flex-1 min-w-0">
                <span class="font-medium text-base text-gray-800 break-words whitespace-normal"><?= htmlspecialchars($excuse['content']); ?></span>
              </div>
              <div class="flex-shrink-0 ml-2">
                <span class="text-xs text-gray-500 ml-4 whitespace-nowrap"><?= htmlspecialchars($excuse['date_excused']); ?></span>
              </div>
              
            </div>
            <div class="mt-2">
              <?php if ($excuse['status'] == 'Approved'): ?>
                <span class="text-green-600 font-semibold">Approved</span>
              <?php elseif ($excuse['status'] == 'Rejected'): ?>
                <span class="text-red-600 font-semibold">Rejected</span>
              <?php else: ?>
                <span class="text-yellow-600 font-semibold">Pending</span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="text-gray-500 text-center">No excuse letters submitted.</div>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>