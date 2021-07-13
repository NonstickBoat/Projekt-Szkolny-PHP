<?php
session_start();

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true){
    header("location: ../login.php");
    exit;
}
 

require_once "connect.php";

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(mb_strlen(trim($_POST["new_password"])) < 6||mb_strlen(trim($_POST["new_password"])) > 25){
        $new_password_err = "Hasło musi zawierać od 6 do 25 znaków.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Proszę potwierdzić hasło.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Hasła są różne.";
        }
    }
        

    if(empty($new_password_err) && empty($confirm_password_err)){

        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        
        if($stmt = $connect->prepare($sql)){

            $stmt->bind_param("si", $param_password, $param_id);
            
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id =$_SESSION["id"];
            

            if($stmt->execute()){

                session_destroy();
                header("location: ../login_form.php");
                exit();
            } else{
                echo "Oops! Coś poszło nie tak.";
            }


            $stmt->close();
        }
        else{
            echo $connect->error;}
    }
    else{echo $new_password_err, $confirm_password_err;}
    

    $connect->close();
}
?>