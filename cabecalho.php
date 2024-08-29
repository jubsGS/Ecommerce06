<html>
    <head>
        <title>Ecommerce CTI</title>
    </head>
    <body>
        <img src="imagens/escola.png" width="100%">
        <br>
    </body>
</html>

<?php
    session_start();
    include("util.php");

    if(isset($_SESSION['sessaoConectado'])){
        $sessaoConectado=$_SESSION['sessaoConectado'];
        $login=$_SESSION['sessaoLogin'];
    }else{
        $sessaoConectado=false;
    }

    if($sessaoConectado){
        $idSessao=session_id();
        echo "<a href='logout.php'>Sair</a>
            <br>Ola, $login
            <br>
            <a href='index.php'>Produtos</a>
            <a href='usuarios.php'>Usuarios</a>";
    }else{
        echo "<a href='login.php'>Login</a>";
    }

    echo"<hr>";
?>