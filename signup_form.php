<?php session_start();
if(isset($_SESSION['username_err'])){
$username_err=$_SESSION['username_err'];
$password_err=$_SESSION['password_err'];
$confirm_password_err=$_SESSION['confirm_password_err'];
$email_err=$_SESSION['email_err'];
$username=$_SESSION['username'];
$email=$_SESSION['email'];

}else{
    $username_err="";
$password_err="";
$email_err="";
$email_err="";
$username="";
$email="";
$confirm_password_err="";
}
$password=$confirm_password="";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Zarejestruj się</h2>
        <p>Proszę wypełnić poniższy formularz!</p>
        <form action="./scripts/signup.php" method="post">
            <div class="form-group">
                <label>Nazwa użytkownika</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Potwierdź hasło</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Wyślij">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Masz już konto? <a href="login_form.php">Zaloguj się tutaj</a>.</p>
        </form>
    </div>    
</body>
</html>