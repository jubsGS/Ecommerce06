<html>
    <head>
        <meta charset="8-UTF">
        <title>Ecommerce</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://fonts.googleapis.com/css?family=Newsreader' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/abf8c89fd5.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/index.css">
        
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
            <article id="home">
                <div id="textHome">
                    <p><!--textinho informativo do produto-->
                        <h1><strong>EFÊMERO</strong></h1>
                    <strong class="slogan">Aromas que acolhem e visuais que encantam. Velas artesanais veganas para transformar cada momento em uma experiência de aconchego.</strong>
                    </p>
                </div>
            </article>

            <article id="velas">
                <h1>Nossos produtos</h1>
                <?php
                    $varSQL = "SELECT * FROM produto WHERE excluido = false";//tabela para a presentar os usuários

                    $select = $conn->prepare($varSQL);
                    $select->execute(); //executa sql e seleciona o que é pedido     

                    echo"<div id= 'produtos'>";
                    while($linha = $select->fetch()){
                        $id = $linha["id_produto"];
                        $nome = $linha["nome"];
                        $valoruni = $linha["valor_unitario"];
                        $varFoto="imagens/p".$linha['id_produto'].".jpg";
                    
                        echo"<a href='produtos.php?id=".$linha['id_produto']."'>
                                        <section>
                                            <img src='$varFoto'>
                                            
                                            <p>
                                                <h2>$nome</h2>
                                                R$ $valoruni.00
                                            </p>
                                        </section>
                                    </a>";
                    }
                    echo"</div>";
                ?>
            </article>

            <article id="sobre">
                <div id="sobreTxt">
                <h1>Sobre Nós</h1>
                    <br>
                    Para ver mais informações sobre nossa equipe e projeto, clique no botão abaixo.    
                    <br>
                    <a href="sobrenos.php">
                        <button>Veja mais</button>
                    </a>
                </div>
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