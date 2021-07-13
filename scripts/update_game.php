<?php
require_once './connect.php';
foreach($_POST as $key =>$value){
    // echo "$key => $value<br>";
    $$key=$value;
}
$sql = "UPDATE `games` SET `game_name` = ?, `description` = ?, `release_date` = ? WHERE `games`.`game_id` = ?";
if($stmt = $connect->prepare($sql)){
    $stmt->bind_param("sssi", $param_name,$param_description,$param_release_date,$param_game_id);

    $param_name=$name;
    $param_description=$description;
    $param_release_date=$release_date;
    $param_game_id=$id;
   if($stmt->execute()){
    if($stmt->affected_rows){
        header('location: ../admin.php?update=1');
    }
    else{
        header('location: ../admin.php?update=0');
    }
   }
   else{
    header('location: ../admin.php?update=0');
   }

    // Close statement
    $stmt->close();
}else{
    echo $connect->error;
}
$connect->close();
?>