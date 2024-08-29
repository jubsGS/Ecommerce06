<?php
    include("cabecalho.php");

    $conn = conecta();//conexao

    $id = $_GET['id'];//recebe o parametro

    $sql = "UPDATE produto SET excluido = true, data_exclusao=CURRENT_DATE WHERE id_produto = :id";//atualiza a tabela, muda excluido para "true", altera a data de exclusao para "CURRENT_DATE"(data atual). Tudo isso onde o id_produto for igual ao id recebido
    $stm = $conn->prepare($sql); //comunicação com o banco
    $stm->bindParam(":id", $id);

    if($stm->execute()){//confirmação de exclusao
        echo"Produto marcado como excluído!";
    }
    else{
        echo"Erro, tente novamente!";
    }

    echo "<br><br><a href='produtos.php'>Volte ao inicio</a>";
?>