<?php 
session_start();
include 'includes/navbar_account.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Register</title>
</head>
<body>
  <div class="flex items-center justify-center m-12">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">

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

      <form action="core/handleForms.php" method="POST">
        <p>
        <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
        <input type="email" name="username" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
      </p>
      <p>
        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name:</label>
        <input type="text" name="first_name" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
      </p>
      <p>
        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name:</label>
        <input type="text" name="last_name" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
      </p>
      <p>
        <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
        <input type="password" name="password" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
      </p>
      <p>
        <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
        <select id="role" name="role" class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
          <option value="student" selected>Student</option>
          <option value="admin">Admin</option>
        </select>
      </p>

      <p id="admin-verification" class="hidden">
        <label for="admin_password" class="block text-sm font-medium text-gray-700">Admin Verification:</label>
        <input type="password" name="admin_password" id="admin_password" disabled required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
      </p>
      <input type="submit" name="reg_user" value="Submit" class="mt-4 w-full bg-[#829374] text-white px-4 py-2 rounded hover:bg-[#4b5b40] cursor-pointer">
      <p class="mt-4 text-center text-sm text-gray-600">
        Already have an account? Login <a href="login.php" class="text-[#829374] hover:underline hover:text-[#4b5b40]">here.</a>
      </p>
      </form>
    </div>
  </div>

  <script>
    const roleSelect = document.getElementById("role");
    const adminVerification = document.getElementById("admin-verification");
    const adminPassword = document.getElementById("admin_password");

    roleSelect.addEventListener("change", function() {
      if (this.value === "admin") {
        adminVerification.classList.remove("hidden");
        adminPassword.disabled = false; 
      } else {
        adminVerification.classList.add("hidden");
        adminPassword.disabled = true;
        adminPassword.value = ""; 
      }
    });
  </script>
</body>
</html>