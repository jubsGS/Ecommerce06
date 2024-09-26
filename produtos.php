<?php
    include("cabecalho.php");
    $conn = conecta();
    if(!$conn){
        exit; //se nn conectar, sai
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/produto.css">
        <title>Nome do produto</title>
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

        <main>
            <article class="produto">
                <?php
                    $id = $_GET['id'];

                    $varSQL = "SELECT * FROM produto WHERE id_produto = :id_produto";//mesmo esquema do alterar usuario
                
                    $select = $conn->prepare($varSQL);
                    $select->bindParam(':id_produto', $id);
                    $select->execute();
                    
                    while($linha = $select->fetch()){
                        $id = $linha["id_produto"];
                        $nome = $linha["nome"];
                        $desc = $linha["descricao"];
                        $qtde_estoque = $linha["qtde_estoque"];
                        $valoruni = $linha["valor_unitario"];
                        $varFoto="imagens/p".$linha['id_produto'].".jpg";

                        echo"<div id= 'produto'>
                                            <img src='$varFoto'>
                                </div>";

                                
                        
                        echo"<section class='info'>
                                <h1>$nome</h1>
                                <hr>
                                <h2>$desc</h2>
                                <hr>
                                <h3>R$$valoruni</h3><br>
                                
                               
                                <p><i>Dúvidas?</i> Contate-nos em algumas das <a href='#contato'>opções</a> abaixo</p>
                              ";
                        if ($qtde_estoque > 0) {
                            echo "<a href='carrinho.php?id_produto=$id&operacao=incluir'> <button type='submit'>Adicionar ao carrinho</button></a><br><br></section>";
                        } else {
                            echo "<button type='submit'>Adicionar ao carrinho</button><br><br></section>";
                        }
                        echo "</center></td>";
                    }
                ?>
            </article>
            
            <article id="recomendacao">
                <h1>Produtos que voce pode se interessar</h1>
                <?php
                    $varSQL = "SELECT * FROM produto WHERE excluido = false";//tabela para a presentar os usuários

                    $select = $conn->prepare($varSQL);
                    $select->execute(); //executa sql e seleciona o que é pedido     

                    echo"<div id= 'produtosRec'>";
                    while($linha = $select->fetch()){
                        $id = $linha["id_produto"];
                        $nome = $linha["nome"];
                        $desc = $linha["descricao"];
                        $valoruni = $linha["valor_unitario"];
                        $varFoto="imagens/p".$linha['id_produto'].".jpg";

                        echo"<a href='produtos.php?id=".$linha['id_produto']."'>
                                        <section>
                                            <img src='$varFoto'>
                                            
                                            <p>
                                                <h2>$nome</h2>
                                                <p>$desc</p>
                                                R$ $valoruni
                                            </p>
                                        </section>
                                    </a>";
                    }
                    echo"</div>";
                ?>
            </article>
        </main>

        <footer>
            <div id="efemero">
                <h3>Efêmero - Velas Artesanais</h3>
            </div>

            <div id="contato">
                <h3>Contato</h3>
                    <p>
                        efemero@gmail.com<br>
                        Colégio Técnico Industrial "Prof. Isaac Portal Roldán"-UNESP - Bauru/SP, 17033-260
                    </p>
            </div>
        </footer>
    </body>
</html>