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
            include('cabecalho.php');
           
            echo"
            <form action='#' method='POST' enctype='multipart/form-data'

            <div class='Dados'>
                <label><h1>SEJA BEM-VINDO!</h1><br><h2>Criar conta</h2><br></label>
                Selecione uma foto para seu perfil(*.jpg)<br>
                <input type='file' name='foto'><br><br>
            </div>

            <div class='Dados'>
                <label for='nome'>Nome de usuário</label>
                <input type='text' id='nome' name='nome' required>
            </div>

            <div class='Dados'>
                <label for='email'>Email</label>
                <input type='text' id='email' name='email' required>
            </div>

            <div class='Dados'>
                <label for='senha'>Senha</label>
                <input type='password' id='senha' name='senha' required>
            </div>

            <div class='Dados'>
                <label for='telefone'>Telefone</label>
                <input type='text' id='telefone' name='telefone' required>
            </div>

            <button type='submit'>Criar Conta</button>
            </form>
            <div class='opc-login'>
                <p>Já possui uma conta?</p>
                <a href='login.html'>Voltar para o Login</a>
            </div>

            </form>";

            if($_POST){
                $conn=conecta();
                //insere os valores do formulario em suas respectivas colunas
                $varSQL="INSERT INTO usuario (nome, email, senha, telefone, admin, excluido)
                        VALUES (:nome,  :email, :senha, :telefone, false, false)";
                
                $insert= $conn->prepare($varSQL);
        
                $insert->bindParam(':nome', $_POST["nome"]);
                $insert->bindParam(':email', $_POST["email"]);
                $insert->bindParam(':senha', $_POST["senha"]);
                $insert->bindParam(':telefone', $_POST["telefone"]);
        
                if($insert->execute()>0){
                    echo"<script type='javascript'>alert('Conta criada com sucesso!');";
                }
                if($_FILES){
                    $id=$conn->lastInsertId();
                    $varArqRecebido=$_FILES['foto']['tmp_name'];
                    $varExtensaoPadrao='jpg';
                    $varNovoArq="imagens/u$id.$varExtensaoPadrao";
                    if(move_uploaded_file($varArqRecebido, $varNovoArq)){
                       echo"<script type='javascript'>alert('Arquivo de imagem enviado com sucesso!');";
                    }
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