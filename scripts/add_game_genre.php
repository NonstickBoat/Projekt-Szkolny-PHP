<?php require_once('connect.php');
foreach($_POST as $key =>$value){
    // echo "$key => $value<br>";
    $$key=$value;
}
$sql = "INSERT INTO `games_genre` (`game_id`, `genre_id`) VALUES (?, ?)";
    if($stmt = $connect->prepare($sql)){
        $stmt->bind_param("ii", $param_game_id,$param_genre_id);
        foreach ($genres as $genre) {
            $param_game_id=$id;
            $param_genre_id=$genre;
        
            if($stmt->execute()){
                echo "OK";
            }
            else{
                echo "Coś poszło nie tak";
            }
        }
        // Close statement
        $stmt->close();
    }
    else{
        echo "Coś poszło nie tak";
    }


$connect->close();
     header('location: ../admin.php');
    

?>