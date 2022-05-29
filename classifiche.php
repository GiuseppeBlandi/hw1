<?php 
    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>

<?php 
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid = mysqli_real_escape_string($conn, $userid);
        $query = "SELECT * FROM users WHERE id = $userid";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);   
    ?>
  <head>
    <meta charset="utf-8">
    <title>TuttoF1</title>
    <link href="https://fonts.googleapis.com/css?family=Pangolin:400,700|Proxima+Nova" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="styles/classifiche.css"/>
    <link rel="icon" type="image/png" href="images/logo1.png">
    <script src="scripts/classifiche.js" defer="true"></script>    
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <section id="form" >
      <form class="invia_dati" >
        <select name ='tipo' id='tipo'>
          <option value='piloti'>Classifica Piloti</option>
          <option value='costruttori'>Classifica costruttori</option>
      </select>
      <br>
      <br>
      <span class="insert">Inserisci anno (dal 1950 al corrente)</span>
    <input type="text" id="pilota" placeholder="Inserisci anno">
    <input type="submit" id="search" value="Cerca">
    </form>

  </section>
  <section id="piloti" >
    </section>

    <footer>
        <div>
            Creato da Giuseppe Blandi <br>
            1000001403
        </div>
    </footer>
  </body>
</html>
