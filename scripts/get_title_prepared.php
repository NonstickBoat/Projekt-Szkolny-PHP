<?php
require ('connect.php');
$id=$_GET['id'];
if (!$connect->connect_errno) {
    $sql = "SELECT game_name FROM `games` WHERE game_id= ? ";
    if($stmt = $connect->prepare($sql)){
            $stmt->bind_param("i", $param_game_id);
    
            $param_game_id = $id;
            
           if($stmt->execute()){
            $stmt->store_result();
            $stmt->bind_result($title);
            while($stmt->fetch()){
                if(empty($title)){
                    echo "<h1>Brak tytułu</h1>";
                }
                else{
                    echo "<h1>",$title,"</h1>";
                }
            }
           }
           else{
               echo "Coś poszło nie tak";
           }

            // Close statement
            $stmt->close();
        }
    $connect->close();
    }
    else{
        echo $connect->connect_error;
    }
?>