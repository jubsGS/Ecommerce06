<?php
    function conecta($params="")//passa parametro
    {
        if ($params==""){
            $params="pgsql:host=pgsql.projetoscti.com.br;
            dbname=projetoscti6; user=projetoscti6; password=eq52A268";//estabelece conexão com o banco de daos
        }

        $varConn= new PDO($params);
        if(!$varConn){//se estiver vazio, nn funciona e informa que não foi conectado
            echo"Não foi possível conectar.";
        } else{ 
            return $varConn; //ao contrario, retorna a conexao
        }
    }

    function ValidaLogin($paramLogin, $paramSenha, &$paramAdmin){
        $conn=conecta();
        $varsql="SELECT senha, admin from usuario
                where email=:paramLogin";
        $select=$conn->prepare($varsql);
        $select->bindParam(':paramLogin', $paramLogin);
        $select->execute();
        $linha=$select->fetch();

        if($linha){
            $paramAdmin=$linha['admin'];
            return $linha['senha']==$paramSenha;
        } else{
            $paramAdmin=false;
            return false;
        }
    }
?>
