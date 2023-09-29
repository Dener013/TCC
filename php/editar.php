<!DOCTYPE html>
<html>
<head lang="pt-br">
	<title></title>
	<meta charset="utf-8">
</head>
<body>

</body>
</html>

<?php 

session_start();
include("conexao.php");


// --------------------------Pegando Valores----------------------------------//


$bio = $_GET['outro'];

$novonick = $_GET['editar'];

$nick = $_SESSION['nick'];

$bairro = $_GET['bairro'];


// --------------------------Validando e Fazendo Inserts---------------------------- //


if ($novonick == $nick) {

	$atualizarBio = "UPDATE tb_perfil SET ds_bio = '$bio', cd_bairro = '$bairro' WHERE nm_nick = '$nick'";

	if($conexao->query($atualizarBio) === true)
	{

		echo "<script>location.href='../configuracoes.php'</script>";

	}
	else{

		echo "<script>alert('Não foi possível mudar sua história');location.href='../configuracoes.php'</script>";

	}

}else{
	
	$verificarNick = "select nm_nick from tb_perfil where nm_nick = '$novonick'";

	$resultNick = $conexao->query($verificarNick);

	if ($resultNick->num_rows>0) {

		echo "<script>alert('Nick já existe');location.href='../configuracoes.php'</script>";
	}
	else{

	$sql = "UPDATE tb_perfil SET nm_nick = '$novonick', ds_bio = '$bio', cd_bairro = '$bairro' WHERE nm_nick = '$nick'";

		if($conexao->query($sql) === true)
		{

			$_SESSION['nick'] = $novonick;
			echo "asdkasjdçlkj";

			echo "<script>alert('Parabéns pelo novo nome e pela história!');location.href='../configuracoes.php'</script>";

		}
		else{

			echo "<script>alert('Não foi possível mudar o nick e a bio');location.href='../configuracoes.php'</script>";
		}
	}
}

$conexao->close();

?>