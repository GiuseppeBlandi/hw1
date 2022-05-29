
<?php

    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: login.php");
        exit;
    }


        GLOBAL $dbconfig, $userid;

            $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
            
            $userid = mysqli_real_escape_string($conn, $userid);
            $text = mysqli_real_escape_string($conn, $_POST['text']);

            $query = "INSERT INTO posts(user, content) VALUES('.$userid.', JSON_OBJECT('text', '$text'))";
            
            if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
                
                echo json_encode(array('ok' => true));
                exit;
                
            }    

            header("Location: home.php");        
        echo json_encode(array('ok' => false));
    
?>
