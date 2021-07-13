<?php
if(!isset($_SESSION['user_level'])||$_SESSION['user_level']===0){
    header('Location: index.php');
   exit();
   }
   else if(isset($_SESSION['user_level'])&&$_SESSION['user_level']===2){
    header('Location: admin.php');
    exit();
   }
echo "<h4>Aktualizacja użytkownika</h4>";
require('./scripts/connect.php');
        $id=$_GET['user_id'];
        $sql="SELECT user_id,username,email,user_level,restriction from users where user_id=?";
        if($stmt = $connect->prepare($sql)){
            $stmt->bind_param("i", $param_user_id);
    
            $param_user_id = $id;
            
           if($stmt->execute()){
            $stmt->store_result();
            $stmt->bind_result($id,$username,$email,$user_level,$restriction);
            while($stmt->fetch()){
                echo <<<FORMUPDATE
        <form action="./scripts/update_user.php" method="POST">
        <input type="hidden" name="user_id" value="$id"><br><br>
        <input type="text" name="username" value="$username"><br><br>
        <input type="text" name="email" value="$email"><br><br>
        <input type="number" name="user_level" value="$user_level"><br><br>
        <input type="number" name="restriction" value="$restriction"><br><br>
        <input type="submit" value="Modyfikuj użytkownika"><br><br>
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