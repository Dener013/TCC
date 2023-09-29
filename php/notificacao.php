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

$dele = $_GET['usuario'];

// -----------------------Verificando e fazendo Insert-------------------------------- //

$verificarSoli = "select cd_de from tb_notificacao where cd_de = $meu and cd_para = $dele";

$resultVerificacao = $conexao->query($verificarSoli);

if($resultVerificacao->num_rows>0) {

	echo '<script>alert("Já Enviado");location.href="../jogadores.php"</script>';

}else{


	$verificarSoli = "select * from tb_notificacao where cd_de = $dele and cd_para = $meu";
	
	$resultVerificacao = $conexao->query($verificarSoli);

	if ($resultVerificacao->num_rows>0) {
		echo '<script>alert("Verifique sua caixa de notificação, ele já lhe enviou um solicitação!");location.href="../jogadores.php"</script>';
	}
	else{

		$verificarSoli = "select * from tb_notificacao where cd_de = $dele and cd_para = $meu and ic_notificacao = true or cd_de = $meu and cd_para = $dele and ic_notificacao = true";
		
		$resultVerificacao = $conexao->query($verificarSoli);

		if ($resultVerificacao->num_rows>0) {
			echo '<script>alert("Vocês já são amigos!");location.href="../jogadores.php"</script>';
		}
		else{

			$sql = "INSERT INTO tb_notificacao(cd_de, cd_para, ic_notificacao) values ('$meu', '$dele', FALSE);";

			if($conexao->query($sql) === TRUE) 
			{
				echo '<script>alert("Solicitação enviada com sucesso!");location.href="../jogadores.php"</script>';
			}
			else
			{
				echo '<script>alert("Não foi possível enviar a solicitação!");location.href="../jogadores.php"</script>';
			}

		}

	}

}

?>