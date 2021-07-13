<?php

	session_start();
	
	if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		header('Location: index.php');
		exit();
	}
	if(isset($_SESSION['username_err'])){
		$username=$_SESSION['username'];
		}else{
		$username="";
		}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<form action="./scripts/login_prepared.php" method="post">    
	
		Login: <br /> <input type="text" name="username" value="<?php echo $username;?>" /> <br />
		Hasło: <br /> <input type="password" name="password" /> <br /><br />
		<input type="submit" value="Zaloguj się" />
	
	</form>
<p>Nie masz konta? Załóż je <a href="signup_form.php">tutaj</a></p>
<?php
	if(isset($_SESSION['username_err']))	echo $_SESSION['username_err'];
	if(isset($_SESSION['password_err']))	echo $_SESSION['password_err'];
	if(isset($_SESSION['login_err']))	echo $_SESSION['login_err'];
?>
</body>
</html>