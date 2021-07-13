<?php
session_start();
require_once('connect.php');
foreach($_POST as $key =>$value){
    // echo "$key => $value<br>";   
    $$key=$value;
}
$user_id=$_SESSION['id'];
$sql = "UPDATE `reviews` SET `score` = ?, `review_text`=? WHERE `reviews`.`review_id` = ?";
if($stmt = $connect->prepare($sql)){
    $stmt->bind_param("isi", $param_score,$param_review_text,$param_review_id);
    
        $param_score=$score;
        $param_review_text=$review_text;
        $param_review_id=$review_id;
       

    
        if($stmt->execute()){
            if($stmt->affected_rows>0){
            header("Location: ../game_page.php?id=$game_id&update=1");
            }
            else{
                header("Location: ../game_page.php?id=$game_id&update=0");
               
            }
            
        }
        else{
            echo $connect->error;
            echo "Coś poszło nie tak";
            header("Location: ../game_page.php?id=$game_id&update=0");
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