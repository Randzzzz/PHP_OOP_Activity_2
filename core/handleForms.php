<?php

require_once "init.php";

// Login and Registration Handling
if(isset($_POST['reg_user'])){
  $username = $_POST['username'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  $admin_verification = "admin123"; // Example admin verification password
  if($role === "admin"){
    if(!isset($_POST['admin_password']) || $_POST['admin_password'] !== $admin_verification){
      $_SESSION['error'] = "Invalid admin verification password.";
      header("Location: ../register.php");
      exit();
    }
  }

  $result = $userObj->register($username, $first_name, $last_name, $password, $role);

  if($result){
    $_SESSION['success'] = "Registration successful.";
    header("Location: ../login.php");
    exit();
  } else {
    $_SESSION['error'] = "Registration failed. Please try again.";
    header("Location: ../register.php");
    exit();
  }
}

if(isset($_POST['log_user'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

  $user = $userObj->login($username, $password);

  if($user){
    $_SESSION['user'] = $user;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    if($user['role'] === 'admin'){
      header("Location: ../admin/index.php");
    } else {
      header("Location: ../student/registrationForm.php");
    }
    exit;
  } else {
    $_SESSION['error'] = "Invalid username or password.";
    header("Location: ../login.php");
    exit();
  }
}

// Student Management
if (isset($_POST['register_student'])) {
    $user_id = $_POST['user_id'];
    $course_id = $_POST['course_id'];
    $year = $_POST['year_level'];

    if ($studentObj->addStudent($user_id, $course_id, $year)) {
        $_SESSION['success'] = "Student profile registered successfully.";
        header("Location: ../student/index.php");
    } else {
        $_SESSION['error'] = "Failed to register student profile.";
        header("Location: ../student/register.php");
    }
    exit();
}

if (isset($_POST['save_student'])) {
    $id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $year = $_POST['year_level'];
    if ($studentObj->updateStudent($id, $course_id, $year)) {
        $_SESSION['success'] = "Student updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update student.";
    }
    header("Location: ../admin/index.php");
    exit();
}

if (isset($_GET['delete_student'])) {
    $student_id = $_GET['delete_student'];
    $studentObj->deleteStudent($student_id);
    $_SESSION['success'] = "Student deleted successfully.";
    header("Location: ../admin/index.php");
    exit();
}

// Course Management
if (isset($_POST['add_course'])) {
    $name = trim($_POST['name']);
    if ($courseObj->addCourse($name)) {
        $_SESSION['success'] = "Course added successfully.";
        header("Location: ../admin/index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to add course.";
    }
}

if (isset($_POST['save_course'])) {
    $id = $_POST['course_id'];
    $name = $_POST['name'];
    if ($courseObj->updateCourse($id, $name)) {
        $_SESSION['success'] = "Course updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update course.";
    }
    header("Location: ../admin/index.php");
    exit();
}

if (isset($_GET['delete_course'])) {
    $course_id = $_GET['delete_course'];
    $courseObj->deleteCourse($course_id);
    $_SESSION['success'] = "Course deleted.";
    header("Location: ../admin/index.php");
    exit();
}

// Attendance Management
if (isset($_POST['file_attendance'])) {
    $student_id = $_POST['student_id'];
    $status = $_POST['status'];

    // mark as late if time is after 8:00 AM
    $current_time = date("H:i:s");
    $is_late = ($current_time > "08:00:00") ? 1 : 0;

    if ($attendanceObj->addAttendance($student_id, $status, $is_late)) {
        $_SESSION['success'] = "Attendance filed successfully.";
    } else {
        $_SESSION['error'] = "Failed to file attendance.";
    }
    header("Location: ../student/index.php");
    exit();
}
?>