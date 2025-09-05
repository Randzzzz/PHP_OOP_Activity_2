<?php 
require_once "../core/database.php";
class Attendance extends Database{
  public function addAttendance($student_id, $status, $is_late){
    $query = "INSERT INTO attendance (student_id, status, is_late) VALUES (:student_id, :status, :is_late)";
    return $this->create($query, [':student_id' => $student_id, ':status' => $status, ':is_late' => $is_late]);
  }
  public function getAttendance($student_id){
    $query = "SELECT attendance.id AS attendance_id,
                     courses.name AS course,
                     students.year_level,
                     attendance.status,
                     attendance.is_late,
                     attendance.date_added
              FROM attendance
              JOIN students ON attendance.student_id = students.id
              JOIN courses ON students.course_id = courses.id
              WHERE attendance.student_id = :student_id
              ORDER BY attendance.date_added DESC";
    return $this->read($query, [':student_id' => $student_id]);
  }
  // admin function to check certain program/year level
  public function getAttendanceByCourseYear($course_id, $year_level) {
        $query = "SELECT attendance.id AS attendance_id,
                         users.first_name,
                         users.last_name,
                         courses.name AS course,
                         students.year_level,
                         attendance.status,
                         attendance.is_late,
                         attendance.date_added
                  FROM attendance
                  JOIN students ON attendance.student_id = students.id
                  JOIN users ON students.user_id = users.id
                  JOIN courses ON students.course_id = courses.id
                  WHERE students.course_id = :course_id
                  AND students.year_level = :year_level
                  ORDER BY attendance.date_added DESC";
        return $this->read($query, [':course_id' => $course_id, ':year_level' => $year_level]);
    }

}

?>