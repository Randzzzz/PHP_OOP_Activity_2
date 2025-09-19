<?php 
include '../includes/navbar_student.php';

require_once "../core/init.php";
require_once "../core/auth.php";
require_login('student');

$user_id = $_SESSION['user']['id'];
$student = $studentObj->getStudentByUserId($user_id);

$student = $studentObj->getStudentByUserId($user_id);
if (!$student) {
    header("Location: registrationForm.php");
    exit();
}

$attendance_history = $attendanceObj->getAttendance($student['id']);
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
  <div class="flex items-center justify-center m-12">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
      <h1 class="text-2xl font-bold mb-4">Welcome, <?= htmlspecialchars($_SESSION['user']['first_name']); ?>!</h1>
      
    <?php if (isset($_SESSION['success'])): ?>
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        <?= $_SESSION['success']; ?>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <?= $_SESSION['error']; ?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="../core/handleForms.php" method="POST">
      <h2 class="text-lg font-semibold mb-2">File Attendance</h2>
      <input type="hidden" name="student_id" value="<?= $student['id']; ?>">
      <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
      <select name="status" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
        <option value="present">Present</option>
        <option value="absent">Absent</option>
      </select>
      <button type="submit" name="file_attendance" class="mt-3 w-full bg-[#829374] text-white font-medium py-2 rounded-md shadow-sm hover:bg-[#4b5b40] cursor-pointer">Submit</button>
    </form>
    <hr class="my-6 border-gray-300">
    <div class="flex justify-center">
      <a href="../core/logout.php" class="text-[#829374] hover:underline hover:text-[#4b5b40]">Logout</a>
    </div>
    </div>
  </div>

  <!-- attendance history -->
  <div class="max-w-6xl mx-auto mt-8 p-6 bg-white shadow rounded">
    <h2 class="text-xl font-semibold mb-4">My Attendance History</h2>
    <table class="w-full border border-gray-300 rounded">
      <thead class="bg-[#cdd4c6]">
        <tr>
          <th class="p-2 border">Course</th>
          <th class="p-2 border">Year</th>
          <th class="p-2 border">Status</th>
          <th class="p-2 border">Late?</th>
          <th class="p-2 border">Date</th>
          <th class="p-2 border">Excused</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($attendance_history)): ?>
          <?php foreach ($attendance_history as $student_record): ?>
            <tr class="text-center">
              <td class="p-2 border"><?= htmlspecialchars($student_record['course']); ?></td>
              <td class="p-2 border"><?= $student_record['year_level']; ?></td>
              <td class="p-2 border"><?= $student_record['status']; ?></td>
              <td class="p-2 border"><?= $student_record['is_late'] ? 'Yes' : 'No'; ?></td>
              <td class="p-2 border"><?= $student_record['date_added']; ?></td>
              <td class="p-2 border"><?= $student_record['is_excused'] ? 'Yes' : 'No'; ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="p-2 border text-gray-500 text-center">No attendance history found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>