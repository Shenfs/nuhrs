<?php 
function checkIfLoggedIn(){
    session_start();
    if(empty($_SESSION['active_user_id'])){
    header("Location: ../login.php");
    session_destroy();
    }
}
?>