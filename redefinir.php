<?php
  
  include("cabecalho.php");

  echo "<h3>Redefinir a senha</h3>
        <form action='' method='post'>  
             Senha<br>
             <input type='password' name='senha1'><br>

             Redigite a senha<br>
             <input type='password' name='senha2'><br>  
               
             <input type='submit' value='Alterar'>
        </form>";

  if ( $_POST ) {  

       $conn = conecta();

       $senha1 = $_POST['senha1'];
       $senha2 = $_POST['senha2'];
       
       $token = $_GET['token'];
       
       $email = $_SESSION[$token];

       $senha = ValorSQL($conn, "select senha from usuario where email='$email'");     
       
       if ( md5 ($senha) <> $token ) {
            echo "<br>Token invalido !!";
            exit;
       }

       if ( $senha1 == $senha2 ) {
            ExecutaSQL($conn, "update usuario set senha='$senha1' where email='$email'");
            echo "<br>Senha alterada com sucesso !!";
       } else {
            echo "<br>Senhas estão diferentes";
       }
       echo "<br><br><a href='index.php'>Voltar</a>";
  }
?>  