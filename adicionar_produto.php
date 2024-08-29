<?php
    include("cabecalho.php");

    echo"
    <form action='' method='post' enctype='multipart/form-data'> 
        <h2><label for=''>Cadastro Produto</label></h2>

        <label for='nome'>Nome:</label>
        <input type='text' name='nome'><br><br>

        <label for='descricao'>Descrição:</label>
        <input type='text' name='descricao'><br><br>

        <label for='valoruni'>Valor unitário:</label>
        <input type='number' name='valoruni'><br><br>

        <label for='estoque'>Quantidade no estoque:</label>
        <input type='number' name='estoque'><br><br>

        <label for='aroma'>Aroma:</label>
        <input type='text' name='aroma'><br><br>

        Selecione uma foto (*.jpg)<br>
        <input type='file' name='foto'><br><br>

        <button type='submit'>Enviar dados</button>
    </form>";

    if($_POST){
        $conn=conecta();

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

echo "<br><br><a href='produtos.php'>Volte ao inicio</a>";
?>