<?php
session_start();
require_once('connect.php');
foreach($_POST as $key =>$value){
    // echo "$key => $value<br>";   
    $$key=$value;
}
$sql = "INSERT INTO `reviews` (`review_id`, `game_id`, `user_id`, `score`, `review_text`) VALUES (NULL, ?, ?, ?, ?)";   //przydałoby się sprawdzić ten text K
if($stmt = $connect->prepare($sql)){
    $stmt->bind_param("iiis", $param_game_id,$param_user_id,$param_score,$param_review_text);
    
        $param_game_id=$game_id;
        $param_user_id=$_SESSION['id'];
        $param_score=$score;
        $param_review_text=$review_text;

    
        if($stmt->execute()){
            echo "OK";
            header("Location: ../game_page.php?id=$game_id");
        }
        else{
            echo $connect->error;
            echo "Coś poszło nie tak";
            header("Location: ../game_page.php?id=$game_id");
        }
    
    // Close statement
    $stmt->close();
}
else{
    echo $connect->error;
    echo "Coś poszło nie tak";
}
$connect->close();
?>