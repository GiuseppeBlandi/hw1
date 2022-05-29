<?php
    require_once 'auth.php';

    if (checkAuth()) {
        header("Location: home.php");
        exit;
    }   

    if (!empty($_POST["name"]) && !empty($_POST["surname"]) && !empty($_POST["username"]) && !empty($_POST["email"]) && 
        !empty($_POST["password"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"]))
    {
        $error = array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $error[] = "Username non valido";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }

        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        } 

        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            $error[] = "Le password non coincidono";
        }
        
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }

        
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users(username, password, name, surname, email) VALUES('$username', '$password', '$name', '$surname', '$email')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION["_tuttoF1_username"] = $_POST["username"];
                $_SESSION["_tuttoF1_user_id"] = mysqli_insert_id($conn);
                mysqli_close($conn);
                header("Location: home.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
    }
    else if (isset($_POST["username"])) {
        $error[] = "Riempi tutti i campi";
    }

?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Iscriviti</title>
    <link href="https://fonts.googleapis.com/css?family=Pangolin:400,700|Proxima+Nova" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="styles/login.css"/>
    <link rel="icon" type="image/png" href="images/logo1.png">
    <script src="scripts/signup.js" defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>

  <body>

    <section>
      <div>
        <h1>Iscriviti</h1>
        <h2>Inserisci le tue credenziali</h2>
        <?php
                if (isset($error)) {
                  for($i=0; $i<count($error); $i=$i+1)
                    echo "<span class='error'>$error[$i]</span>";
                }
                
            ?>
        
      </div>
      <form name='login' method='post'>
        <div class="name">
            <div><label for='name'>Nome</label></div>
            <div><input type='text' placeholder="Inserire lettere" name='name' <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> ></div>
            <span>Nome non valido</span> 
        </div>
        <div class="surname">
        <div><label for='surname'>Cognome</label></div>
            <div><input type='text' placeholder="Inserire lettere" name='surname' <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?>>  </div>
            <span>Cognome non valido</span>
          </div>
        <div class="username">
            <div><label for='username'>Nome utente</label></div>
            <div><input type='text' placeholder="Max 15 caratteri" name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>></div>
            <span>Nome utente non disponibile</span>
        </div>
        <div class="email">
        <div><label for='email'>Email</label></div>
            <div><input type='text' placeholder="example@email.com" name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>></div>
            <span>Indirizzo email non valido</span>
         </div>
        <div class="password">
            <div><label for='password'>Password</label></div>
            <div><input type='password' placeholder="Min 8 caratteri" name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>></div>
            <span>Inserisci almeno 8 caratteri</span>
        </div>
        <div class="confirm_password">
            <div><label for='confirm_password'>Ripeti la Password</label><div>
            <div><input type='password' placeholder="Min 8 caratteri" name='confirm_password'<?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>></div>
            <span>Le password non coincidono</span>
        </div>
        <div class="allow">
            <div><input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>></div>
            <div><label for='allow'>Acconsento al furto dei dati personali</label></div>
        </div>
        <div>
            <input type='submit' value="Iscriviti">
        </div>
    </form>
    <div class="signup">Hai già un account? <a href="login.php">Login</a>
</section>

  </body>
</html>