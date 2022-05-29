<?php
    require_once 'auth.php';

    if (checkAuth()) {
        header("Location: home.php");
        exit;
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) )
    {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $searchField = filter_var($username, FILTER_VALIDATE_EMAIL) ? "email" : "username";
        $query = "SELECT id, username, password FROM users WHERE $searchField = '$username'";
        
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['password'])) {

                $_SESSION["_tuttoF1_username"] = $entry['username'];
                $_SESSION["_tuttoF1_user_id"] = $entry['id'];
                echo($_SESSION["_tuttoF1_user_id"]);
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }
        $error = "Username e/o password errati.";
    }
    else if (isset($_POST["username"]) || isset($_POST["password"])) {
        
        $error = "Inserisci username e password.";
    }

?>


<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Pangolin:400,700|Proxima+Nova" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="styles/login.css"/>
    <link rel="icon" type="image/png" href="images/logo1.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>

  <body>

    <section>
      <div>
        <h1>Accedi</h1>
        <h2>Inserisci le tue credenziali</h2>
        <?php
                if (isset($error)) {
                    echo "<span class='error'>$error</span>";
                }
                
            ?>
      </div>
      <form name='login' method='post'>
        <div class="username">
        <div><label for='username'>Nome utente o email</label></div>
            <div><input type='text'  placeholder="Inserire lettere e numeri" name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>></div>
        </div>
        <div class="password">
        <div><label for='password'>Password</label></div>
            <div><input type='password' placeholder="Min. 8 caratteri" name='password' ></div>
        </div>
        <div class="remember">
            <div><input type='checkbox' name='remember' value="1" ></div>
            <div><label for='remember'>Ricorda l'accesso</label></div>
        </div>
        <div>
            <input type='submit' value="Accedi">
        </div>
    </form>
    <div class="signup">Non hai un account? <a href="signup.php">Iscriviti</a>
</section>

  </body>
</html>