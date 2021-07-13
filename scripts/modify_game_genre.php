<?php 
require_once('connect.php');
$id=$_GET['game_id'];
if (!$connect->connect_errno) {
$sql = "SELECT genre_name,gg.genre_id FROM `games_genre` gg inner join genre p on gg.genre_id=p.genre_id WHERE game_id='$id'";
        $result = $connect->query($sql);
        $taken=array();
        if (!$result = $connect->query($sql)) {
            echo "Błędne zapytanie do bazy danych. <br> Error number: ",$connect->errno,"<br> Error: ", $connect->error;
        }
        else{
            if($result->num_rows===0){
                echo "Brak dodanych gatunków: dodaj je teraz!";
            }
            else{
                echo "Ta gra ma dodane gatunki:<br>";
                while($row=$result->fetch_assoc()){
                    echo $row['genre_name']," ";
                    array_push($taken,$row['genre_id']);
                }
            }
            $taken=implode(',',$taken);
            if(empty($taken)){
                $sql2 ="SELECT genre_name,genre_id FROM `genre`";
            }else{
            $sql2 ="SELECT genre_name,genre_id FROM `genre` where genre_id not in ($taken)";
            }
             $result=$connect->query($sql2);   
             if (!$result = $connect->query($sql2)) {
                echo "Błędne zapytanie do bazy danych. <br> Error number: ",$connect->errno,"<br> Error: ", $connect->error;
            }
            else{
                echo "<form action=\"./scripts/add_game_genre.php\" method=\"POST\"><select name=\"genres[]\" multiple>";
                while($row=$result->fetch_assoc()){
                    echo <<<OPTION
                    <option value=$row[genre_id]>$row[genre_name]</option>
                    OPTION;
                  
                }
                echo "</select>";
                echo "<input type=\"hidden\" name=\"id\" value=\"$id\"><br><br>";
                echo "<input type=\"submit\" value=\"Dodaj gatunki\"><br><br></form>";
                    
            }
        }
    
    $connect->close();
}
?>