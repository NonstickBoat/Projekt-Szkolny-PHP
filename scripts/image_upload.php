<?php
require_once("connect.php");
$target_dir = "../pictures/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "Plik jest zdjęciem - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "Plik nie jest zdjęciem.";
    $uploadOk = 0;
  }
}


if (file_exists($target_file)) {
  echo "Przepraszamy ale plik już istnieje.";
  $uploadOk = 0;
}


if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Przepraszamy ale plik jest za duży.";
  $uploadOk = 0;
}


if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Przepraszamy ale przyjmujemy tylko pliki jpg, png, jpeg oraz gif.";
  $uploadOk = 0;
}


if ($uploadOk == 0) {
  echo "Twój plik nie został wrzucony.";
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "Plik ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " został wrzucony.";
    $path= htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
    $sql = "INSERT INTO `photo` (`photo_id`, `path`, `alt`) VALUES (NULL, ?, ?)";
    if($stmt = $connect->prepare($sql)){
        $stmt->bind_param("ss", $param_path,$param_alt);
            $param_path=$path;
            $param_alt=$_POST['alt'];
        
            if($stmt->execute()){
                echo " Wstawiono do bazy";
            }
            else{
                echo " Coś poszło nie tak";
            }
        
        // Close statement
        $stmt->close();
    }
    else{
        echo " Coś poszło nie tak";
    }

  } else {
    echo "Przepraszamy był błąd przy wysyłaniu pliku.";
  }
}
?>