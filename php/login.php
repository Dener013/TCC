<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>

</body>
</html>
<?php

include("conexao.php");
session_start();


// -------------------------Pegando Valores------------------------------------- //


$nick = $_POST['nick']; 

$senha = $_POST['senha'];


// -------------------------Fazendo Select------------------------------ //


$sqlPerfil = "select nm_nick, cd_senha, cd_usuario from tb_perfil where nm_nick = '$nick' and cd_senha = '$senha';";

$resultPerfil = $conexao->query($sqlPerfil);
		
	if($resultPerfil->num_rows>0) 
	{
		$sqlAtivado = "select * from tb_perfil where nm_nick = '$nick' and cd_senha = '$senha' and ic_confirmar = true;";

		$resultAtivado = $conexao->query($sqlAtivado);

		if ($resultAtivado->num_rows>0) {
			while($row = $resultAtivado->fetch_assoc())
			{
				$_SESSION['logado'] = true;

				$_SESSION['nick'] = $row["nm_nick"];

				$_SESSION['id'] = $row["cd_usuario"];

				$_SESSION['img'] = $row["img_usuario"];

				$conexao->close();	
					
				header("Location: ../home.php");

				break;
			}
		}
		else{
			echo '<script>alert("Conta Não Ativada");location.href="../confirmar.php"</script>';
		}
	}
	else{

		echo '<script>alert("Usuário não encontrado");location.href="../login.html"</script>';

		unset($_SESSION['nick']);

		unset($_SESSION['id']);

		unset($_SESSION['logado']);
		
		$conexao->close();

	}
	
?>