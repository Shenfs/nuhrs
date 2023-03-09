<?php 
include_once("../db-connection.php"); //include file
include_once("../Utilities/alert.php"); //include file
include_once("../Utilities/calculate-age.php"); //include file
include_once("../Utilities/insertToActivityLogs.php");

class ProfileController extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function updateProfileDetails($conn){
        if(isset($_POST['update_profile'])){//check if update profile button is clicked
    
            if($_POST['user_type_id'] == 1){//if user ay admin mag eexecute yung code below
                $id = $_POST['id'];
                $firstname = $_POST['first_name'];
                empty($_POST['middle_name']) ? $middlename = "" : $middlename = $_POST['middle_name'];
                $lastname = $_POST['last_name'];
                $birthdate = $_POST['birthdate'];                                                       //] getting user input
                $age = calculateAge($birthdate);//calculate age based on birthdate
                $sex = $_POST['sex'];
                $nationality = $_POST['nationality'];
                $religion = $_POST['religion'];
                $specialization = $_POST['specialization'];
                $contact_number = "+63".$_POST['contact_number'];
                $address = $_POST['address'];
                $email_address = $_POST['email_address'];
        
                $update_account = mysqli_query($conn, "UPDATE users SET firstName='$firstname',middleName='$middlename',lastName='$lastname',email_address='$email_address' WHERE id='$id'");// query to update user info
        
                if($update_account){//checking if query is successful
                    $update_info = mysqli_query($conn,"UPDATE medicalprofessional SET specialization='$specialization',birthdate='$birthdate',address='$address',nationality='$nationality',sex='$sex',contact_number='$contact_number',religion='$religion',age='$age' WHERE userID='$id'"); //query to update medical professional info
        
                    if($update_info){//if query ay successful 
                        insertToActivityLogs($conn,$id,"Update Account Details","Date Updated ".date('Y-m-d h:i A'));
                        alert("success","Account Details Successfully Updated","","../medical_professional/profile.php");//success message
                    }
                    else{
                        alert("error","There was an error","","../medical_professional/profile.php");//error message
                    }
                }
                else{
                    alert("error","There was an error","","../medical_professional/profile.php");//error message
                }
            }
            else{
                $id = $_POST['id'];
                $firstname = $_POST['first_name'];
                empty($_POST['middle_name']) ? $middlename = "" : $middlename = $_POST['middle_name'];
                $lastname = $_POST['last_name'];
                $email_address = $_POST['email_address'];

                $update_account = mysqli_query($conn, "UPDATE users SET firstName='$firstname',middleName='$middlename',lastName='$lastname',email_address='$email_address' WHERE id='$id'");// query to update user info
        
                if($update_account){//checking if query is successful
                    insertToActivityLogs($conn,$id,"Update Account Details","Date Updated ".date('Y-m-d h:i A'));
                    alert("success","Account Details Successfully Updated","","../super_admin/profile.php");//success message 
                }
                else{
                    alert("error","There was an error","","../super_admin/profile.php");//error message
                }
            }

            
            
        }
    }

    public static function changePassword($conn){
        if(isset($_POST['change_password'])){//check if change password button is clicked
    
            if($_POST['user_type_id'] == 1){//check if user is admin
                $id = $_POST['id'];
                $user_type_id = $_POST['user_type_id'];
                $old_password = $_POST['old_password'];             //] getting user info
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
        
                $selectCorrectPassword = mysqli_query($conn,"SELECT password FROM users WHERE id='$id'");
                $row = $selectCorrectPassword->fetch_assoc();
                $correct_password = $row['password'];//getting user's correct password
        
                if($old_password == $correct_password){//check if current password is matched
        
                    if($new_password == $confirm_password){//check if new and confirm password is marched
        
                        $new_password = $new_password; //enrypting new password
        
                        $change_password = mysqli_query($conn,"UPDATE users set password='$new_password' WHERE id='$id'");// change password query
        
                        if($change_password){// if change password query is successful
                            insertToActivityLogs($conn,$id,"Change Password","Date Changed ".date('Y-m-d h:i A'));
                            alert("success","Password Successfuly Changed","","../medical_professional/profile.php");//success message
                        }
                        else{
                            alert("error","There was an error","","../medical_professional/profile.php");//error message
                        }
        
                    }
                    else{//if new and confirm password doesn't matched
                        alert("error","New Password and Confirm Password is not matched","","../medical_professional/profile.php");//error message
                    }
        
                }
                else{//if user current password is not matched
                    alert("error","Current Password is incorrect","","../medical_professional/profile.php");//error message
                }
            }
            elseif($_POST['user_type_id'] == 2){
                $id = $_POST['id'];
                $user_type_id = $_POST['user_type_id'];
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];                     //] getting user info
                $confirm_password = $_POST['confirm_password'];
        
                $selectCorrectPassword = mysqli_query($conn,"SELECT password FROM users WHERE id='$id'");
                $row = $selectCorrectPassword->fetch_assoc();
                $correct_password = $row['password'];//getting user's correct password
        
                if($old_password == $correct_password){//check if user is admin student
        
                    if($new_password == $confirm_password){//check if current password is matched
        
                        $new_password =$new_password;//enrypting new password
        
                        $change_password = mysqli_query($conn,"UPDATE users set password='$new_password' WHERE id='$id'");// change password query
        
                        if($change_password){// if change password query is successful
                            insertToActivityLogs($conn,$id,"Change Password","Date Changed ".date('Y-m-d h:i A'));
                            alert("success","Password Successfuly Changed","","../student/profile.php");//success message
                        }
                        else{
                            alert("error","There was an error","","../student/profile.php");//error message
                        }
        
                    }
                    else{//if new and confirm password doesn't matched
                        alert("error","New Password and Confirm Password is not matched","","../student/profile.php");//error message
                    }
        
                }
                else{//if user current password is not matched
                    alert("error","Current Password is incorrect","","../student/profile.php");//error message
                }
            }
            else{
                $id = $_POST['id'];
                $user_type_id = $_POST['user_type_id'];
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];                     //] getting user info
                $confirm_password = $_POST['confirm_password'];
        
                $selectCorrectPassword = mysqli_query($conn,"SELECT password FROM users WHERE id='$id'");
                $row = $selectCorrectPassword->fetch_assoc();
                $correct_password = $row['password'];//getting user's correct password
        
                if($old_password == $correct_password){//check if user is admin student
        
                    if($new_password == $confirm_password){//check if current password is matched
        
                        $new_password =$new_password;//enrypting new password
        
                        $change_password = mysqli_query($conn,"UPDATE users set password='$new_password' WHERE id='$id'");// change password query
        
                        if($change_password){// if change password query is successful
                            insertToActivityLogs($conn,$id,"Change Password","Date Changed ".date('Y-m-d h:i A'));
                            alert("success","Password Successfuly Changed","","../super_admin/profile.php");//success message
                        }
                        else{
                            alert("error","There was an error","","../super_admin/profile.php");//error message
                        }
        
                    }
                    else{//if new and confirm password doesn't matched
                        alert("error","New Password and Confirm Password is not matched","","../super_admin/profile.php");//error message
                    }
        
                }
                else{//if user current password is not matched
                    alert("error","Current Password is incorrect","","../super_admin/profile.php");//error message
                }
            }
        }
    }

    public static function ChangeAvatar($conn){
        if(isset($_POST['change_avatar'])){
    
            $file = $_FILES['file'];
            
            $active_user_type_id = $_POST['user_type_id'];
            $id = $_POST['id'];
        
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];
        
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
        
            $allowed = array('jpg', 'jpeg', 'png');
        
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 500000) {
                        $fileNameNew = "profile_".$id.".".$fileActualExt;
                        $fileDestination = 'user_avatars/'.$fileNameNew;
                        $selectOldAvatar = mysqli_query($conn,"SELECT profile_img FROM users WHERE id='$id' ORDER BY id DESC LIMIT 1");
                        $OldAvatar = $selectOldAvatar->fetch_assoc();
                        
        
                        if(!empty($OldAvatar['profile_img'])){
                           
                            $OldAvatar = $OldAvatar['profile_img'];
                            unlink("user_avatars/".$OldAvatar);
                        }
        
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $change_avatar = mysqli_query($conn,"UPDATE users SET profile_img='$fileNameNew' WHERE id='$id'");
                        
                        if($change_avatar){
                            insertToActivityLogs($conn,$id,"Change Avatar","Date Updated ".date('Y-m-d h:i A'));
                            switch($active_user_type_id){
                                
                                case 1 : alert("success","Avatar Successfully Changed","","../medical_professional/profile.php"); break;
                                case 2 : alert("success","Avatar Successfully Changed","","../student/profile.php"); break;
                                case 3 : alert("success","Avatar Successfully Changed","","../super_admin/profile.php"); break;
                                default : echo "There was an error";
                            }
                        }
                    } else {
                        switch($active_user_type_id){
                            case 1 : alert("error","Your file is too big!","","../medical_professional/profile.php"); break;
                            case 2 : alert("error","Your file is too big!","","../student/profile.php"); break;
                            case 3 : alert("error","Your file is too big!","","../super_admin/profile.php"); break;
                            default : echo "There was an error";
                        }
                    }
                } else {
                    switch($active_user_type_id){
                        case 1 : alert("error","There was an error uploading your file!","","../medical_professional/profile.php"); break;
                        case 2 : alert("error","There was an error uploading your file!","","../student/profile.php"); break;
                        case 4 : alert("error","There was an error uploading your file!","","../super_admin/profile.php"); break;
                        default : echo "There was an error";
                    }
                }
            } else {
                switch($active_user_type_id){
                    case 1 : alert("error","You cannot upload files of this type!","","../medical_professional/profile.php"); break;
                    case 2 : alert("error","You cannot upload files of this type!","","../student/profile.php"); break;
                    case 3 : alert("error","You cannot upload files of this type!","","../super_admin/profile.php"); break;
                    default : echo "There was an error";
                }
            }
        }
    }
}
$db = new DatabaseConnection();
ProfileController::updateProfileDetails($db->conn);
ProfileController::changePassword($db->conn);
ProfileController::ChangeAvatar($db->conn);





?>