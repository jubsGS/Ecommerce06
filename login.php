<?php 
    include("cabecalho.php");

    $_SESSION['sessaoConectado']=false;
    $_SESSION['sessaoLogin']="";

    $conn = conecta();

    if(isset($_COOKIE['loginCookie'])){
        $loginCookie=$_COOKIE['loginCookie'];
    }
    else{
        $loginCookie='';
    }

    echo "
        <h1>Login do Usuário</h1>
        <form name='formlogin' method='post' action=''>
        <br>Email<input type='text' name='login' value='$loginCookie'>
        <br>Senha<input type='password' name='senha'>
        <br><input type='submit' value='Enviar'>
        </form>";
    
    if($_POST){
        $login=$_POST['login'];
        $senha=$_POST['senha'];
        setcookie('loginCookie', $login, time()+86400);
    
        $_SESSION['sessaoConectado']=ValidaLogin($login, $senha, $admin);
        
        if ( $_SESSION['sessaoConectado'] ) {    
            $_SESSION['sessaoLogin']=$login;
            $_SESSION['sessaoAdmin']=$admin;

            header('Location:login.php');
        
        } else {
            echo "<b>Usuario ou senha nao encontrado</b>
                <br><br><a href='index.php'>Voltar</a>";
        }
    }
?>