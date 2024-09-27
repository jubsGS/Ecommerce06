
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/carrinho.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrinho</title>
  <link href='https://fonts.googleapis.com/css?family=Newsreader' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/abf8c89fd5.js" crossorigin="anonymous"></script>
</head>



<?php
    include("cabecalho.php");

    
    $conn = conecta();
    $idSessao = session_id();

    function CriarCompra($idSessao, $conn){
        $varSQL = "SELECT id_compra, status FROM compra WHERE sessao = :sessao AND status = 'PENDENTE'";
        $select = $conn->prepare($varSQL);
        $select->bindParam(':sessao', $idSessao);
        $select->execute();

        if ($linha = $select->fetch()) {
            $id_compra = $linha['id_compra'];
            return $id_compra;
        } else{
            $status = 'PENDENTE';
            $acrescimo_total = 0;
    
            $varSQL = "INSERT INTO compra (sessao, status, data, acrescimo_total) VALUES (:sessao, :status, NOW(), :acrescimo_total)";
            $insert = $conn->prepare($varSQL);
            $insert->bindParam(':sessao', $idSessao);
            $insert->bindParam(':status', $status);
            $insert->bindParam(':acrescimo_total', $acrescimo_total);

            if ($insert->execute()) {
                $id_compra = $conn->lastInsertId();
                return $id_compra;
            } else {
                return false;
            }
        }
    }

    function IncluirExcluirProduto($id_compra, $id_produto, $conn, $operacao) {
        $varSQL = "SELECT quantidade FROM compra_produto WHERE fk_id_compra = :id_compra AND fk_id_produto = :id_produto";
        $select = $conn->prepare($varSQL);
        $select->bindParam(':id_compra', $id_compra);
        $select->bindParam(':id_produto', $id_produto);
        $select->execute();
    
        if ($linha = $select->fetch()) {
            if ($operacao == 'incluir') {
                $novaQtde = $linha['quantidade'] + 1;
                
                $varSQL = "UPDATE compra_produto SET quantidade = :quantidade WHERE fk_id_compra = :id_compra AND fk_id_produto = :id_produto";
                $update = $conn->prepare($varSQL);
                $update->bindParam(':quantidade', $novaQtde);
                $update->bindParam(':id_compra', $id_compra);
                $update->bindParam(':id_produto', $id_produto);
                $update->execute();
            }

            elseif ($operacao == 'excluir') {
                $novaQtde = $linha['quantidade'] - 1;
    
                if ($novaQtde > 0) {
                    $varSQL = "UPDATE compra_produto SET quantidade = :quantidade WHERE fk_id_compra = :id_compra AND fk_id_produto = :id_produto";
                    $update = $conn->prepare($varSQL);
                    $update->bindParam(':quantidade', $novaQtde);
                    $update->bindParam(':id_compra', $id_compra);
                    $update->bindParam(':id_produto', $id_produto);
                    $update->execute();
                } 
                else {
                    $sqlDelete = "DELETE FROM compra_produto WHERE fk_id_compra = :id_compra AND fk_id_produto = :id_produto";
                    $delete = $conn->prepare($sqlDelete);
                    $delete->bindParam(':id_compra', $id_compra);
                    $delete->bindParam(':id_produto', $id_produto);
                    $delete->execute();
                }
            }
        } 
        else {
            if ($operacao == 'incluir') {
                $quantidade = 1;

                $varSQL = "SELECT valor_unitario FROM produto WHERE id_produto = :id_produto";
                $select = $conn->prepare($varSQL);
                $select->bindParam(':id_produto', $id_produto);
                $select->execute();
                if ($produto = $select->fetch()) {
                    $valor_unitario = $produto['valor_unitario'];
                }

                $varSQL = "INSERT INTO compra_produto (fk_id_compra, fk_id_produto, quantidade, valor_unitario) VALUES (:id_compra, :id_produto, :quantidade, :valor_unitario)";
                $insert = $conn->prepare($varSQL);
                $insert->bindParam(':id_compra', $id_compra);
                $insert->bindParam(':id_produto', $id_produto);
                $insert->bindParam(':quantidade', $quantidade);
                $insert->bindParam(':valor_unitario', $valor_unitario);
                $insert->execute();
            }
        }
    }
    ?>

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
            function AtualizaGride($id_compra, $conn) {

                $varSQL = "SELECT p.*, cp.quantidade, (p.valor_unitario * cp.quantidade) AS subtotal 
                        FROM compra_produto cp
                        JOIN produto p ON cp.fk_id_produto = p.id_produto
                        WHERE cp.fk_id_compra = :id_compra";
                $select = $conn->prepare($varSQL);
                $select->bindParam(':id_compra', $id_compra);
                $select->execute();  
            
                $total = 0;

                echo "  <article class='a1'>
                            <h1>Carrinho</h1>
                        </article>
                
                        <article class='itens'>";

                while ($linha = $select->fetch()) {
                    $varFoto="imagens/p".$linha['id_produto'].".jpg";
                    echo "
                            <div class='produto'>
                                <div class='imagem'>
                                    <img src='$varFoto'>
                                </div>
                                
                        
                                <div class='info'>
                                    <h3 class='nomeP'>{$linha['nome']}</h3>
                                    <div class='precoU'><h4>R$ {$linha['valor_unitario']} </h4><h6> (p/unidade)</h6></div>
                    
                                    <div class='qtde'>
                                        <div class='adicionaExclui'>
                                        <a href='carrinho.php?id_produto={$linha['id_produto']}&operacao=incluir'><button type='button'>+</button></a>
                                        <p>{$linha['quantidade']}</p>
                                        <a href='carrinho.php?id_produto={$linha['id_produto']}&operacao=excluir'><button type='button'>-</button></a>
                                        </div>
                                    </div>";

                    $total += $linha['subtotal'];

                    echo"           <h4 class='subT'>Subtotal: R$  {$linha['subtotal']}</h4>
                                </div>
                            </div>
                            ";  
                }
                echo "</article>";
            
                echo"   <article class='compra'>
                            <div>
                                <h1>Resumo da compra</h1>
                                <p>Total: R$$total</p>
                                ";
            
                $varSQL = "SELECT status FROM compra WHERE id_compra = :id_compra";
                $select = $conn->prepare($varSQL);
                $select->bindParam(':id_compra', $id_compra);
                $select->execute();
                
                while($linha = $select->fetch()){
                    if ($linha['status'] == 'PENDENTE' && $total > 0 && isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'] == true ) {
                        echo "          <a href='carrinho.php?id_compra=$id_compra&operacao=fechar'><button class='btcompra'>Finalizar Compra</button></a>
                                    </div>
                                </article>";
                    }
                }
                
            }


            if (isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'] == true) {
                $login = $_SESSION['sessaoLogin'];
                
                $varSQL = "SELECT id_usuario FROM usuario WHERE email = :login";
                $select = $conn->prepare($varSQL);
                $select->bindParam(':login', $login);
                $select->execute();

                if ($linha = $select->fetch()) {
                    $id_usuario = $linha['id_usuario'];

                    $varSQL = "UPDATE compra SET fk_id_usuario = :id_usuario WHERE sessao = :sessao AND status = 'PENDENTE'";
                    $update = $conn->prepare($varSQL);
                    $update->bindParam(':id_usuario', $id_usuario);
                    $update->bindParam(':sessao', $idSessao);
                    $update->execute();
                }
            }

            if (isset($_GET['operacao']) && isset($_GET['id_produto'])) {
                $operacao = $_GET['operacao'];
                $id_produto = $_GET['id_produto'];

                $id_compra = CriarCompra($idSessao, $conn);
                if ($id_compra) {
                    IncluirExcluirProduto($id_compra, $id_produto, $conn, $operacao);
                    AtualizaGride($id_compra, $conn);
                    header("Location: carrinho.php");
                }
            } elseif (isset($_GET['operacao']) && $_GET['operacao'] == 'fechar') {
                $id_compra = $_GET['id_compra'];
                echo "ID compra: " . $id_compra;

                $varSQL = "SELECT SUM(p.valor_unitario * cp.quantidade) AS total
                FROM compra_produto cp
                JOIN produto p ON cp.fk_id_produto = p.id_produto
                WHERE cp.fk_id_compra = :id_compra";
                $select = $conn->prepare($varSQL);
                $select->bindParam(':id_compra', $id_compra);
                $select->execute();

                if ($linha = $select->fetch()) {
                    $total = $linha['total'];
                    echo "<br>Total: R$" . $total;  
                }
                echo"   
                <form name='formVoucher' method='POST' action='pagar.php?id_compra=$id_compra'>
                    <label for='ac_dec'>Acres/Decres(+/-):</label><br>
                    <input type='number' name='ac_dec' step='0.01' required><br>

                    <label for='voucher'>Informe o Voucher</label><br>
                    <input type='text' name='voucher' required><br>

                    <label for='voucher_verif'>Redigite o Voucher</label><br>
                    <input type='text' name='voucher_verif' required><br>

                    <button type='submit'>Fechar Compra</button>
                </form>";
            } else {
                $id_compra = CriarCompra($idSessao, $conn);
                if ($id_compra) {
                    AtualizaGride($id_compra, $conn);
                }
            }

        ?>
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

