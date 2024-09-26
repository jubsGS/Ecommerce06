<?php
  include("cabecalho.php");
  $conn = conecta();
  $id_compra = $_GET['id_compra'];
  $voucher = $_POST['voucher'];
  $voucher2 = $_POST['voucher2'];
  $desconto = isset($_POST['desconto']) ? -$_POST['desconto'] : 0;

  function validarVouchers($voucher, $voucher2) {
      return $voucher === $voucher2;
  }

  function atualizarCompra($conn, $id_compra, $status, $desconto, $voucher) {
      $sql = "UPDATE compra SET status = :status, acrescimo_total = :acrescimo_total, id_transacao = :id_transacao WHERE id_compra = :id_compra";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':acrescimo_total', $desconto);
      $stmt->bindParam(':id_transacao', $voucher);
      $stmt->bindParam(':id_compra', $id_compra);
      $stmt->execute();
  }

  if (validarVouchers($voucher, $voucher2)) {
      $status = 'Concluida';
      atualizarCompra($conn, $id_compra, $status, $desconto, $voucher);

      echo "<h1>Compra realizada com sucesso</h1><br>";
      echo "<a href='logout.php'>Finalizar sessão</a>";
  } else {
      echo "<h1>Vouchers diferentes, digite o mesmo voucher</h1><br>";
      echo "<a href='carrinho.php?operacao=Fechar'>Voltar</a>";
  }
?>