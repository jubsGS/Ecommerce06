<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/sobre.css">
        <link href="https://fonts.googleapis.com/css?family=Newsreader|Inter" rel="stylesheet">
        <script src="https://kit.fontawesome.com/abf8c89fd5.js" crossorigin="anonymous"></script>
        <title>Sobre Nós</title>
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
            <section>
                <h1 class="sobrenos">Sobre nós</h1>
                <div class="text">
                    <h2 class="t1"> Equipe 6 - 2° ano A <br>
                        Integrantes: Arthur Serra, Gabriela Oliveira, Julia Gomes, Pedro Pimenta, Pedro Damiance
                    </h2>
                    <p>
                        O projeto é fundamentado a partir do surgimento da ideia e concordância da empresa pela busca em confeccionar um produto que traga a sensação de aconchego àquele que se interesse, tanto nos aspectos visuais quanto nos aromas, e o adquira a partir de seu deleite. Optamos por apresentar velas aromáticas onde a mercadoria detém uma origem totalmente artesanal, desde a produção até o momento de embalo para o cliente. 
                            Além de ser um produto totalmente de origem vegana, estabelecemos uma identidade empresarial ao combinarmos fragrâncias e sensações em nossos produtos que irão atender aos pedidos e expectativas postos pelos clientes.<br><br>
                    
                        Nosso nome, Efêmero - Velas Artesanais", vem do exato sentido da palavra efêmero, que possui um significado de pouco duradouro, como a chama de uma vela, foi pensando nesse significado que a palavra “Efêmero” se tornou o visual de nossa marca, trazendo junto o ditado popular de que tudo que é efêmero possui sua beleza particular.
                    </p>
                </div>
                <div class="divimg">
                    <div class="foto"><img src='imagens/sobre.jpg'></div>
                </div>
            </section>
        </main>
        
        <footer>
            <div id="efemero">
                <h3>Efêmero - Velas Artesanais</h3>
            </div>

            <div id="contato">
                <h3>Contato</h3>
                <p>efemero@gmail.com<br>
                Colégio Técnico Industrial "Prof. Isaac Portal Roldán" - UNESP - Bauru/SP, 17033-260</p>
            </div>
        </footer>
    </body>
</html>