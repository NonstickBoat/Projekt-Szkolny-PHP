<?php 
if(!isset($_SESSION['user_level'])||$_SESSION['user_level']===0){
   header('Location: index.php');
  exit();
  }
require_once 'connect.php';
   if (!$connect->connect_errno) {
    $sql = "SELECT * from games";  // Nie potrzeba prepared, brak danych wprowadzanych 
    $result = $connect->query($sql);
   
    
echo<<<TABLE
<table>
<tr>
<th>Id</th>
<th>Nazwa</th>
<th>Opis</th>
 </tr>
TABLE;

while($game = $result->fetch_assoc()){
echo<<<GAME
<tr>
<td>$game[game_id] </td>
<td>$game[game_name] </td>
<td>$game[description]</td>
<td><a href="./admin.php?state=modify_game&game_id=$game[game_id]">Aktualizuj podstawowe informacje</a></td>
<td><a href="./admin.php?state=modify_game_platform&game_id=$game[game_id]">Aktualizuj platformy</a></td>
<td><a href="./admin.php?state=modify_game_genre&game_id=$game[game_id]">Aktualizuj gatunki</a></td>
<td><a href="./admin.php?state=modify_game_photo&game_id=$game[game_id]">Aktualizuj zdjęcie</a></td>
</tr>
GAME;
}
$connect ->close();
   }
?>