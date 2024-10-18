<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Efêmero - Ecommerce de Velas Artesanais</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Newsreader|Inter" rel="stylesheet">
    <script src="https://kit.fontawesome.com/abf8c89fd5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/index.css">
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
        <section id="home" class="slider">
            <div class="slides">
                <div class="slide"><img src="imagens/p1.jpg" alt="Imagem 1"></div>
                <div class="slide"><img src="imagens/p2.jpg" alt="Imagem 2"></div>
                <div class="slide"><img src="imagens/p3.jpg" alt="Imagem 3"></div>
                <div class="slide"><img src="imagens/p4.jpg" alt="Imagem 4"></div>
            </div>

            <button id="prev" onclick="changeSlide(-1)">&#10094;</button>
            <button id="next" onclick="changeSlide(1)">&#10095;</button>

            <div id="textHome">
                <h1><strong>EFÊMERO</strong></h1>
                <p class="slogan">Aromas que acolhem e visuais que encantam.<br>
                Velas artesanais veganas para transformar cada momento em uma experiência de aconchego.</p>
            </div>
        </section>





        <section id="velas">
            <h2>Nossos produtos</h2>
            <div id="produtos">
                <?php
                    if ($conn) {
                        $varSQL = "SELECT * FROM produto WHERE excluido = false";
                        $select = $conn->prepare($varSQL);
                        $select->execute();

                        while ($linha = $select->fetch()) {
                            $id = htmlspecialchars($linha["id_produto"]);
                            $nome = htmlspecialchars($linha["nome"]);
                            $valoruni = number_format($linha["valor_unitario"], 2, ',', '.');
                            $varFoto = "imagens/p" . $id . ".jpg";

                            echo "<a href='produtos.php?id=$id'>
                                    <section class='produto'>
                                        <img src='$varFoto' alt='$nome'>
                                        <h3>$nome</h3>
                                        <p>R$ $valoruni</p>
                                    </section>
                                  </a>";
                        }
                    }
                ?>
            </div>
        </section>

        <section id="sobre">
            <div id="sobreTxt">
                <h2>Sobre Nós</h2>
                <p>Para ver mais informações sobre nossa equipe e projeto, clique no botão abaixo.</p>
                <a href="sobrenos.php" class="btn-ver-mais">Veja mais</a>
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

<script>
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        const homeSection = document.getElementById('home');

        // Verifica a posição da rolagem
        if (window.scrollY > 0) {
            header.classList.add('scrolled'); // Adiciona a classe para sombra
            homeSection.classList.add('sticky'); // Move a seção para baixo
        } else {
            header.classList.remove('scrolled'); // Remove a sombra
            homeSection.classList.remove('sticky'); // Move a seção para cima
        }
    });


   


    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide'); // Seleciona todos os slides
    const totalSlides = slides.length; // Total de slides
    const slideContainer = document.querySelector('.slides'); // Seleciona o contêiner dos slides

    function changeSlide(direction) {
        // Atualiza o índice do slide atual
        currentSlide += direction;

        // Lógica para loop contínuo
        if (currentSlide < 0) {
            currentSlide = totalSlides - 1; // Volta para o último slide
        } else if (currentSlide >= totalSlides) {
            currentSlide = 0; // Vai para o primeiro slide
        }

        // Move os slides para a esquerda ou direita
        const offset = -currentSlide * 100; // Calcula o deslocamento em porcentagem
        slideContainer.style.transform = `translateX(${offset}%)`; // Aplica o deslocamento
        }

        // Função para mudar o slide automaticamente
        function autoChangeSlide() {
            changeSlide(1); // Muda para o próximo slide
        }

        // Inicia a mudança automática a cada 5 segundos (5000 milissegundos)
        let slideInterval = setInterval(autoChangeSlide, 5000);

        // Inicializa a primeira imagem como visível
        slides[currentSlide].classList.add('active');

        // Adiciona um evento de mouse para parar o slider quando o mouse estiver sobre ele
        document.querySelector('.slider').addEventListener('mouseover', function() {
            clearInterval(slideInterval);
        });

        // Retorna o intervalo quando o mouse sai
        document.querySelector('.slider').addEventListener('mouseout', function() {
            slideInterval = setInterval(autoChangeSlide, 5000);
        });
</script>
</html>