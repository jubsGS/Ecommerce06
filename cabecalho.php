<?php
    session_start();
    include("util.php");

    if(isset($_SESSION['sessaoConectado'])){
        $sessaoConectado=$_SESSION['sessaoConectado'];
        $login=$_SESSION['sessaoLogin'];
    }else{
        $sessaoConectado=false;
    }
?>