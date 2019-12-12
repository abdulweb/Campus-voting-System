<?php

session_start();
    if(isset($_SESSION['isadmin'])){
        unset($_SESSION['isadmin']);
    }elseif(isset($_SESSION['isstaff'])){
        unset($_SESSION['isstaff']);
    }elseif(isset($_SESSION['isvoter'])){
        unset($_SESSION['isvoter']);
    }

header('Location:/evoting/index.php');
