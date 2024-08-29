<?php
    include("cabecalho.php");

    echo"
    <form action='' method='post' enctype='multipart/form-data'> 
    <h2><label for=''>Cadastro Usuário</label></h2>

    <label for='nome'>Nome:</label>
    <input type='text' name='nome'><br><br>

    <label for='email'>Email:</label>
    <input type='text' name='email'><br><br>

    <label for='senha'>Senha:</label>
    <input type='text' name='senha'><br><br>

    <label for='telefone'>Telefone:</label>
    <input type='text' name='telefone'><br><br>

    <select name='admin'>
    <option value='true'>Sim, sou admin.</option>
    <option value='false'>Não, não sou admin.</option>
    </select><br>

    Selecione uma foto (*.jpg)<br>
    <input type='file' name='foto'><br><br>

    <button type='submit'>Enviar dados</button>
    </form>";

    if($_POST){
        $conn=conecta();
        //insere os valores do formulario em suas respectivas colunas
        $varSQL="INSERT INTO usuario (nome, email, senha, telefone, admin, excluido)
                VALUES (:nome,  :email, :senha, :telefone, :admin, false)";
        
        $insert= $conn->prepare($varSQL);

        $insert->bindParam(':nome', $_POST["nome"]);
        $insert->bindParam(':email', $_POST["email"]);
        $insert->bindParam(':senha', $_POST["senha"]);
        $insert->bindParam(':telefone', $_POST["telefone"]);
        $insert->bindParam(':admin', $_POST["admin"]);
        
        if($insert->execute()>0){
            echo "<br><br>Incluído com sucesso";

            if($_FILES){
                $id=$conn->lastInsertId();
                $varArqRecebido=$_FILES['foto']['tmp_name'];
                $varExtensaoPadrao='jpg';
                $varNovoArq="imagens/u$id.$varExtensaoPadrao";
                if(move_uploaded_file($varArqRecebido, $varNovoArq)){
                    echo "<br><br>Arquivo de foto foi recebido com sucesso!";
                }
            }
        }
    }

    echo "<br><br><a href='usuarios.php'>Volte ao inicio</a>";
?>