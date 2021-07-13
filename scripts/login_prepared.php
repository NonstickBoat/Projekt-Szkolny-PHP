<?php

session_start();
 
if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true){
    header("location: ../index.php");
    exit;
}
 

require_once "connect.php";
 

$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $username_err = "Podaj nazwę użytkownika.";
    } else{
        $username = htmlentities(trim($_POST["username"]), ENT_QUOTES, "UTF-8");
    }
    

    if(empty(trim($_POST["password"]))){
        $password_err = "Podaj hasło.";
    } else{
        $password = htmlentities(trim($_POST["password"]), ENT_QUOTES, "UTF-8");
    }
    

    if(empty($username_err) && empty($password_err)){
        $username=$connect->real_escape_string($username);
        $password=$connect->real_escape_string($password);

        $_SESSION['username_err']=$username_err;                    
        $_SESSION['password_err']=$password_err;
        $_SESSION['username']=$username;
        $_SESSION['login_err']=$login_err;
        
        $sql = "SELECT user_id, username, password, user_level,restriction FROM users WHERE username = ?";
        
        if($stmt = $connect->prepare($sql)){
            
            $stmt->bind_param("s", $param_username);
            
           
            $param_username = $username;
            
           
            if($stmt->execute()){
               
                $stmt->store_result();
                
               
                if($stmt->num_rows == 1){                    
                   
                    $stmt->bind_result($id, $username, $hashed_password ,$user_level,$restriction);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                          
                            session_start();
                            unset($_SESSION['username_err']);
                            unset($_SESSION['password_err']);
                            unset($_SESSION['confirm_password_err']);
                            unset($_SESSION['email_err']);
                            unset($_SESSION['email']);
                            unset($_SESSION['username']);
                            unset($_SESSION['login_err']);
	                        unset($_SESSION['login_err']);       
                            $_SESSION["logged"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username; 
                            $_SESSION["user_level"]= $user_level;   //Poziom użytkownika 
                            $_SESSION["restriction"]= $restriction; 
                                  
                           
                            header("Location: ../katalog.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $_SESSION['login_err']= "Niepoprawna nazwa użytkownika lub hasło.";
                            header('Location: ../login_form.php');
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $_SESSION['login_err']= "Niepoprawna nazwa użytkownika lub hasło.";
                    header('Location: ../login_form.php');
                }
            } else{
                $_SESSION['login_err']= "Coś poszło nie tak spróbuj później.";
                header('Location: ../login_form.php');
            }

            // Close statement
            $stmt->close();
        }else{
            echo $connect->error;
        }
    }
    else{
        $_SESSION['username_err']=$username_err;
        $_SESSION['password_err']=$password_err;
        $_SESSIOn['login_err']=$login_err;
        $_SESSION['username']=$username;  //To do: Sprawdź czy można usunąć to i komentarze poprzekształcaj

        header('Location: ../login_form.php');
    }
    // Close connection
    $connect->close();
}

?>
 