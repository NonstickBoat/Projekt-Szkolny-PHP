<?php 
if(!isset($_SESSION['user_level'])||$_SESSION['user_level']===0){
   header('Location: index.php');
  exit();
  }
  else if(isset($_SESSION['user_level'])&&$_SESSION['user_level']===2){
   header('Location: admin.php');
   exit();
  }
require_once 'connect.php';
   if (!$connect->connect_errno) {
    $sql = "SELECT user_id,username,user_level,restriction from users";  // Nie potrzeba prepared, brak danych wprowadzanych 
    $result = $connect->query($sql);
   
echo "Uprawnienia: 0-brak, 1-admin, 2 moderator";
echo<<<TABLE
<table>
<tr>
<th>Id</th>
<th>Nazwa</th>
<th>Uprawnienia</th>
<th>Restrykcje?</th>
</tr>
TABLE;

while($user = $result->fetch_assoc()){
echo<<<GAME
<tr>
<td>$user[user_id] </td>
<td>$user[username] </td>
<td>$user[user_level]</td>
<td>$user[restriction]</td>
<td><a href="./admin.php?state=moderate_user&user_id=$user[user_id]">Aktualizuj podstawowe informacje</a></td>
</tr>
GAME;
}
$connect ->close();
   }
?>