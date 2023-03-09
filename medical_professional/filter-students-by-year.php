<?php 
require_once("../db-connection.php");
$db = new DatabaseConnection();
$conn = $db->conn;

$year = $_POST['year'];


$selectStudents = mysqli_query($conn,"SELECT *, students.id AS stud_id  FROM students INNER JOIN users ON students.userID = users.id WHERE year='$year'");

    $json = [];
   while($row = $selectStudents->fetch_assoc()){
        $fullname = $row['firstName'].' '.$row['lastName'];
        $json[$row['stud_id']] = $fullname;
   }


   echo json_encode($json);
?>