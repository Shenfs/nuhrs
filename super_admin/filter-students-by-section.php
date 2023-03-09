<?php 
require_once("../db-connection.php");
$db = new DatabaseConnection();
$conn = $db->conn;
$year = $_POST['year'];
$course = $_POST['course'];
$section = $_POST['section'];

$selectStudents = mysqli_query($conn,"SELECT *, students.id AS stud_id  FROM students INNER JOIN users ON students.userID = users.id WHERE year='$year' AND section='$section' AND courseID='$course'");

    $json = [];
   while($row = $selectStudents->fetch_assoc()){
        $fullname = $row['firstName'].' '.$row['lastName'];
        $json[$row['stud_id']] = $fullname;
   }


   echo json_encode($json);
?>