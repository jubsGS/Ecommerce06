<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/visu_prod.css">
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

    <main>
        <?php

            $varSQL = "SELECT * FROM produto WHERE excluido = false";
            $select = $conn->prepare($varSQL);
            $select->execute();


            echo "<table>
            <tr class='cabecalho'>
                <td><h3>Foto</h3></td>
                <td><h3>Nome</h3></td>
                <td><h3>Descrição</h3></td>
                <td><h3>Valor Unitário</h3></td>
                <td><h3>Quantidade em Estoque</h3></td>
                <td><h3>Alterar</h3></td>
                <td><h3>Excluir</h3></td>
            </tr>";
            
            while ($linha = $select->fetch()) {
                echo "<tr class='usuario'>";

                echo"<td>";

                $varFoto = "imagens/p".$linha['id_produto'].".jpg";
                if(file_exists($varFoto)){
                    echo"<img src = '$varFoto' width=80>";
                }
                else{
                    echo"<img src= 'imagens/iconSacola.jpg' width = 80>";
                }

                echo"</td>";

                echo"<td>{$linha['nome']}</td>";

                echo"<td>{$linha['descricao']}</td>";

                echo"<td>{$linha['valor_unitario']}</td>";

                echo"<td>{$linha['qtde_estoque']}</td>";

                echo"<td><a href='alterarProdutos.php?id={$linha['id_produto']}'>Alterar</a></td>";
                
                echo"<td><a href='removerProdutos.php?id={$linha['id_produto']}'>Excluir</a></td>";
                
                echo"</tr>";
            }

           echo "<tr>
                    <td><a href='adicionar_produto.php'><button type='button'>Adicionar</button></a></td>
                </tr>
                <tr>
                    <td><a href='index.php'><button type='button'>Voltar</button></a></td>
                </tr>";

            echo "</table>";

           

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