<?php 
require_once("../db-connection.php");
$db = new DatabaseConnection();
$conn = $db->conn;
$student_id = $_POST['student_id'];

$selectAgeFromStudent = mysqli_query($conn,"SELECT age FROM students WHERE id='$student_id'");

while($row = $selectAgeFromStudent->fetch_assoc()){
    $age = $row['age'];
}
echo $age;
?>