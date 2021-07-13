<?php
require('./connect.php');
foreach($_POST as $key =>$value){
    // echo "$key => $value<br>";
    $$key=$value;
}
$sql = "INSERT INTO `genre` (`genre_id`, `genre_name`) VALUES (NULL, ?)";
if($stmt = $connect->prepare($sql)){
    $stmt->bind_param("s", $param_name);

    $param_name=$name;
    
   if($stmt->execute()){
    if($stmt->affected_rows){
        header('location: ../admin.php?add=1');
    }
    else{
        header('location: ../admin.php?add=0');
    }
   }
   else{
    header('location: ../admin.php?add=0');
   }

    // Close statement
    $stmt->close();
}else{
    echo $connect->error;
}
$connect->close();

?>