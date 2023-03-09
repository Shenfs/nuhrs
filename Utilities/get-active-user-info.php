<?php 
function getActiveAdminInfo($id,$firstname,$middlename,$lastname,$password,$email_address,$specialization,$birthdate,
$address,$nationality,$sex,$contact_number,$religion,$age) : array{

    $activeAdmin = array(
        "id" => $id,
        "firstname" => $firstname,
        "middlename" => $middlename,
        "lastname" => $lastname,
        "password" => $password,
        "email_address" => $email_address,
        "specialization" => $specialization,
        "birthdate" => $birthdate,
        "address" => $address,
        "nationality" => $nationality,
        "sex" => $sex,
        "contact_number" => $contact_number,
        "religion" => $religion,
        "age" => $age
    );

    return $activeAdmin;
}
?>