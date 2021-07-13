<?php session_start();                      //TO DO: NOWY CSS 
if(!isset($_GET["plat_id"])|empty($_GET["plat_id"])){
    header('Location: katalog.php');
    exit();
}
else{
    $id=$_GET["plat_id"];
}?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Platforma</title>
    <link rel="stylesheet" href="style_menu.css">
</head>
<body>
    <div class="topnav">
        <a href="index.php">Start</a>
        <a href="index.php#about">O projekcie</a>
        <a href="katalog.php">Katalog</a>
        <?php
        if(isset($_SESSION['logged'])&&$_SESSION['logged']==true){
            if(isset ($_SESSION['user_level'])&&$_SESSION['user_level']>0){
            echo "<a href=\"./admin.php\">Panel administracyjny</a>";
            }
            echo "<div class=\"user\"><a href=\"./password_reset_form.php\">Zresetuj hasło!</a>";
           echo "<a href=\"./scripts/logout.php\">Wyloguj się!</a><span>Witaj: ",$_SESSION['username'],"</span></div>";
           
        }
        else{
            echo "<a href=\"login_form.php\">Zaloguj się!</a>";
        }
        
        ?>
    </div>
    <main>
        <section class="title">
            <h1>Gry:</h1>
            
        </section>
        <section class="catalog_main">
            <?php 
            require "./scripts/connect.php";
            $sql = "select game_name, g.game_id as 'id' from games g inner join games_platforms gp on g.game_id=gp.game_id where platform_id=?";
            if($stmt = $connect->prepare($sql)){
                $stmt->bind_param("i", $param_game_id);
        
                $param_game_id = $id;
                
               if($stmt->execute()){
                $stmt->store_result();
                $stmt->bind_result($name,$id);
                while($stmt->fetch()){
                    echo <<<PLATFORM
                    <a href="game_page.php?id=$id">$name</a>
PLATFORM;
                }
               }
               else{
                   echo "Coś poszło nie tak";
               }
    
                // Close statement
                $stmt->close();
            }
            $connect->close();
            ?>
            
        </section>
    </main>
</body>
</html>