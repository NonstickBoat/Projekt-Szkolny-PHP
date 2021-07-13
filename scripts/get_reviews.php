<?php
require("connect.php");
$game_id=$_GET['id'];
$sql = "SELECT `username`,`score`,`review_text`,`review_date` FROM `reviews`r inner join users u on r.user_id=u.user_id WHERE `game_id`=?"; 

if($stmt = $connect->prepare($sql)){
    $stmt->bind_param("i", $param_game_id);

    $param_game_id = $game_id;
    
   if($stmt->execute()){
    $stmt->store_result();
    $stmt->bind_result($username,$score,$review_text,$review_date);
    while($stmt->fetch()){
            echo "<div class=\"review\">";
                echo <<<REVIEWBODY
                    <p>Użytkownik: $username</p>
                    <p>Ocena: $score</p>
                    <p>Data wystawienia: $review_date</p>
                    <p>Tekst: </p>
                    <p>$review_text</p>
                REVIEWBODY;
            echo "</div>";
        
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