<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/visu_usuario.css">
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
    <main>
        <?php
            $varSQL = "SELECT * FROM usuario WHERE excluido = false";//tabela para a presentar os usuários
            
            $select = $conn->prepare($varSQL);
            $select->execute(); //executa sql e seleciona o que é pedido
            
            echo"<table>";
                echo"<tr class='cabecalho'>
                        <td><h3>Usuário</h3></td>
                        <td><h3>Nome</h3></td>
                        <td><h3>Email</h3></td>
                        <td><h3>Senha</h3></td>
                        <td><h3>Telefone</h3></td>
                        <td><h3>Admin</h3></td>
                        <td><h3>Alterar</h3></td>
                        <td><h3>Excluir</h3></td>
                        </tr>";
            while($linha = $select->fetch()){
                echo"<tr class='usuario'>";

                $varFoto = "imagens/u".$linha['id_usuario'].".jpg";//puxa a imagem da pasta imagem, referente ao id
                echo"<td class='img'>";
                    if(file_exists($varFoto)){
                        echo"<img src='$varFoto' width=80>";//se existe, puxa a foto
                    }
                    else{
                        echo"<img src='imagens/iconUsuario.png' width=80>";//caso contrario, para que nn apareça um icone de arquivo corrompido, cham-se um melhor
                    }
                echo "</td>";

                echo "<td class='nome'>";
                    echo $linha["nome"];
                echo "</td>";

                echo "<td class='email'>";
                    echo $linha["email"];
                echo "</td>";

                echo "<td class='senha'>";
                    echo $linha["senha"];
                echo "</td>";

                echo "<td class='telefone'>";
                    echo $linha["telefone"];
                echo "</td>";

                echo "<td class='admin'>";
                    if($linha["admin"] = "true"){
                        echo"True";
                    }
                    else{
                        echo"False";
                    }
                echo "</td>";

                echo "<td class='editar'>";
                    echo "<a href= 'editar_usuario.php?id=".$linha['id_usuario']."'>Alterar</a>";//acessa o arquivo "alterarUsuario.php" passando o id referente para a ação
                echo "</td>";

                echo "<td class='remover'>";
                    echo "<a href= 'remover_usuario.php?id=".$linha['id_usuario']."'>Excluir</a>";//acessa o arquivo "alterarUsuario.php" passando o id referente para a ação
                echo "</td>";
                
                echo"</tr>";
            }

            echo "  <tr>
                        <td colspan='4' class='botoes'><a href='adicionarProdutos.php'><button type='button'>Adicionar</button></a> <a href='index.php'><button type='button'>Voltar</button></a></td>
                    </tr>";
            echo"</table>";
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