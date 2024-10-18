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
                <li><a href="index.php"><strong>EFÊMERO</strong></a></li>
                <li>
                    <ul class="icons">
                        <li><a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                        <?php
                            include("cabecalho.php");
                            $conn = conecta();

                            if ($conn && isset($_SESSION['sessaoLogin'])) {
                                echo "<li><a href='perfil.php?id=" . htmlspecialchars($_SESSION['sessaoId']) . "'><i class='fa-solid fa-user'></i></a></li>";
                            } else {
                                echo "<li><a href='login.php'><i class='fa-solid fa-user'></i></a></li>";
                            }
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    
    <main class="login-container">
        <?php 
            

            $_SESSION['sessaoConectado']=false;
            $_SESSION['sessaoLogin']="";

            if(isset($_COOKIE['loginCookie'])){
                $loginCookie=$_COOKIE['loginCookie'];
            }
            else{
                $loginCookie='';
            }

            echo" <form name='formlogin' method='post' action='#'>
                    <div class='Dados'>
                        <label><h2>BEM-VINDO DE VOLTA!</h2><br></label>
                        <label for='email'>Email</label>
                        <input type='text' id='login' name='login' value='$loginCookie'>
                    </div>

                    <div class='Dados'>
                        <label for='password'>Senha</label>
                        <input type='password' id='senha' name='senha'>
                    </div>

                    <button type='submit' value='Enviar'>Login</button>
                </form>
                <div class='Criar'>
                    <p>Novo por aqui?</p>
                    <a href='criar.php'><button type='button'>Criar Conta</button></a>
                </div>";
            
            if($_POST){
                $login=$_POST['login'];
                $senha=$_POST['senha'];
                setcookie('loginCookie', $login, time()+86400);
            
                $_SESSION['sessaoConectado']=ValidaLogin($login, $senha, $admin);
                
                if ( $_SESSION['sessaoConectado'] ) {    
                    $_SESSION['sessaoLogin']=$login;
                    $_SESSION['sessaoAdmin']=$admin;

                    $varSQL = "SELECT * FROM usuario WHERE email =:email";//tabela para a presentar os usuários

                    $select = $conn->prepare($varSQL);
                    $select->bindParam(':email', $login);
                    $select->execute();//executa sql e seleciona o que é pedido     

                    while($linha = $select->fetch()){
                        $id = $linha["id_usuario"];
                        $_SESSION['sessaoId'] = $id;

                        //echo"<a href='index.php?id=".$linha['id_usuario']."'> <button type='submit' value='Enviar'>Voltar ao Login</button> </a>";

                        header("location:perfil.php");
                    }

                   
                
                } else {
                    echo "<div class='Dados'>
                        <label for='erro'>Não foi possível encontrar esse usuário, por favor verifique as credenciais preenchidas.</label>
                    </div>";
                }
            }
        ?>
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