<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efêmero - Criar conta</title>
    <link rel="stylesheet" href="css/criar.css">
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
    
    <main class="registro">
        <?php


           
            echo"
            <form action='#' method='POST' enctype='multipart/form-data'

            <div class='Dados'>
                <label><h2>Cadastrar Produto</h2><br></label>
                Selecione uma foto para o produto(*.jpg)<br>
                <input type='file' name='foto'><br><br>
            </div>

            <div class='Dados'>
                 <label for='nome'>Nome:</label>
                <input type='text' name='nome' required><br><br>
            </div>

            <div class='Dados'>
                <label for='descricao'>Descrição:</label>
                <input type='text' name='descricao' required>
            </div>

            <div class='Dados'>
                <label for='valoruni'>Valor unitário:</label>
                <input type='number' name='valoruni' required>
            </div>

            <div class='Dados'>
                <label for='estoque'>Quantidade no estoque:</label>
                <input type='number' name='estoque' required>
            </div>

            <div class='Dados'>
                <label for='aroma'>Aroma:</label>
                <input type='text' name='aroma' required>
            </div>

            <button type='submit'>Criar Produto</button>
            </form>

            </form>";

            if($_POST){
                $varSQL="INSERT INTO produto (nome, descricao, valor_unitario, excluido, qtde_estoque, aroma)
                VALUES (:nome,  :descricao, :valoruni, false, :estoque, :aroma)";

                $insert=$conn->prepare($varSQL);

                $insert->bindParam(':nome', $_POST['nome']);
                $insert->bindParam('descricao', $_POST["descricao"]);
                $insert->bindParam(':valoruni', $_POST["valoruni"]);
                $insert->bindParam(':estoque', $_POST["estoque"]);
                $insert->bindParam(':aroma', $_POST["aroma"]);
                
                if($insert->execute()>0){
                    echo "<br><br>Incluído com sucesso";
                }

                if($_FILES){
                    $id=$conn->lastInsertId();
                    $varArqRecebido=$_FILES['foto']['tmp_name'];
                    $varExtensaoPadrao='jpg';
                    $varNovoArq="imagens/p$id.$varExtensaoPadrao";
                    if(move_uploaded_file($varArqRecebido, $varNovoArq)){
                        echo "<br><br>Arquivo de foto foi recebido com sucesso!";
                    }
                }
            }

            echo "<br><br><a href='produtos.php'><button type='submit'>Voltar ao início</button></a>";
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



<?php
    

        
?>