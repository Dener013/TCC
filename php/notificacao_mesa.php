<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body style="background-color: black; color: white;">

</body>
</html>
<?php 

session_start();
include('conexao.php');


// --------------------Pegando Valores------------------------- //


$meu = $_SESSION['id'];

$mesa = $_GET['mesa'];

$senha = $_GET['privado'];

if ($senha == 0) {

	$sqlVerificar = "select * from tb_not_mesa where cd_mesa = $mesa and cd_usuario = $meu and ic_notificacao = 1";

	$resultVerificar = $conexao->query($sqlVerificar);

	if ($resultVerificar->num_rows>0) {
		echo "<script>location.href='../procurar-mesa.php'; alert('Mensagem já enviada!')</script>";
	}else{
		$sqlNotificacao = "INSERT INTO tb_not_mesa (cd_mesa, cd_usuario, ic_notificacao) values ($mesa, $meu, true)";

		$sqlQt = "select * from tb_mesa where cd_mesa = $mesa";

		$resultQt = $conexao->query($sqlQt);

		while ($row = $resultQt->fetch_assoc()) {
			$qt = $row['qt_usuario'];
			$qt = $qt + 1;
		}

		$sqlQt2 = "UPDATE tb_mesa set qt_usuario = $qt where cd_mesa = $mesa";
		$conexao->query($sqlQt2);

		if ($conexao->query($sqlNotificacao) === true) {
			echo "<script>alert('Você entrou na mesa!');location.href='../procurar-mesa.php'; </script>";
		}
	}

}else{

	$sqlVerificar = "select * from tb_not_mesa where cd_mesa = $mesa and cd_usuario = $meu and ic_notificacao = 0";

	$resultVerificar = $conexao->query($sqlVerificar);

	if ($resultVerificar->num_rows>0) {
		echo "<script> alert('Mensagem já enviada!');location.href='../procurar-mesa.php';</script>";
	}else{

		$sqlNotificacao2 = "INSERT INTO tb_not_mesa (cd_mesa, cd_usuario, ic_notificacao) values ($mesa, $meu, false)";

		if ($conexao->query($sqlNotificacao2) === true) {
			echo "<script>alert('Mensagem enviada!');location.href='../procurar-mesa.php'; </script>";
		}
	}
}

?>