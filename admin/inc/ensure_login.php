<?php
session_start();
if(!isset($_SESSION['isadmin']) && !isset($_SESSION['isstaff'])&& !isset($_SESSION['isvoter'])){
    header('Location:/evoting/index.php');
}
?>