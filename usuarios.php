<?php
    include("cabecalho.php");
    //form ADMIN
    echo"
        <form action='' method='post'>
        <h2><label for=''>Usuários Ecommerce</label></h2>

        <button type='submit'>Mostrar usuários</button>
        </form>";

        //se for admin, imprimi os botoes de excluir e alterar

        if($_POST){
            $conn = conecta();
            if(!$conn){

                exit; //se nn conectar, sai
            }
            
            $varSQL = "SELECT * FROM usuario WHERE excluido = false";//tabela para a presentar os usuários
            
            $select = $conn->prepare($varSQL);
            $select->execute(); //executa sql e seleciona o que é pedido
            
            echo"<table border=1>";
                echo"<tr>
                        <td>Usuário</td>
                        <td>Nome</td>
                        <td>Email</td>
                        <td>Senha</td>
                        <td>Telefone</td>
                        <td>Admin</td>
                     </tr>";
            while($linha = $select->fetch()){
                echo"<tr>";

                $varFoto = "imagens/u".$linha['id_usuario'].".jpg";//puxa a imagem da pasta imagem, referente ao id
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
                    if($linha["admin"] = "true"){
                        echo"Sim";
                    }
                    else{
                        echo"Não.";
                    }
                echo "</td>";

                if($_POST){
                    echo "<td>";
                        echo "<a href= 'editar_usuario.php?id=".$linha['id_usuario']."'>Alterar</a>";//acessa o arquivo "alterarUsuario.php" passando o id referente para a ação
                    echo "</td>";

                    echo "<td>";
                        echo "<a href= 'remover_usuario.php?id=".$linha['id_usuario']."'>Excluir</a>";//acessa o arquivo "alterarUsuario.php" passando o id referente para a ação
                    echo "</td>";
                }
                
                echo"</tr>";
            }
            echo"</table>";

            echo "<a href='./adicionar_usuario.php'>Adicionar</a>";//cria um link para o arquivo "adicionarUsuario.php" para a opção de criar outros usuarios para o banco de dados
        }
?>