<?php
    include("cabecalho.php");

    $conn = conecta();

    $id = $_GET['id'];

    $varSQL = "SELECT * FROM produto WHERE id_produto = :id_produto";//mesmo esquema do alterar usuario

    $select = $conn->prepare($varSQL);
    $select->bindParam(':id_produto', $id);
    $select->execute();
    $linha = $select->fetch();

    $nome = $linha['nome'];
    $descricao = $linha['descricao'];
    $valoruni = $linha['valor_unitario'];
    $estoque = $linha['qtde_estoque'];
    $aroma = $linha['aroma'];

    echo "<h1>Visualicação atual</h1>
    <table border=1>";//criação da tabela
    echo "<tr>
                <th>imagem</th>
                <th>nome</th>
                <th>descrição</th>
                <th>valor</th>
                <th>produto excluído?</th>
                <th>data exclusão</th>
                <th>estoque</th>
                <th>aroma</th>
            </tr>";
        $varFoto="imagens/p".$linha['id_produto'].".jpg";
        echo "<td>";
        if(file_exists($varFoto)){//se existir, chama
            echo "<img src='$varFoto' width=80>";
        }else{//ao contrario, mostra um icone sem que seja aquele de arquivo corrompido
            echo "<img src='imagens/iconSacola.webp' width=80>";
        }
        echo "</td>";

        echo "<td>";
        echo $linha['nome'];
        echo "</td>";

        echo "<td>";
        echo $linha['descricao'];
        echo "</td>";

        echo "<td>";
        echo $linha['valor_unitario'];
        echo "</td>";

        echo "<td>";
        if($linha['excluido']==false){//verifica se o produto esta inserido ou nn na tabela
            echo "não";
        }
        else{
            echo "sim";
        }
        echo "</td>";

        if($linha['excluido']==false){//verifica se o produto esta inserido ou nn na tabela, se sim, vai adicionar a data em que foi excluido
            echo "<td>";
            echo "...";
            echo "</td>";
        }
        else{
            echo "<td>";
            echo $linha['data_exclusao'];
            echo "</td>";
        }
        echo "<td>";
            echo $linha['qtde_estoque'];
        echo "</td>";
        echo "<td>";
            echo $linha['aroma'];
        echo "</td>";
        echo "</tr>";
    echo "</table>";


    
    echo "
    <form action='' method='post' enctype='multipart/form-data'> 
    <h2><label for=''>Alterar Produto</label></h2>

    <label for='nome'>Nome:</label>
    <input type='text' name='nome' value=$nome><br><br>

    <label for='descricao'>Descrição:</label>
    <input type='text' name='descricao' value=$descricao><br><br>

    <label for='valoruni'>Valor unitário:</label>
    <input type='number' name='valoruni' value=$valoruni><br><br>

    <label for='estoque'>Quantidade de estoque:</label>
    <input type='number' name='estoque' value=$estoque><br><br>

    <label for='aroma'>Aroma:</label>
    <input type='text' name='aroma' value=$aroma><br><br>

    Selecione uma foto (*.jpg)<br>
    <input type='file' name='foto'><br><br>

    <button type='submit'>Enviar dados</button>
    </form>";

    if ($_POST) { 
        // Verifica se os valores numéricos estão vazios e os define como NULL ou um valor padrão
        $valoruni = !empty($_POST['valoruni']) ? $_POST['valoruni'] : null;
        $estoque = !empty($_POST['estoque']) ? $_POST['estoque'] : null;
    
        $varSQL =
            "UPDATE produto
             SET nome = :nome, descricao = :descricao,
             valor_unitario = :valoruni, qtde_estoque = :estoque, aroma = :aroma
             WHERE id_produto = :id";
    
        $update = $conn->prepare($varSQL);
        $update->bindParam(':nome', $_POST['nome']);
        $update->bindParam(':descricao', $_POST['descricao']);
        $update->bindParam(':valoruni', $valoruni, PDO::PARAM_STR); // Usa PDO::PARAM_STR para valores numéricos como string
        $update->bindParam(':estoque', $estoque, PDO::PARAM_STR);
        $update->bindParam(':aroma', $_POST['aroma']);
        $update->bindParam(':id', $_POST['id']);
    
        if ($update->execute()>0) {
            echo "Alterado!!!";
    
            if ($_FILES) {
                $varArqRecebido = $_FILES['foto']['tmp_name'];
                $varExtensaoPadrao = 'jpg';
                $varNovoArq = "imagens/p$id.$varExtensaoPadrao";
                if (move_uploaded_file($varArqRecebido, $varNovoArq)) {
                    echo "<br><br>Arquivo de foto foi recebido e atualizado com sucesso!";
                }
            }
        }
        header('location:produtos.php');
    }

?>