<?php
require('connect.php');
$id=$_GET['id'];
    if (!$connect->connect_errno) {
        $sql = "SELECT * FROM `games` WHERE game_id='$id'";
        $result = $connect->query($sql);
        if (!$result = $connect->query($sql)) {
            echo "Błędne zapytanie do bazy danych. <br> Error number: ",$connect->errno,"<br> Error: ", $connect->error;
        }
        else{
            $game=$result->fetch_assoc();
            if(empty($game)){
                echo "Nie ma takiej gry";
                }
            else{
                echo<<<TABLE
<table>
<tr>
<th>Nazwa</th>
<td>$game[game_name]</td>
</tr>
<tr>
<th>Data wydania</th>
<td>$game[release_date]</td>
</tr>
<tr>
TABLE;
    $sql2 = "select genre_name from genre g inner join games_genre gg ON g.genre_id=gg.genre_id where gg.game_id='$id'";    
            $result2=$connect->query($sql2);
            echo "<th>Gatunki</th><td>";
            if($result2->num_rows===0){
                echo "-";
            }
            while( $genre=$result2->fetch_assoc()){
                echo<<<GENRE
                $genre[genre_name]  
GENRE;
            }
           echo "</td></tr>";
           $sql3 = "SELECT platform_name from platforms p inner join games_platforms gp on p.platform_id=gp.platform_id WHERE game_id='$id'";
           $result3=$connect->query($sql3);
           echo "<tr><th>Platformy</th><td>";
           while( $platforms=$result3->fetch_assoc()){
                echo<<<PLATFORMS
                $platforms[platform_name]
PLATFORMS;
           }
           echo "</td></tr><tr>
           <th>Opis</th>
           <td>$game[description]</td>
           </tr></table>";
                }
            }
            
            $connect->close();
        }
        else {
            echo "Błędne połączenie z bazą danych. <br> Error number: ",$connect->connect_errno;
        }
?>