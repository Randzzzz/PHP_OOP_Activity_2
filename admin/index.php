<?php 

include '../includes/navbar_admin.php';
require_once "../core/init.php";
require_once "../core/auth.php";
require_login('admin');

$courses = $courseObj->getCourse();

$edit_course_id = isset($_GET['edit_course']) ? $_GET['edit_course'] : null;
$student_course_id = $_GET['student_course_id'] ?? null;
$student_year = $_GET['student_year'] ?? null;

$selected_course = $_GET['course_id'] ?? null;
$selected_year   = $_GET['year_level'] ?? null;
$attendance_list = [];

if ($student_course_id || $student_year) {
  $students = $studentObj->getStudentsByFilter($student_course_id, $student_year);
} else {
  $students = $studentObj->getAllStudent();
}
if ($selected_course && $selected_year) {
    $attendance_list = $attendanceObj->getAttendanceByCourseYear($selected_course, $selected_year);
}

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
      <label for="name" class="block text-sm font-medium text-gray-700">Add Course:</label>
      <input type="text" name="name" placeholder="Course/Program Name" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
      <button type="submit" name="add_course" class="mt-3 w-full bg-[#829374] text-white font-medium py-2 rounded-md shadow-sm hover:bg-[#4b5b40] cursor-pointer">Add</button>
    </form>
    <hr class="my-6 border-gray-300">
    <div class="flex justify-center">
      <a href="../core/logout.php" class="text-[#829374] hover:underline hover:text-[#4b5b40]">Logout</a>
    </div>
    </div>
  </div>
  
  <!-- Course List Table -->
  <div class="max-w-6xl mx-auto mt-8 p-6 bg-white shadow rounded">
    <div class="overflow-y-scroll" style="max-height: 400px;">
      <table class="w-full border border-gray-300 rounded">
        <thead class="bg-[#cdd4c6]">
          <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">Course Name</th>
            <th class="p-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($courses as $course): ?>
            <tr class="text-center">
              <td class="p-2 border"><?= $course['id']; ?></td>
                <?php if ($edit_course_id == $course['id']): ?>
                  <form action="../core/handleForms.php" method="POST">
                    <td class="p-2 border">
                      <input type="text" name="name" value="<?= htmlspecialchars($course['name']) ?>" class="border rounded p-2 w-full">
                      <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                    </td>
                    <td class="p-2 border">
                      <button type="submit" name="save_course" class="text-green-600 hover:underline mr-3 cursor-pointer" onclick="return confirm('Are you sure you want to edit this course?')">Save</button>
                      <a href="index.php" class="text-gray-600 hover:underline">Cancel</a>
                    </td>
                  </form>
                <?php else: ?>
                  <td class="p-2 border"><?= htmlspecialchars($course['name']); ?></td>
                  <td class="p-2 border">
                    <a href="index.php?edit_course=<?= $course['id']; ?>" class="text-green-600 hover:underline mr-2">Edit</a>
                    <a href="../core/handleForms.php?delete_course=<?= $course['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                  </td>
                <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Student table -->
  <div class="max-w-6xl mx-auto my-8 p-6 bg-white shadow rounded">
    <h2 class="text-xl font-semibold mb-4">Student Records</h2>
    
    <form method="GET" class="flex gap-2 mb-4">
      <select name="student_course_id" class="mt-1 border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
        <option value="">-- All Course --</option>
        <?php foreach ($courses as $course): ?>
          <option value="<?= $course['id']; ?>" <?= (($_GET['student_course_id'] ?? '') == $course['id']) ? 'selected' : ''; ?>>
            <?= htmlspecialchars($course['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <select name="student_year" class="mt-1 border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
        <option value="">-- All Year Level --</option>
        <option value="1" <?= ($_GET['student_year'] ?? '') == '1' ? 'selected' : ''; ?>>1st Year</option>
        <option value="2" <?= ($_GET['student_year'] ?? '') == '2' ? 'selected' : ''; ?>>2nd Year</option>
        <option value="3" <?= ($_GET['student_year'] ?? '') == '3' ? 'selected' : ''; ?>>3rd Year</option>
        <option value="4" <?= ($_GET['student_year'] ?? '') == '4' ? 'selected' : ''; ?>>4th Year</option>
      </select>
      <button type="Submit" class="bg-[#829374] text-white px-4 rounded-md hover:bg-[#4b5b40] font-medium cursor-pointer">Filter Table</button>
    </form>
    
    <div class="overflow-y-scroll" style="max-height: 400px;">
      <table class="w-full border border-gray-300 rounded">
        <thead class="bg-[#cdd4c6]">
          <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Course</th>
            <th class="p-2 border">Year</th>
            <th class="p-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $student_info): ?>
            <tr class="text-center">
              <td class="p-2 border"><?= $student_info['id']; ?></td>
              <?php if (isset($_GET['edit_student']) && $_GET['edit_student'] == $student_info['id']): ?>
                <form action="../core/handleForms.php" method="POST">
                  <td class="p-2 border"><?= htmlspecialchars($student_info['first_name'] . " " . $student_info['last_name']); ?></td>
                  <td class="p-2 border">
                    <select name="course_id" class="border rounded p-1">
                      <?php foreach ($courses as $course): ?>
                        <option value="<?= $course['id']; ?>" <?= $student_info['course_id'] == $course['id'] ? 'selected' : ''; ?>>
                          <?= htmlspecialchars($course['name']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                  <td class="p-2 border">
                    <select name="year_level" class="border rounded p-1">
                      <option value="1" <?= $student_info['year_level']=='1'?'selected':''; ?>>1st Year</option>
                      <option value="2" <?= $student_info['year_level']=='2'?'selected':''; ?>>2nd Year</option>
                      <option value="3" <?= $student_info['year_level']=='3'?'selected':''; ?>>3rd Year</option>
                      <option value="4" <?= $student_info['year_level']=='4'?'selected':''; ?>>4th Year</option>
                    </select>
                    <input type="hidden" name="student_id" value="<?= $student_info['id']; ?>">
                  </td>
                  <td class="p-2 border">
                    <button type="submit" name="save_student" class="text-green-600 hover:underline mr-2 cursor-pointer" onclick="return confirm('Are you sure you want to modify this student information?')">Save</button>
                    <a href="index.php" class="text-gray-600 hover:underline">Cancel</a>
                  </td>
                </form>
              <?php else: ?>
                <td class="p-2 border"><?= htmlspecialchars($student_info['first_name'] . " " . $student_info['last_name']); ?></td>
                <td class="p-2 border"><?= htmlspecialchars($student_info['course']); ?></td>
                <td class="p-2 border"><?= htmlspecialchars($student_info['year_level']); ?></td>
                <td class="p-2 border">
                  <a href="index.php?edit_student=<?= $student_info['id']; ?>" class="text-green-600 hover:underline mr-2">Edit</a>
                  <a href="../core/handleForms.php?delete_student=<?= $student_info['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- attendance table -->
  <div class="max-w-6xl mx-auto my-8 p-6 bg-white shadow rounded">
    <h2 class="text-xl font-semibold mb-4">Attendance Records</h2>
    
    <form method="GET" class="flex gap-2 mb-4">
      <select name="course_id" required class="mt-1 border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
        <option value="">-- Select Course --</option>
        <?php foreach ($courses as $course): ?>
          <option value="<?= $course['id']; ?>" <?= ($selected_course == $course['id']) ? 'selected' : ''; ?>>
            <?= htmlspecialchars($course['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <select name="year_level" required class="mt-1 border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
        <option value="">-- Select Year Level --</option>
        <option value="1" <?= $selected_year == '1' ? 'selected' : ''; ?>>1st Year</option>
        <option value="2" <?= $selected_year == '2' ? 'selected' : ''; ?>>2nd Year</option>
        <option value="3" <?= $selected_year == '3' ? 'selected' : ''; ?>>3rd Year</option>
        <option value="4" <?= $selected_year == '4' ? 'selected' : ''; ?>>4th Year</option>
      </select>
      <button type="Submit" class="bg-[#829374] text-white px-4 rounded-md hover:bg-[#4b5b40] font-medium cursor-pointer">Filter Table</button>
    </form>
    
    <div class="overflow-y-scroll" style="max-height: 400px;">
      <table class="w-full border border-gray-300 rounded">
        <thead class="bg-[#cdd4c6]">
          <tr>
            <th class="p-2 border">Student</th>
            <th class="p-2 border">Course</th>
            <th class="p-2 border">Year</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Late?</th>
            <th class="p-2 border">Date</th>
            <th class="p-2 border">Excused</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($attendance_list)): ?>
            <?php foreach ($attendance_list as $attendance): ?>
              <tr class="text-center">
                <td class="p-2 border"><?= htmlspecialchars($attendance['first_name'] . ' ' . $attendance['last_name']); ?></td>
                <td class="p-2 border"><?= htmlspecialchars($attendance['course']); ?></td>
                <td class="p-2 border"><?= htmlspecialchars($attendance['year_level']); ?></td>
                <td class="p-2 border"><?= htmlspecialchars($attendance['status']); ?></td>
                <td class="p-2 border"><?= $attendance['is_late'] ? 'Yes' : 'No'; ?></td>
                <td class="p-2 border"><?= htmlspecialchars(date('Y-m-d H:i', strtotime($attendance['date_added']))); ?></td>
                <td class="p-2 border"><?= $attendance['is_excused'] ? 'Yes' : 'No'; ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td class="p-2 border text-gray-500 text-center" colspan="7">No attendance records found.</td> 
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  
</body>

</html>
