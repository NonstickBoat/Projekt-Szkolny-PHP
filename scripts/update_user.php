<?php
require_once './connect.php';
foreach($_POST as $key =>$value){
    // echo "$key => $value<br>";
    $$key=$value;
}
if(empty($username)||empty($email)||empty($user_level)||empty($restriction)||empty($user_id)){
    header('location: ../admin.php?update=0');
    exit();
}
if($user_level<0||$user_level>2||$restriction>1||$restriction<0){
    header('location: ../admin.php?update=0');
    exit();
}



$sql = "UPDATE `users` SET `username` = ?, `email` = ?, `user_level` = ?, `restriction` = ? WHERE `users`.`user_id` = ?";
if($stmt = $connect->prepare($sql)){
    $stmt->bind_param("ssiii", $param_username,$param_email,$param_user_level,$param_restriction,$param_user_id);

    $param_username=$username;
    $param_email=$email;
    $param_user_level=$user_level;
    $param_restriction=$restriction;
    $param_user_id=$user_id;
   if($stmt->execute()){
    if($stmt->affected_rows){
        header('location: ../admin.php?update=1');
    }
    else{
        // echo $connect->error;
        header('location: ../admin.php?update=0');
    }
   }
   else{
    // echo $connect->error;
    header('location: ../admin.php?update=0');
   }

    // Close statement
    $stmt->close();
}else{
    echo $connect->error;
}
$connect->close();
?>