<?php

  include("cabecalho.php");

  echo "<form action='' method='post'>
          Enviar recuperacao da senha para:<br>
          <input type='email' name='email'>
          <input type='submit' value='Enviar'>
        </form>";

  if ( $_POST ) {   
      $conn = conecta();
      $email = $_POST['email'];
      $select = $conn->prepare("select nome,senha from usuario where email=:email ");
      $select->bindParam(':email',$email);
      $select->execute();
      $linha = $select->fetch();
      
      if ( $linha ) {
        $token=md5($linha['senha']); 
        $nome = $linha['nome'];
        $html="<h4>Redefinir sua senha</h4><br>
               <b>$nome</b>, <br>
               Clique no link para redefinir sua senha:<br>https://https://projetoscti.com.br/projetoscti08/ecommerce/redefinir.php?token=$token";
        
        $_SESSION[$token]= $email;

        if ( EnviaEmail ( $email, '* Recupere a sua senha do ecommerce *', $html ) ) {
              echo "<b>Email enviado com sucesso</b> (verifique sua caixa de spam se nao encontrar)";
        }   
      } 
  }
 
?>