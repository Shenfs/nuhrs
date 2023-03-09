<?php 
include_once('../Utilities/calculate-age.php');	//include file
include_once('../db-connection.php');	//include file
include_once('../Utilities/alert.php');	//include file
include_once('../Utilities/insertToActivityLogs.php');
include_once('sweet-alert.php');

class LoginController extends DatabaseConnection{

	public function __construct()
	{
		parent::__construct();
	}

	public static function login($conn){
		if(isset($_POST['login'])){//check if login button is clicked
			$email = trim($_POST['email_address']); //getting user input
			$password = trim($_POST['password']); //getting user input
		
			
			
			$sql = "SELECT * FROM users WHERE email_address = '".$email."'"; //query to check if email is existing
			$rs = mysqli_query($conn,$sql);
			$numRows = mysqli_num_rows($rs);
			
			if($numRows == 1){//checking if email is existing
				
				while($row = mysqli_fetch_assoc($rs)){
					$correct_password = $row['password'];//fetching correct password
					$user_type_id = $row['user_type_id'];
					$id = $row['id'];
				}
				
					if($password == $correct_password){ //checking inputted password and user password
						session_start();//starting session
						$_SESSION['active_user_id'] = $id;//declaring session variable
						insertToActivityLogs($conn,$id,"Logged in","Logged in successful");
						switch($user_type_id){//checking user type if admin or stud
							case 1: header("Location: ../medical_professional/dashboard.php"); break; //if admin
							case 2: header("Location: ../student/dashboard.php"); break; //if stud
							case 3: header("Location: ../super_admin/dashboard.php"); break; //if stud
							default : header("Location: ../login.php?status=There_was_an_error"); //if there is an error
						}
					}
					else{
						alert('error','Unauthorized (401)','Incorrect Password','../login.php');
					}
			}
			else{
				
		
				alert('error','Unauthorized (401)','User can not be found','../login.php');
			}
		}
	}
}
$db = new DatabaseConnection();
LoginController::login($db->conn);
