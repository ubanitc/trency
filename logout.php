<?php 

    session_start();

    if(isset($_SESSION['userid'])){
        session_destroy();
        header('location:http://trencynews.herokuapp.com/');
    }


?>
