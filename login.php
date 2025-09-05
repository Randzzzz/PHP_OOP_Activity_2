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
  <title>Login</title>
</head>
<body>
  <div class="flex items-center justify-center m-12">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
      <form action="core/handleForms.php" method="POST">
        
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
      
        <p>
          <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
          <input type="email" name="username" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
        </p>
        <p>
          <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
          <input type="password" name="password" required class="mt-1 block w-full border border-gray-500/50 rounded-md p-2 focus:outline-none focus:ring focus:border-transparent">
        </p>
        <input type="submit" name="log_user" value="Submit" class="mt-4 w-full bg-[#829374] text-white px-4 py-2 rounded hover:bg-[#4b5b40] cursor-pointer">
        <p class="mt-4 text-center text-sm text-gray-600">
          Don't have an account? You may register <a href="register.php" class="text-[#829374] hover:underline hover:text-[#4b5b40]">here.</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>