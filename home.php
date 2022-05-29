<?php 
    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>
<?php 
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid = mysqli_real_escape_string($conn, $userid);
        $query = "SELECT * FROM users WHERE id = $userid";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);   
    ?>


  <head>
    <meta charset="utf-8">
    <title>Tuttof1</title>
    <link href="https://fonts.googleapis.com/css?family=Pangolin:400,700|Proxima+Nova" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/home.css"/>
    <link rel="icon" type="image/png" href="images/logo1.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src='./scripts/home.js' defer></script>
</head>
<html>
    <body>
       <nav>  
           
            <a href="home.php" class="home">
                <img src="images/home.png" class="hidden">
                <span class="tutto">Tutto</span> <span class="f1">F1</span>
            </a> 
            
            <a href="create_post.php" class="nav_content">
                <span>Crea post</span>
                <div class="nuovo_post"> </div>
            </a>
            
            <a href="classifiche.php" class="nav_content">
                <span>Classifiche</span>
                <div class="classifiche_image"></div>
            </a>
           
            <a href="profile.php" class="nav_content">
               <div class="profile_image"></div>
           <?php 
                echo "<span>$userinfo[name]</span>";
                ?>
            </a>

            <a href="logout.php" class="logout" >
                <div class="logout_image"></div>
                <span class="log">Log</span> <span class="out">out</span>
            </a>    
        
        </nav> 

        <section class='races'>
        <div class='last_race'></div> 
            <div class='next_race'></div>    
        </section>
        
        <main>
            <section id="feed">
            <template id="post_template">
                <article class="post">
                    <div class="userinfo">
                        <div class="names">
                            <a>
                                <div class="name"></div>
                                <div class="username"></div>
                            </a>
                        </div>
                        <div class="time"></div>
                    </div>
                    <div class="content"></div>
                    <div class="actions">
                        <div class="like"><span></span></div>
                        <div class="comment"><span></span></div> 
                    </div>
                    <div class="comments">
                            <div class="past_messages"></div>
                            <div class="comment_form">
                                <form autocomplete="off">
                                    <input type="text" name="comment" maxlength="254" placeholder="Scrivi un commento..." required="required">
                                    <input type="submit">
                                    <input type="hidden" name="postid">
                                </form>
                        </div>
                    </div>
                </article>
            </section>
            </template>
        </main>

    <footer>
        <div>
            Creato da Giuseppe Blandi <br>
            1000001403
        </div>
    </footer>
    </body>
</html>

<?php mysqli_close($conn); ?>
