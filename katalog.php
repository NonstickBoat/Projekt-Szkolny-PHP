<?php session_start();?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Katalog</title>
    <link rel="stylesheet" href="style_menu.css">
</head>
<body>
    <div class="topnav">
        <a href="index.php">Start</a>
        <a href="index.php#about">O projekcie</a>
        <a class="active" href="#">Katalog</a>
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
            <h1>Witaj na stronie głównej katalogu!</h1>
            
        </section>
        <section class="catalog_main">
            <h2>Platformy</h2> 
            <?php 
            require "./scripts/connect.php";
            $sql = "SELECT `platform_id`,`platform_name` FROM `platforms`"; //Brak danych wprowadzanych przez użytkownika nie trzeba prepared
            $result=$connect->query($sql);
            if($connect->error==0){
                while($platform=$result->fetch_assoc()){
                    echo <<<PLATFORM
                    <a href="platform.php?plat_id=$platform[platform_id]">$platform[platform_name]</a>
PLATFORM;
                }
            }
            else
            {
                echo "Coś poszło nie tak", $connect->error;
            }
            $connect->close();
            ?>
        </section>
    </main>
</body>
</html>