<?php 

    session_start();

    if(isset($_SESSION['userid'])){
        session_destroy();
        header('location: http://localhost/img/index.php');
    }


?>