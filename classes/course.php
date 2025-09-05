<?php 
require_once "../core/database.php";
class Course extends Database{
  public function addCourse($name){
    $query = "INSERT INTO courses (name) VALUES (:name)";
    return $this->create($query, [':name' => $name]);
  }
  public function getCourse(){
    $query = "SELECT * FROM courses";
    return $this->read($query);
  }
  public function updateCourse($id, $name){
    $query = "UPDATE courses SET name = :name WHERE id = :id";
    return $this->update($query, [':id' => $id, ':name' => $name]);
  }
  public function deleteCourse($id){
    //delete students associated with the course (safe delete)
    $query = "DELETE FROM students WHERE course_id = :id";
    $this->delete($query, [':id' => $id]);

    $query = "DELETE FROM courses WHERE id = :id";
    return $this->delete($query, [':id' => $id]);
  }

}

?>