<?php
if(!isset($_SESSION['user_level'])||$_SESSION['user_level']===0){
    header('Location: index.php');
   exit();
   }
echo "<h4>Aktualizacja gry</h4>";
require('./scripts/connect.php');
        $id=$_GET['game_id'];
        $sql="SELECT * from games where game_id=?";
        if($stmt = $connect->prepare($sql)){
            $stmt->bind_param("i", $param_game_id);
    
            $param_game_id = $id;
            
           if($stmt->execute()){
            $stmt->store_result();
            $stmt->bind_result($id,$name,$description,$release_date);
            while($stmt->fetch()){
                echo <<<FORMUPDATE
        <form action="./scripts/update_game.php" method="POST">
        <input type="hidden" name="id" value="$id"><br><br>
        <input type="text" name="name" value="$name"><br><br>
        <input type="text" name="description" value="$description"><br><br>
        <input type="date" name="release_date" value="$release_date"><br><br>
        <input type="submit" value="Modyfikuj grę"><br><br>
        </form>
FORMUPDATE;
            }
           }
           else{
               echo "Coś poszło nie tak";
           }

            // Close statement
            $stmt->close();
        }
        
?>