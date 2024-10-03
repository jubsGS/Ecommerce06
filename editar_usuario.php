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
                        <?php
                                include("cabecalho.php");
                                $conn = conecta();
                                if(!$conn){
            
                                    exit; //se nn conectar, sai
                                }

                                
                                if(isset( $_SESSION['sessaoLogin'])){
                                    echo"<li><a href='perfil.php?id=".$_SESSION['sessaoId']."'><i class='fa-solid fa-user'></a></i></li>";
                                }
                                else{
                                    echo"<li><a href='login.php'><i class='fa-solid fa-user'></a></i></li>";
                                }
                            ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    
    <main class="perfil">
        <?php

            $varSQL = "SELECT * FROM usuario WHERE excluido = false AND id_usuario = :id_usuario";//tabela para a presentar os usuários

            $select = $conn->prepare($varSQL);
            $select->bindParam(':id_usuario', $_SESSION['sessaoId']);
            $select->execute(); //executa sql e seleciona o que é pedido     

            echo"<div id='conta'>";
            while($linha = $select->fetch()){
                $id = $linha["id_usuario"];
                $nome = $linha["nome"];
                $email = $linha["email"];
                $varFoto="imagens/u".$linha['id_usuario'].".jpg";
                $telefone = $linha["telefone"];
                $senha = $linha["senha"];
            
                echo"<div class='informacoes'>
                        <div class='img'>";
                        if(file_exists($varFoto)){
                             echo"<img src='$varFoto' width=80> </div>";//se existe, puxa a foto
                        }
                        else{
                            echo"<img src='imagens/iconUsuario.png' width=80> </div>";//caso contrario, para que nn apareça um icone de arquivo corrompido, cham-se um melhor
                        }
                        
                        
                echo "
                        <form action='' method='post' enctype='multipart/form-data'> 
                        <h2><label for=''>Alterar Usuário</label></h2>
                    
                        <label for='nome'>Nome:</label>
                        <input type='text' name='nome' value=$nome><br><br>
                    
                        <label for='email'>Email:</label>
                        <input type='text' name='email' value=$email><br><br>
                    
                        <label for='senha'>Senha:</label>
                        <input type='text' name='senha' value=$senha><br><br>
                    
                        <label for='telefone'>Telefone:</label>
                        <input type='text' name='telefone' value=$telefone><br><br>
                    
                        Selecione uma foto (*.jpg)<br>
                        <input type='file' name='foto'><br><br>
                    
                        <button type='submit'>Enviar dados</button>
                        </form>";
            }
            echo"</div>";

                 
                        
            if ( $_POST ) { 
                $buscaSQL =' UPDATE usuario SET nome = :nome, email = :email, senha = :senha, telefone = :telefone WHERE id_usuario = :id_usuario';

                $update = $conn->prepare($buscaSQL);
                $update->bindParam(':nome', $_POST ['nome']);
                $update->bindParam(':email', $_POST ['email']);
                $update->bindParam(':senha', $_POST ['senha']);
                $update->bindParam(':telefone', $_POST ['telefone']);
                $update->bindParam(':id_usuario', $_SESSION['sessaoId']);
                
                var_dump($update->debugDumpParams());

                if($update->execute() > 0 )
                {
                    if($_FILES){
                        $varArqRecebido=$_FILES['foto']['tmp_name'];
                        $varExtensaoPadrao='jpg';
                        $varNovoArq="imagens/p$id.$varExtensaoPadrao";
                    }
                }
                echo "<a href='logout.php'><button type='button'>Voltar ao início</button></a>";
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
