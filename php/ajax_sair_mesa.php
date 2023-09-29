<?php session_start();
include('conexao.php');

$nick = $_SESSION['nick'];
$ideu = $_SESSION['id'];

$mesa = $_GET['mesa'];



$sqlDeletar4 = "delete from tb_not_mesa where cd_mesa = $mesa and cd_usuario = $ideu";
$conexao->query($sqlDeletar4);

echo "<script>location.href='amigos.php'</script>";

?>