<?php session_start();
include('conexao.php');

$nick = $_SESSION['nick'];
$ideu = $_SESSION['id'];

$mesa = $_GET['mesa'];


$sqlDeletar = "delete from tb_omp where cd_mesa = $mesa";
$conexao->query($sqlDeletar);
$sqlDeletar2 = "delete from tb_chat_mesa where cd_mesa = $mesa";
$conexao->query($sqlDeletar2);
$sqlDeletar4 = "delete from tb_not_mesa where cd_mesa = $mesa";
$conexao->query($sqlDeletar4);
$sqlDeletar3 = "delete from tb_mesa where cd_mesa = $mesa";
$conexao->query($sqlDeletar3);

echo "<script>location.href='amigos.php'</script>";

?>