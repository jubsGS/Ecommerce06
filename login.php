<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link href='https://fonts.googleapis.com/css?family=Newsreader' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/abf8c89fd5.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navTopo">
            <ul>
                <li>
                    <a href="index.html"><strong>EFÊMERO</strong></a>
                </li>

                <li>
                    <ul class="icons">
                        <li><a href="carrinho.html"><i class="fa-solid fa-cart-shopping"></i></a></li>
                        <li><a href="login.html"><i class="fa-solid fa-user"></a></i></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    
    <main class="login-container">
        <form action="#" method="POST">
            <div class="Dados">
                <label><h2>BEM-VINDO DE VOLTA!</h2><br></label>
                <label for="username">Nome de usuário</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="Dados">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="Criar">
            <p>Novo por aqui?</p>
            <a href="criar.html"><button type="button">Criar Conta</button></a>
        </div>
    </main>
    <footer>
        <ul>
            <li><a href="#">Política de Privacidade</a></li>
            <li><a href="#">Ajuda</a></li>
            <li><a href="#">Cookies</a></li>
        </ul>
    </footer>
</body>
</html>
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