<?php
    include("cabecalho.php");
    $conn = conecta();
    if (isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'] == true) {
        
        $varSQL = "SELECT id_usuario FROM usuario WHERE email = :login";
        $select = $conn->prepare($varSQL);
        $select->bindParam(':login', $login);
        $select->execute();

        if ($linha = $select->fetch()) {
            $id_usuario = $linha['id_usuario'];
            $varSQL = "UPDATE compra SET fk_id_usuario = :id_usuario WHERE sessao = :sessao";
            $update = $conn->prepare($varSQL);
            $update->bindParam(':sessao', $idSessao);
            $update->bindParam(':id_usuario', $id_usuario);
            $update->execute();

            $varSQL = "SELECT id_compra, status FROM compra WHERE fk_id_usuario = :id_usuario AND status = 'Pendente' ORDER BY id_compra ";
            $select = $conn->prepare($varSQL);
            $select->bindParam(':id_usuario', $id_usuario);
            $select->execute();
            if ($linha = $select->fetch()){
                $id_compra = $linha['id_compra'];
                $status = $linha['status'];
            }
            else{
                $status = 'Pendente';
                $varSQL = "INSERT INTO compra(status, data, sessao, fk_id_usuario) VALUES (:status, NOW(), :sessao, :id_usuario)";
                $insert = $conn->prepare($varSQL);
                $insert->bindParam(':status', $status);
                $insert->bindParam(':sessao', $idSessao);
                $insert->bindParam(':id_usuario', $id_usuario);
                $insert->execute();
    
                $id_compra = $conn->lastInsertId();
            }
        }
    }
    else{
        $varSQL = "SELECT id_compra, status FROM compra WHERE sessao = :sessao AND status = 'Pendente'";
        $select = $conn->prepare($varSQL);
        $select->bindParam(':sessao', $idSessao);
        $select->execute();
        if($linha = $select->fetch()){
            $id_compra = $linha['id_compra'];
            $status = $linha['status'];
        }
        else{
            $status = 'Pendente';
            $varSQL = "INSERT INTO compra(status, data, sessao) VALUES (:status, NOW(), :sessao)";
            $insert = $conn->prepare($varSQL);
            $insert->bindParam(':status', $status);
            $insert->bindParam(':sessao', $idSessao);
            $insert->execute();

            $id_compra = $conn->lastInsertId();
        }
    }
    echo "<html lang='pt-br'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='css/UI.css'>
                <link rel='stylesheet' href='css/widescreen.css'>
                <link rel='stylesheet' href='css/mobile.css'>
                <link rel='stylesheet' href='css/tablet.css'>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css' integrity='sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==' crossorigin='anonymous' referrerpolicy='no-referrer' />
                <link rel='preconnect' href='https://fonts.googleapis.com'>
                <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
                <link href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' rel='stylesheet'>
                <title>Carrinho de Compras</title>
            </head>
            <body>
                <article>";
                    function AtualizarGrid ($id_compra){
                        echo"
                            <h1 id='titulo'>
                                Carrinho de compras
                            </h1>";
                            $conn = conecta();
                            $total = 0;

                            $varSQL = "SELECT p.*, cp.quantidade, (p.valor_unitario * cp.quantidade) AS subtotal FROM compra_produto cp JOIN produto p ON cp.fk_id_produto = p.id_produto WHERE cp.fk_id_compra = :id_compra";
                            $select = $conn->prepare($varSQL);
                            $select->bindParam(':id_compra', $id_compra);
                            $select->execute();
                            while($linha = $select-> fetch()){
                            echo "
                                <div class='d1'>";
                                $varFoto = "../geral/imagens/p".$linha['id_produto'].".jpg";
                                if(file_exists($varFoto)){
                                    echo "<div class='prod'> <img src='$varFoto'>";
                                }
                                else{
                                    echo "<div class='prod'> <img src='../geral/imagens/a_foto.jpg'>";
                                }
                                echo "
                                    </div>
                                <div class='info'>
                                    <div>{$linha['nome']}</div>
                                    <div>{$linha['descricao']}</div>
                                    <div>Quantidade: {$linha['quantidade']}</div>
                                    <div class='preco'>R$ {$linha['subtotal']}</div>
                                    <div class='divbtnProd'><a href='carrinho.php?id_produto={$linha['id_produto']}&operacao=Incluir'><button class='btnProd'>Adicionar</button></div></a>
                                    <div class='divbtnProd'><a href='carrinho.php?id_produto={$linha['id_produto']}&operacao=Excluir'><button class='btnProd'>Remover</button></div></a>
                                </div>
                            </div>";
                            $total += $linha['subtotal'];

                            $varSQL = "UPDATE compra SET acrescimo_total = :total WHERE id_compra = :id_compra";
                            $update = $conn->prepare($varSQL);
                            $update->bindParam(':id_compra', $id_compra);
                            $update->bindParam(':total', $total);
                            $update->execute();
                            }
                            echo"
                            <div class='finalizar-compra'>
                                <div>
                                    <h2>Subtotal:</h2>
                                    <p class='textofinalizar'>R$ $total</p> 
                                </div>
                                <section class='desconto'>
                                    <h2>Desconto</h2>
                                    <form action='../compra/compra.php?id_compra=$id_compra&subtotal=$total' method='POST'>
                                        <input type='number' class='info2' name='desconto' max='$total' step='0.1' value='0' required >
                                </section>";
                            if(isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'] == true && $total > 0){
                                echo"
                                    <div class='divbtnFinalizar'>
                                        <button type='submit' class='btnFinalizar'>Finalizar compra</button>
                                    </div></form>";
                            }
                            echo"</div>";
                        }
                    if (isset($_GET['operacao'])) {
                        $operacao = $_GET['operacao'];
                        $qtd = 0;
                        if(isset($_GET['id_produto'])){
                            $id_produto = $_GET['id_produto'];
                            $varSQL = "SELECT quantidade FROM compra_produto WHERE fk_id_produto = :id_produto AND fk_id_compra = :id_compra";
                            $select = $conn->prepare($varSQL);
                            $select->bindParam(':id_produto', $id_produto);
                            $select->bindParam(':id_compra', $id_compra);
                            $select->execute();
                            if($linha = $select->fetch())
                                $qtd = $linha['quantidade'];
                            
                            $varSQL = "SELECT qtde_estoque FROM produto WHERE id_produto = :id_produto";
                            $select = $conn->prepare($varSQL);
                            $select->bindParam(':id_produto', $id_produto);
                            $select->execute();
                            $linha2 = $select->fetch();

                        }
                        if($operacao == 'Incluir'){
                            if($qtd == 0){
                                $varSQL = "SELECT valor_unitario FROM produto WHERE id_produto = :id_produto";
                                $select = $conn->prepare($varSQL);
                                $select->bindParam(':id_produto', $id_produto);
                                $select->execute();
                
                                $valor_unitario = $select->fetch();
                
                                $varSQL = "INSERT INTO compra_produto (fk_id_produto, fk_id_compra, quantidade, valor_unitario) VALUES (:id_produto, :id_compra, 1, :valor_unitario)";
                                $insert = $conn->prepare($varSQL);
                                $insert->bindParam(':id_produto', $id_produto);
                                $insert->bindParam(':id_compra', $id_compra);
                                $insert->bindParam(':valor_unitario', $valor_unitario['valor_unitario']);
                                $insert->execute();
                            }
                            else if ($qtd < $linha2['qtde_estoque']){
                                $novaQtd = $qtd + 1;
                                $varSQL = "UPDATE compra_produto SET quantidade = :quantidade WHERE fk_id_compra = :id_compra AND fk_id_produto = :id_produto";
                                $update = $conn->prepare($varSQL);
                                $update->bindParam(':quantidade', $novaQtd);
                                $update->bindParam(':id_compra', $id_compra);
                                $update->bindParam(':id_produto', $id_produto);
                                $update->execute();
                            }
                            AtualizarGrid($id_compra);
                        }
                        else if($operacao == 'Excluir'){
                            if($qtd > 1){
                                $novaQtd = $qtd - 1;
                                $varSQL = "UPDATE compra_produto SET quantidade = :quantidade WHERE fk_id_compra = :id_compra AND fk_id_produto = :id_produto";
                                $update = $conn->prepare($varSQL);
                                $update->bindParam(':quantidade', $novaQtd);
                                $update->bindParam(':id_compra', $id_compra);
                                $update->bindParam(':id_produto', $id_produto);
                                $update->execute();
                            }
                            else{
                                $varSQL = "DELETE FROM compra_produto WHERE fk_id_compra = :id_compra AND fk_id_produto = :id_produto";
                                $delete = $conn->prepare($varSQL);
                                $delete->bindParam(':id_compra', $id_compra);
                                $delete->bindParam(':id_produto', $id_produto);
                                $delete->execute();
                            }
                            AtualizarGrid($id_compra);
                        }
                    }else
                        AtualizarGrid($id_compra);
                echo "
                </article>
            </body>
        </html>";

?>