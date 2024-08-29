<?php
    include("cabecalho.php");
    $conn = conecta();//conexao com a tabela

    $id = $_GET['id'];//recebe o id do item a ser excluido

    $sql = "UPTADE usuario SET excluido = true, data_exclusao = CURRENT_DATE WHERE id_usuario = :id";//DELETA da tabela usuario o id que for correspondente ao parametro passado
    $stm = $conn->prepare($sql); //comunicação com o banco
    $stm->bindParam(":id", $id);//passa o valor

    if($stm->execute()){
        echo"Produto marcado como excluído!";
    }
    else{
        echo"Erro, tente novamente!";
    }
    
    echo "<br><br><a href='usuarios.php'>Volte ao inicio</a>";
?>