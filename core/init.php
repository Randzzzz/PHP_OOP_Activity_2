<?php
session_start();

require_once "../classes/attendance.php";
require_once "../classes/course.php";
require_once "../classes/student.php";
require_once "../classes/user.php";

$attendanceObj = new Attendance();
$courseObj = new Course();
$studentObj = new Student();
$userObj = new User();
?>
