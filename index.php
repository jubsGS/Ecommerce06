<html>
    <head>
        <link rel="stylesheet" href="index.css">
    </head>
<?php
    include("cabecalho.php");
    $conn = conecta();
    if(!$conn){

        exit; //se nn conectar, sai
    }
    else{
        echo"Conectado";
    }
    
    
    $varSQL = "SELECT * FROM produto WHERE excluido = false";//tabela para a presentar os usuários

    $select = $conn->prepare($varSQL);
    $select->execute(); //executa sql e seleciona o que é pedido     
    

    echo"<div class='produtos'>";
    while($linha = $select->fetch()){
        $id = $linha["id_produto"];
        $nome = $linha["nome"];
        $desc = $linha["descricao"];
        $valoruni = $linha["valor_unitario"];
        $excluido = $linha["excluido"];
        $dtExclusao = $linha["data_exclusao"];
        $qntdEstoque = $linha["qtde_estoque"];
        $aroma = $linha["aroma"];
        $varFoto = "imagens/p".$id.".jpg";//puxa a imagem da pasta imagem, referente ao id

        $htmlFoto = (file_exists($varFoto) ? "<img src='$varFoto' width=60>" : "<img src='imagens/iconSacola.webp' width=60>");
        $htmlCarrinho = "<a href='carrinho.php'><button>Adicionar ao carrinho</button></a>";
    
        echo"<div class='prod'>
                <center>
                    $htmlFoto<br>
                    <strong>$nome</strong><br>
                    Aroma: $aroma<br><br>
                    <i>R$ $valoruni</i><br>
                    $htmlCarrinho
                </center>
            </div>";
    }
    echo"</div>";
?>