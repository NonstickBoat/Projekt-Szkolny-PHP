<?php
session_start();
if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		header('Location: ../index.php');
		exit();
	}

if(isset($_POST["username"])&&isset($_POST["password"])&&isset($_POST["email"])){
    require_once "connect.php";
    // Zadeklaruj i zainicjalizuj zmienne
    $username = $password=$password_val =$username_val = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";
    $email= $email_val= $email_err="";

    // Kiedy dostaniesz dane z formularza sprawdź je
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username_val=htmlentities(trim($_POST["username"]), ENT_QUOTES, "UTF-8");
        $password_val=htmlentities(trim($_POST["password"]), ENT_QUOTES, "UTF-8");
        $confirm_password_val=htmlentities(trim($_POST["confirm_password"]), ENT_QUOTES, "UTF-8");
        $email_val=htmlentities(trim($_POST["email"]), ENT_QUOTES, "UTF-8");

        // Walidacja nazwy użytkownik
        if(empty($username_val)){
            $username_err = "Proszę podaj nazwę użytkownika.";
    }   else{
        $username_val=mysqli_real_escape_string($connect,$username_val);
        // Zapytanie do bazy o użytkownika o wpisywanej właśnie nazwie
        $sql = "SELECT user_id FROM users WHERE username = ?";
        
        if($stmt = $connect->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            $param_username = $username_val;
            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1){
                    $username_err = "Konto z tą nazwą już istnieje.";
                } else{
                    $username = $username_val;
                }
            } else{
                echo "Oops! Coś poszło nie tak spróbuj później.";
            }

            // Zamknięcie prepared_statement
            $stmt->close();
        }
    }
    
    //  Walidacja hasła
    if(empty($password_val)){
        $password_err = "Proszę podać hasło."; 
    } elseif(mb_strlen($password_val) < 6||mb_strlen($password_val) >25){ 
        $password_err = "Hasło musi składać się od 6 do 25 znaków.";
    } 
   else{
        $password = $password_val;
    }
    
    // Walidacja potwerdzenia hasła
    if(empty($confirm_password_val)){
        $confirm_password_err = "Proszę potwierdzić hasło";     
    } else{
        $confirm_password = $confirm_password_val;
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Hasła nie zgadzają się.";
        }
    }
    
    // Walidacja emaila
    $email_val2=filter_var($email_val, FILTER_SANITIZE_EMAIL);
    if(empty($email_val)||filter_var($email_val, FILTER_VALIDATE_EMAIL)==false|| $email_val2!=$email_val){
       $email_err = "Proszę podać poprawny email."; 
    } else{
       $email = $email_val;
    }
    
    // Walidacja przez REGEX
    // function valid_email($str) {
    // return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    // }
    
    // if(empty($email_val2)||!valid_email($email_val2)|| $email_val2!=$email_val){
    //     $email_err = "Proszę podać poprawny email.";     
    // }else{
    //     $email = $email_val;
    // }
    

    // Zanim coś wyślemy sprawdź czy wszystko przeszło walidację
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)&&empty($email_err)){
        
        $sql = "INSERT INTO users (username, password,email) VALUES (?, ?, ?)";
         
        if($stmt = $connect->prepare($sql)){
            $stmt->bind_param("sss", $param_username, $param_password,$param_email);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Hashowanie hasła
            $param_email=$email;
            
            // Spróbuj wykonać zapytanie
            if($stmt->execute()){
                // Daj użytkownika na stronę logowania i usuń wszystkie errory oraz inne rzeczy
                unset($_SESSION['username_err']);
                unset($_SESSION['password_err']);
                unset($_SESSION['confirm_password_err']);
                unset($_SESSION['email_err']);
                unset($_SESSION['email']);
                unset($_SESSION['username']);
	            unset($_SESSION['login_err']);      
                header("location: ../login_form.php");
            } else{
                echo "Oops! Coś poszło nie tak. Spróbuj ponownie później.";
            }
            
            $stmt->close();
        }
    }
    //Jeżeli są jakieś błędy zwróć je do formularza
    else{
        $_SESSION['username_err']=$username_err;
        $_SESSION['password_err']=$password_err;
        $_SESSION['confirm_password_err']=$confirm_password_err;
        $_SESSION['email_err']=$email_err;
        $_SESSION['username']=$username;
        $_SESSION['email']=$email;
        header('Location: ../signup_form.php');
    }
    // Zamknij połączenie z BD
    $connect->close();
}
}
//Jeżeli dostał się tutaj w inny sposób niż formulrz odeślij do formularza
else
{
    header('Location: ../signup_form.php');
}
?>
 
