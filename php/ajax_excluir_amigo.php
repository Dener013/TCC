<?php session_start();
include('conexao.php');

$nick = $_SESSION['nick'];
$ideu = $_SESSION['id'];

$amigo = $_GET['amigo'];


$sqlDeletar = "delete from tb_notificacao where cd_de = $ideu and cd_para = $amigo or cd_de = $amigo and cd_para = $ideu";
$conexao->query($sqlDeletar);
  
echo "<script>location.href='amigos.php'</script>"; 
?>