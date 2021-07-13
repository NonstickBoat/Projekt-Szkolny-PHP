<?php
require('./connect.php');
foreach($_POST as $key =>$value){
    // echo "$key => $value<br>";
    $$key=$value;
}
$sql = "INSERT INTO `games` (`game_id`, `game_name`, `description`, `release_date`) VALUES (NULL, ?,?,?)";
if($stmt = $connect->prepare($sql)){
    $stmt->bind_param("sss", $param_name,$param_description,$param_release_date);

    $param_name=$name;
    $param_description=$description;
    $param_release_date=$release_date;
    
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