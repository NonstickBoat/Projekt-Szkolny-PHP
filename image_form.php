<?php 
 if(!isset($_SESSION['user_level'])||$_SESSION['user_level']===0){
    header('Location: index.php');
   exit();
   }
  
?>
<!DOCTYPE html>
<html>
<body>

<form action="./scripts/image_upload.php" method="post" enctype="multipart/form-data">
  Wybierz plik do wysłania:
  <input type="file" name="fileToUpload" id="fileToUpload"><br>
  <input type="text" name="alt"><br>
  <input type="submit" value="Wyślij plik" name="submit">
</form>

</body>
</html>