<?
session_start();
if(!isset($_SESSION['logged'])){
    header('Location: index.php');
   exit();
   }

   ?>
<!DOCTYPE html>
<html>
<body>

<form action="./scripts/password_reset.php" method="post" enctype="multipart/form-data">
  Podaj nowe hasło:
  <br><input type="password" name="new_password"><br>
  <input type="password" name="confirm_password"><br>
  <input type="submit" value="Zmień hasło" name="submit">
</form>

</body>
</html>