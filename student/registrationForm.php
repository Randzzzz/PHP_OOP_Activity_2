<?php 
include '../includes/navbar_student.php';

require_once "../core/init.php";
require_once "../core/auth.php";
require_login('student');

$user_id = $_SESSION['user']['id'];
$student = $studentObj->getStudentByUserId($user_id);

if ($student) {
    header("Location: index.php");
    exit();
}

$courses = $courseObj->getCourse();
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
      <h1 class="text-2xl font-bold mb-4"> Student Registration</h1>
      
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
      <input type="hidden" name="user_id" value="<?= $user_id ?>">
      <label for="course_id" class="block text-sm font-medium text-gray-700">Select Course/Program:</label>
      <select name="course_id" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
        <option value="">-- Select Course --</option>
        <?php foreach ($courses as $course): ?>
          <option value="<?= $course['id']; ?>"><?= htmlspecialchars($course['name']); ?></option>
        <?php endforeach; ?>
      </select>

      <label for="year_level" class="block text-sm font-medium text-gray-700">Select Year Level:</label>
      <select name="year_level" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
        <option value="">-- Select Year Level --</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
      </select>

      <button type="submit" name="register_student" class="mt-3 w-full bg-[#829374] text-white font-medium py-2 rounded-md shadow-sm hover:bg-[#4b5b40] cursor-pointer">Register</button>
    </form>
    <hr class="my-6 border-gray-300">
    <div class="flex justify-center">
      <a href="../core/logout.php" class="text-[#829374] hover:underline hover:text-[#4b5b40]">Logout</a>
    </div>
    </div>
  </div>
</body>
</html>