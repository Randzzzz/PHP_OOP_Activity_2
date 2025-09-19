<?php
require_once "../core/database.php";

class ExcuseLetter extends Database {
	public function submitExcuseLetter($student_id, $content, $course_id, $date_excused) {
		$query = "INSERT INTO excuse_letters (student_id, content, course_id, date_excused, status) VALUES (:student_id, :content, :course_id, :date_excused, 'Pending')";
		return $this->create($query, [
			':student_id' => $student_id,
			':content' => $content,
			':course_id' => $course_id,
			':date_excused' => $date_excused
		]);
	}

	// Admin gets all excuse letters
	public function getExcuseLetters($course_id = null) {
		$params = [];
		$where = "";
		if ($course_id) {
			$where = "WHERE excuse_letters.course_id = :course_id"; //optional filter
			$params[':course_id'] = $course_id;
		}
		$query = "SELECT excuse_letters.*, users.first_name, users.last_name, courses.name AS course, students.year_level
			  	  FROM excuse_letters
			  		JOIN students ON excuse_letters.student_id = students.id
						JOIN users ON students.user_id = users.id
				  	JOIN courses ON excuse_letters.course_id = courses.id
				  	$where
				  	ORDER BY excuse_letters.date_added DESC";
		return $this->read($query, $params);
	}

	// Student display own excuse letters
	public function getStudentExcuseLetters($student_id) {
		$query = "SELECT * FROM excuse_letters WHERE student_id = :student_id ORDER BY date_added DESC";
		return $this->read($query, [':student_id' => $student_id]);
	}

	public function approveExcuseLetter($id) {
		// Get the excuse letter details
		$excuse = $this->read("SELECT * FROM excuse_letters WHERE id = :id", [':id' => $id]);
		if ($excuse && isset($excuse[0])) {
			$excuse = $excuse[0];
			
			$this->update(
				"UPDATE excuse_letters SET status = 'Approved' WHERE id = :id",
				[':id' => $id]
			);
			// Mark the attendance as excused for the specific student and date
			$this->update(
				"UPDATE attendance SET is_excused = 1 WHERE student_id = :student_id AND DATE(date_added) = :date_excused",
				[
					':student_id' => $excuse['student_id'],
					':date_excused' => $excuse['date_excused']
				]
			);
			return true;
		}
		return false;
	}

	public function rejectExcuseLetter($id) {
		$excuse = $this->read("SELECT * FROM excuse_letters WHERE id = :id", [':id' => $id]);
		if ($excuse && isset($excuse[0])) {
			$excuse = $excuse[0];
			
			$this->update(
				"UPDATE excuse_letters SET status = 'Rejected' WHERE id = :id",
				[':id' => $id]
			);
			// Mark the attendance as not excused for the specific student and date
			$this->update(
				"UPDATE attendance SET is_excused = 0 WHERE student_id = :student_id AND DATE(date_added) = :date_excused",
				[
					':student_id' => $excuse['student_id'],
					':date_excused' => $excuse['date_excused']
				]
			);
			return true;
		}
		return false;
	}
}
