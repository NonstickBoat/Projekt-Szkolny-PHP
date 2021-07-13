<?php session_start();?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Start</title>
    <link rel="stylesheet" href="style_menu.css">
</head>
<body>
    <div class="topnav">
        <a class="active" href="#">Start</a>
        <a href="#about">O projekcie</a>
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
            <h1>Witaj na mojej stronie!</h1>
            
        </section>
        <section class="about">
            <h2>O projekcie</h2>
            <p>Projekt powstał aby pasjonaci gier z polski miały łatwy sposób na wyszukiwanie ocen gier komputerowych oraz dyskusję z innymi graczami na temat ulubionych gier</p>
        </section>
        <section class="catalog_home">
            <h2>Katalog</h2>
            <a href="katalog.php">Przejdź do katalogu!</a>
        </section>
    </main>
</body>
</html>