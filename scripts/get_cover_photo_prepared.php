<?php
require('connect.php');
$id=$_GET['id'];
    if (!$connect->connect_errno) {
        $sql = "SELECT path, alt from photo p inner join games_photo gp on p.photo_id=gp.photo_id inner join games g on g.game_id=gp.game_id where gp.game_id= ? ";
        if($stmt = $connect->prepare($sql)){
                $stmt->bind_param("i", $param_game_id);
        
                $param_game_id = $id;
                
               if($stmt->execute()){
                $stmt->store_result();
                $stmt->bind_result($src,$alt);
                while($stmt->fetch()){
                    if(empty($src)){
                        echo "Brak?";
                        }
                    else{
                        if(strpos($src,"ttp:")!=false||strpos($src,"ttps:")!=false){
                            echo<<<COVER
                        
                            <img src="$src" alt="$alt">
                        COVER;
                    }
                    else{
                        echo<<<COVER
                        <img src="./pictures/$src" alt="$alt">
        COVER;
                    }
                        }
                }
               }
               else{
                   echo "Coś poszło nie tak";
               }
    
                // Close statement
                $stmt->close();
            }else{
                echo $connect->error;
            }
    }