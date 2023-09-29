<!DOCTYPE html>
<html>
<head lang="pt-br">
	<title></title>
	<meta charset="utf-8">
</head>
<body>

<?php

include("conexao.php");

$codigo = $_POST['codigo'];

$nick = $_POST['nick'];


// -------------------Pesquisar e ativar conta------------------- //


$sqlPerfil = "select * from tb_perfil where nm_nick = '$nick' and cd_confirmar = '$codigo';";

$resultPerfil = $conexao->query($sqlPerfil);

if ($resultPerfil->num_rows > 0) {
	$sqlUpdate = "update tb_perfil set ic_confirmar = true where cd_confirmar = '$codigo' and nm_nick = '$nick'";

	if ($conexao->query($sqlUpdate) === true) {
		echo "<script>alert('Conta Ativada');location.href='../login.html'</script>";
	}
	else{
		echo "<script>alert('Nick ou Código inválido');location.href='../confirmar.php'</script>";
	}
}



?>

</body>
</html>