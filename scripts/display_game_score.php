<?php
require("connect.php");
$game_id=$_GET['id'];
$sql = "SELECT round(avg(`score`),2) FROM `reviews` WHERE `game_id`=?"; 
if($stmt = $connect->prepare($sql)){
    $stmt->bind_param("i", $param_game_id);

    $param_game_id = $game_id;
    
   if($stmt->execute()){
    $stmt->store_result();
        $stmt->bind_result($score);
            while($stmt->fetch()){
                if(!empty($score)){
                    echo "<h1>Ocena: ",$score,"</h1>";
                }
                else{
                    echo "<h1>Brak ocen</h1>";
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
?>