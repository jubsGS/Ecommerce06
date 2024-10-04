<?php
    include("cabecalho.php");
    $conn = conecta();
    $id_compra = $_GET['id_compra'];
    $id_transacao = null;
    $desconto = 0;

    function atualizarCompra($conn, $id_compra, $status, $desconto, $id_transacao) {
        $sql = "UPDATE compra SET status = :status, acrescimo_total = :acrescimo_total, id_transacao = :id_transacao WHERE id_compra = :id_compra";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':acrescimo_total', $desconto);
        $stmt->bindParam(':id_transacao', $id_transacao);
        $stmt->bindParam(':id_compra', $id_compra);
        $stmt->execute();
    }


    $status = 'Concluida';
    atualizarCompra($conn, $id_compra, $status, $desconto, $id_transacao);

    echo "<h1>Compra realizada com sucesso</h1><br>";
    echo "<a href='logout.php'>Finalizar sessão</a>";
  
?>