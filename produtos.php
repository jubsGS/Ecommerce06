<?php
    include("cabecalho.php");
    //formulario para passar o nome de um produto que deseja filtrar no banco de dados
    echo "
        <form action='' method='post' enctype='multipart/form-data'>
        <h2><label for=''>Produtos Ecommerce</label></h2>

        <label for='nome'>Nome:</label>
        <input type='text' name='nome'><br><br>

        <button type='submit'>Enviar dados</button>
        </form>";

    $conn = conecta();//conexao

    if($_POST){
        $filtro='%'.$_POST['nome'].'%';//prepara o formato do filtro, dentro do if diz que deve procurar qualquer coisa que tenha o valor passado no INICIO ou MEIO do nome cadastrado
    }else{
        $filtro="%%";//se nn, basta selecionar td
    }

    $sql="SELECT * from produto  where (nome like :filtro) ";//instrução para chamar no banco de dados tudo oq estiver no produto que tenha o valor no nome
    

    $select = $conn->prepare($sql);//preparação da instrução
    $select->bindParam(':filtro', $filtro);//validação de parametro
    $select->execute();//execução da instrução sql

    echo "<table border=1>";//criação da tabela
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
        
    while ($linha = $select->fetch()) {
        
        $varFoto="imagens/p".$linha['id_produto'].".jpg";
        echo "<td>";
        if(file_exists($varFoto)){//se existir, chama
            echo "<img src='$varFoto' width=80>";
        }else{//ao contrario, mostra um icone sem que seja aquele de arquivo corrompido
            echo "<img src='imagens/iconSacola.webp' width=80>";
        }
        echo "</td>";

        echo "<td>";
        echo $linha["nome"];
        echo "</td>";

        echo "<td>";
        echo $linha["descricao"];
        echo "</td>";

        echo "<td>";
        echo $linha["valor_unitario"];
        echo "</td>";

        echo "<td>";
        if($linha["excluido"]==false){//verifica se o produto esta inserido ou nn na tabela
            echo "não";
        }
        else{
            echo "sim";
        }
        echo "</td>";

        if($linha["excluido"]==false){//verifica se o produto esta inserido ou nn na tabela, se sim, vai adicionar a data em que foi excluido
            echo "<td>";
            echo "...";
            echo "</td>";
        }
        else{
            echo "<td>";
            echo $linha["data_exclusao"];
            echo "</td>";
        }

        echo "<td>";
        echo $linha["qtde_estoque"];
        echo "</td>";

        echo "<td>";
        echo $linha["aroma"];
        echo "</td>";

        echo "<td>";
        echo "<a href='editar_produto.php?id=".$linha['id_produto']."'>Alterar</a>";
        echo "</td>";

        echo "<td>";
        echo "<a href='remover_produto.php?id=".$linha['id_produto']."'>Excluir</a>";
        echo "</td>";

        echo "</tr>";
    }
    echo "</table>";

    echo "<a href='./adicionar_produto.php'>Adicionar</a>";
?>