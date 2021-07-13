<?php session_start();
#Jezeli uzytkownik nie jest adminem przekieruj na stronę głowna
 if(!isset($_SESSION['user_level'])||$_SESSION['user_level']===0){
   header('Location: index.php');
  exit();
  }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel administracyjny</title>
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
            echo "<a href=\"./admin.php\" class=\"active\">Panel administracyjny</a>";
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
      <section class="selection"><?php
      if($_SESSION['user_level']===1){
      echo <<<LINKS
        <a href="admin.php?state=moderate_user">Moderacja użytkownika</a>
        LINKS;
      }
      if($_SESSION['user_level']>=1){
        echo <<<MLINKS
          <a href="admin.php?state=add_game">Dodaj grę</a>
          <a href="admin.php?state=add_platform">Dodaj nową platformę</a>
          <a href="admin.php?state=add_genre">Dodaj nowy gatunek</a>
          <a href="admin.php?state=modify_game">Modyfikuj grę</a>
          <a href="admin.php?state=add_image">Dodaj zdjęcie</a><br>
        MLINKS;
      }

        ?>
      </section>
      <?php 
        if(isset($_GET['state'])){
            switch ($_GET['state']) {
                case "add_game":
                    echo <<<ADDGAME
                    <form action="./scripts/add_game_prepared.php" method="POST">
                    <input type="text" name="name" placeholder="Nazwa gry"><br><br>
                    <input type="text" name="description" placeholder="Opis"><br><br>
                    <input type="date" name="release_date"><br><br>
                    <input type="submit" value="Dodaj grę"><br><br>
                </form>
ADDGAME;
                  break;
                case "add_platform":
                    echo <<<ADDPLATFORM
                    <form action="./scripts/add_platform_prepared.php" method="POST">
                    <input type="text" name="name" placeholder="Nazwa platformy"><br><br>
                    <input type="text" name="description" placeholder="Opis"><br><br>
                    <input type="submit" value="Dodaj nową platformę"><br><br>
                </form>
ADDPLATFORM;
                  break;
                  case "add_genre":
                    echo <<<ADDGENRE
                    <form action="./scripts/add_genre_prepared.php" method="POST">
                    <input type="text" name="name" placeholder="Nazwa gatunku"><br><br>
                    <input type="submit" value="Dodaj nowy gatunek"><br><br>
                </form>
ADDGENRE;
                    break;
                case "add_image":
                  require_once('./image_form.php');
                  break;
                case "modify_game":
                    if(!isset($_GET['game_id'])){
                        require_once('./scripts/admin_game_list.php');
                    }
                    else{
                        require_once('./scripts/admin_game_form.php');
                    }
                  break;
                case "modify_game_platform":
                  if(!isset($_GET['game_id'])){
                    require_once('./scripts/admin_game_list.php');
                  }
                    else{
                      require_once('./scripts/modify_game_platforms.php');
                    }
                    break;
                case "modify_game_genre":
                  if(!isset($_GET['game_id'])){
                    require_once('./scripts/admin_game_list.php');
                  }
                    else{
                      require_once('./scripts/modify_game_genre.php');
                    }
                    break;
                case "moderate_user":
                  if(!isset($_GET['user_id'])){
                  require_once('./scripts/admin_user_list.php');
                }
                else{
                  require_once('./scripts/admin_user_form.php');
                }
                break;
                case "modify_game_photo":
                  if(!isset($_GET['game_id'])){
                    require_once('./scripts/admin_game_list.php');
                  }
                  else{
                    require_once('./scripts/modify_game_photo.php');
                  }
                default:
                  
              }
        }
      ?>
    </main>
</body>
</html>