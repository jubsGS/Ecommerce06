<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/perfil.css">
    <link href='https://fonts.googleapis.com/css?family=Newsreader' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/abf8c89fd5.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navTopo">
            <ul>
                <li>
                    <a href="index.php"><strong>EFÊMERO</strong></a>
                </li>

                <li>
                    <ul class="icons">
                        <li><a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                        <li><a href="login.php"><i class="fa-solid fa-user"></a></i></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    
    <main class="perfil">
        <?php
            include("cabecalho.php");
            $conn = conecta();
            if(!$conn){

                exit; //se nn conectar, sai
            }

            $id = $_GET['id'];

            $varSQL = "SELECT * FROM usuario WHERE excluido = false AND id_usuario = :id_usuario";//tabela para a presentar os usuários

            $select = $conn->prepare($varSQL);
            $select->bindParam(':id_usuario', $id);
            $select->execute(); //executa sql e seleciona o que é pedido     

            echo"<div id='conta'>";
            while($linha = $select->fetch()){
                $id = $linha["id_usuario"];
                $nome = $linha["nome"];
                $email = $linha["email"];
                $varFoto="imagens/u".$linha['id_usuario'].".jpg";
            
                echo"<div class='informacoes'>
                        <div class='img'>
                            <img src='$varFoto'>
                        </div>
                        <div class='info'>
                            <h3>Nome de Usuário</h3><br>
                            $nome<hr>

                            <h3>Email</h3>
                            $email<hr>
                        </div>
                    </div>
                    
                    <div class='Conta'>
                        <a href='alterar_usuario.php'><button type='button'>Alterar Usuário</button></a>
                    
                        <a href='alterar_usuario.php'><button type='button'>Excluir Usuário</button></a>
                    </div>";
            }
            echo"</div>";
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