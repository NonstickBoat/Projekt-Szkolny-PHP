<?php 
require_once('connect.php');
$id=$_GET['game_id'];
if (!$connect->connect_errno) {
$sql = "SELECT path,gp.photo_id FROM `games_photo` gp inner join photo p on gp.photo_id=p.photo_id WHERE game_id='$id'";
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
                echo "Ta gra ma dodane zdjęcia:<br>";
                while($row=$result->fetch_assoc()){
                    echo $row['path']," ";
                    array_push($taken,$row['photo_id']);
                }
            }
            $taken=implode(',',$taken);
            if(empty($taken)){
                $sql2 ="SELECT path,photo_id FROM `photo`";
            }else{
            $sql2 ="SELECT path,photo_id FROM `photo` where photo_id not in ($taken)";
            }
             $result=$connect->query($sql2);   
             if (!$result = $connect->query($sql2)) {
                echo "Błędne zapytanie do bazy danych. <br> Error number: ",$connect->errno,"<br> Error: ", $connect->error;
            }
            else{
                echo "<form action=\"./scripts/add_game_photo.php\" method=\"POST\"><select name=\"photos\">";
                while($row=$result->fetch_assoc()){
                    echo <<<OPTION
                    <option value=$row[photo_id]>$row[path]</option>
                    OPTION;
                  
                }
                echo "</select>";
                echo "<input type=\"hidden\" name=\"id\" value=\"$id\"><br><br>";
                echo "<input type=\"submit\" value=\"Dodaj zdjęcie\"><br><br></form>";
                    
            }
        }
    
    $connect->close();
}
?>