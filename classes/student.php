<?php 
require_once "../core/database.php";
class Student extends Database{
  public function getStudentByUserId($user_id) {
    $query = "SELECT * FROM students WHERE user_id = :user_id LIMIT 1";
    return $this->read($query, [':user_id' => $user_id])[0] ?? null;
}
  public function addStudent($user_id, $course_id, $year_level){
    $query = "INSERT INTO students (user_id, course_id, year_level) VALUES (:user_id, :course_id, :year_level)";
    return $this->create($query, [':user_id' => $user_id, ':course_id' => $course_id, ':year_level' => $year_level]);
  }
  public function getAllStudent(){
  $query = "SELECT students.id,
           students.course_id,
           students.year_level,
           users.first_name,
           users.last_name,
           courses.name AS course
        FROM students
        JOIN users ON students.user_id = users.id
        JOIN courses ON students.course_id = courses.id
        ORDER BY users.last_name ASC";
  return $this->read($query);
  }
  public function getStudentsByFilter($course_id, $year_level) {
    $conditions = [];
    $params = [];
    if ($course_id) {
        $conditions[] = "students.course_id = :course_id";
        $params[':course_id'] = $course_id;
    }
    if ($year_level) {
        $conditions[] = "students.year_level = :year_level";
        $params[':year_level'] = $year_level;
    }
    $where = $conditions ? "WHERE " . implode(" AND ", $conditions) : "";
    $query = "SELECT students.id,
                     students.course_id,
                     students.year_level,
                     users.first_name, 
                     users.last_name, 
                     courses.name AS course
              FROM students
              JOIN users ON students.user_id = users.id
              JOIN courses ON students.course_id = courses.id
              $where
              ORDER BY users.last_name ASC";
    return $this->read($query, $params);
}
  public function updateStudent($id, $course_id, $year_level){
    $query = "UPDATE students SET course_id = :course_id, year_level = :year_level WHERE id = :id";
    return $this->update($query, [':id' => $id, ':course_id' => $course_id, ':year_level' => $year_level]);
  }
  public function deleteStudent($id){
  $query = "SELECT user_id FROM students WHERE id = :id";
  $result = $this->read($query, [':id' => $id]);
  $user_id = $result[0]['user_id'] ?? null;

  $query = "DELETE FROM attendance WHERE student_id = :id";
  $this->delete($query, [':id' => $id]);

  $query = "DELETE FROM students WHERE id = :id";
  $this->delete($query, [':id' => $id]);

  if ($user_id) {
    $query = "DELETE FROM users WHERE id = :user_id";
    return $this->delete($query, [':user_id' => $user_id]);
  }
  return false;
  }
}

?>