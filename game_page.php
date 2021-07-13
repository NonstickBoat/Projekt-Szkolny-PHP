<?php 
session_start();
if(!isset($_GET['id'])||empty($_GET['id'])){
    header('Location: katalog.php');
    exit();
}?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Gra</title>
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
            <?php
            require_once('./scripts/get_title_prepared.php');
            ?>
        </section>
        <section class="game_main">
            <section class="game_cover">
            <?php
            require_once('./scripts/get_cover_photo_prepared.php');
            ?>
            </section>
            <section class="game_information">
                <?php require_once "./scripts/get_game_information.php"?>
            </section>
        </section>
        <section class="game_community">
            <section class="ratings">
                <?php require_once('./scripts/display_game_score.php');?>
            </section>
                <section class="comments">
                    <h3>Recenzje:</h3>
                    <?php 
                    if(isset($_SESSION['logged'])&&$_SESSION['logged']==true&&$_SESSION['restriction']==0){
                        require('./scripts/connect.php');
                        $game_id=$_GET['id'];
                        $user_id=$_SESSION['id'];
                        $sql = "SELECT `review_id`,`review_text` FROM reviews WHERE `user_id`='$user_id' and `game_id`='$game_id'";
                        $result = $connect->query($sql);
                        echo $connect->error;
                        if($result->num_rows!=0){
                            $rev=$result->fetch_assoc();
                            $review_text=$rev['review_text'];
                        ?>
                        <form action="./scripts/update_comment.php" method="post">
                    <label for="score">Ocena:</label>
                        <select id="score" name="score">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select><br>
                        <input type="hidden" name="game_id" value="<?php echo $_GET['id']?>">
                        <input type="hidden" name="review_id" value="<?php echo $rev['review_id'];?>">
                        <textarea name="review_text"placeholder="Napisz recenzję" ><?php echo $review_text?></textarea>
                        <input type="submit" value="Zmodyfikuj recenzję">
                    </form>
                        <?php } else{?>
                    <form action="./scripts/comment_send.php" method="post">
                    <label for="score">Ocena:</label>
                        <select id="score" name="score">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select><br>
                        <input type="hidden" name="game_id" value="<?php echo $_GET['id'];?>">
                        <textarea name="review_text" placeholder="Napisz komentarz"></textarea>
                        <input type="submit" value="Dodaj recenzję">
                    </form>
                    <?php }
                    }
                    else if(isset($_SESSION['restriction'])&&$_SESSION['restriction']>0){
                        echo "<p>Zostałeś wyciszony przez moderację serwisu!</p>";
                    } 
                    else{
                        echo "<p>Zaloguj się aby oceniać!</p>";
                    }
                    require_once('./scripts/get_reviews.php')?>
                    
                </section>
        </section>
    </main>
</body>
</html>