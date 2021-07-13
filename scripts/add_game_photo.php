<?php require_once('connect.php');
foreach($_POST as $key =>$value){
    // echo "$key => $value<br>";
    $$key=$value;
}
$sql = "INSERT INTO `games_photo` (`game_id`, `photo_id`) VALUES (?, ?)";
    if($stmt = $connect->prepare($sql)){
        $stmt->bind_param("ii", $param_game_id,$param_photo_id);
       
            $param_game_id=$id;
            $param_photo_id=$photos;
        
            if($stmt->execute()){
                echo "OK";
            }
            else{
                echo "Coś poszło nie tak";
                echo $connect->error;
            }
        // Close statement
        $stmt->close();
    }
    else{
        echo "Coś poszło nie tak";
        echo $connect->error;
    }


$connect->close();
    header('location: ../admin.php');
    

?>