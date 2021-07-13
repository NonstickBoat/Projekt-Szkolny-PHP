<?php 
require_once('connect.php');
$id=$_GET['game_id'];
if (!$connect->connect_errno) {
$sql = "SELECT platform_name,gp.platform_id FROM `games_platforms` gp inner join platforms p on gp.platform_id=p.platform_id WHERE game_id='$id'";
        $result = $connect->query($sql);
        $taken=array();
        if (!$result = $connect->query($sql)) {
            echo "Błędne zapytanie do bazy danych. <br> Error number: ",$connect->errno,"<br> Error: ", $connect->error;
        }
        else{
            if($result->num_rows===0){
                echo "Brak dodanych platform: dodaj je teraz!";
            }
            else{
                echo "Ta gra ma dodane platformy:<br>";
                while($row=$result->fetch_assoc()){
                    echo $row['platform_name']," ";
                    array_push($taken,$row['platform_id']);
                }
            }
            $taken=implode(',',$taken);
            if(empty($taken)){
                $sql2 ="SELECT platform_name,platform_id FROM `platforms`";
            }else{
            $sql2 ="SELECT platform_name,platform_id FROM `platforms` where platform_id not in ($taken)";
            }
             $result=$connect->query($sql2);   
             if (!$result = $connect->query($sql2)) {
                echo "Błędne zapytanie do bazy danych. <br> Error number: ",$connect->errno,"<br> Error: ", $connect->error;
            }
            else{
                echo "<form action=\"./scripts/add_game_platforms.php\" method=\"POST\"><select name=\"platforms[]\" multiple>";
                while($row=$result->fetch_assoc()){
                    echo <<<OPTION
                    <option value=$row[platform_id]>$row[platform_name]</option>
                    OPTION;
                  
                }
                echo "</select>";
                echo "<input type=\"hidden\" name=\"id\" value=\"$id\"><br><br>";
                echo "<input type=\"submit\" value=\"Dodaj platformę\"><br><br></form>";
                    
            }
        }
    
    $connect->close();
}
?>