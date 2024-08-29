<?php
    include("cabecalho.php");

    $conn = conecta();

    $id = $_GET['id'];

    $varSQL = "SELECT * FROM usuario WHERE id_usuario = :id";//seleciona tudo da tabela usuario onde o id for igual ao parametro recebido

    $select = $conn->prepare($varSQL);
    $select->bindParam(':id', $id);
    $select->execute();
    $linha = $select->fetch();//seleciona todas as linhas

    //atribui os valores das linhas de cada coluna na variavel com nome respectivo
    $nome = $linha['nome'];
    $email = $linha['email'];
    $senha = $linha['senha'];
    $telefone = $linha['telefone'];
    $admin = $linha['admin'];

    $adminOpcao1 = ($admin=='S'?' selected ':'');
    $adminOpcao2 = ($admin=='N'?' selected ':'');

    echo"<h1>Visualicação atual</h1>
            <table border=1>
                <tr>
                    <td>Usuário</td>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>Senha</td>
                    <td>Telefone</td>
                    <td>Admin</td>
                </tr>";
            echo"<tr>";

            $varFoto = "imagens/p".$linha['id_usuario'].".jpg";//puxa a imagem da pasta imagem, referente ao id
            echo"<td>";
                if(file_exists($varFoto)){
                    echo"<img src='$varFoto' width=80>";//se existe, puxa a foto
                }
                else{
                    echo"<img src='imagens/iconUsuario.png' width=80>";//caso contrario, para que nn apareça um icone de arquivo corrompido, cham-se um melhor
                }
            echo "</td>";

            echo "<td>";
                echo $linha["nome"];
            echo "</td>";

            echo "<td>";
                echo $linha["email"];
            echo "</td>";

            echo "<td>";
                echo $linha["senha"];
            echo "</td>";

            echo "<td>";
                echo $linha["telefone"];
            echo "</td>";

            echo "<td>";
                if($linha["admin"] = 1){
                    echo"Sim";
                }
                else{
                    echo"Não.";
                }
            echo "</td></tr></table>";

    
    echo "
    <form action='' method='post' enctype='multipart/form-data'> 
    <h2><label for=''>Alterar Usuário</label></h2>

    <label for='nome'>Nome:</label>
    <input type='text' name='nome' value=$nome><br><br>

    <label for='email'>Email:</label>
    <input type='text' name='email' value=$email><br><br>

    <label for='senha'>Senha:</label>
    <input type='text' name='senha' value=$senha><br><br>

    <label for='telefone'>Telefone:</label>
    <input type='text' name='telefone' value=$telefone><br><br>

    <select name='admin'>
    <option value='true'>Sim, sou admin.</option>
    <option value='false'>Não, não sou admin.</option>
    </select><br>

    Selecione uma foto (*.jpg)<br>
    <input type='file' name='foto'><br><br>

    <button type='submit'>Enviar dados</button>
    </form>";

if ( $_POST ) { 
    $varSQL =//atualiza a tabela usuario, dando novos valores para as colunas: nome, emial, senha, telefone e admin, na linha do id igual ao parametro
        ' UPDATE usuario
          SET nome = :nome, email = :email,
          senha = :senha, telefone = :telefone, admin = :admin  
          WHERE id_usuario = :id';

    $update = $conn->prepare($varSQL);
    $update->bindParam(':nome', $_POST ['nome']);
    $update->bindParam(':email', $_POST ['email']);
    $update->bindParam(':senha', $_POST ['senha']);
    $update->bindParam(':telefone', $_POST ['telefone']);
    $update->bindParam(':admin', $_POST ['admin']);
    $update->bindParam(':id', $_POST['id_usuario']);
    
    var_dump($update->debugDumpParams());

    if($update->execute() > 0 )
    {
        echo"Alterado!!!";

        if($_FILES){//recebera e guardara a imagem na pasta imagens com nome "p + idDoArquivo + extensaoDoArquivo
            $varArqRecebido=$_FILES['foto']['tmp_name'];
            $varExtensaoPadrao='jpg';
            $varNovoArq="imagens/p$id.$varExtensaoPadrao";
            if(move_uploaded_file($varArqRecebido, $varNovoArq)){
                echo "<br><br>Arquivo de foto foi recebido e atuzalizado com sucesso!";
            }
        }
    }
    echo "<br><br><a href='usuarios.php'>Volte ao inicio</a>";
}

?>