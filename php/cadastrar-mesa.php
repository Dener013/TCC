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

	include('conexao.php');
	session_start();


// --------------------------Pegando os valores------------------------------ //

	$mesa = $_POST['mesa'];

	$sistema = $_POST['sistema'];

	$quantidade = $_POST['quantidade'];

	$privacidade = $_POST['collapseGroup'];

	$bairro = isset( $_POST[ 'bairro' ] ) ? $_POST[ 'bairro' ] : null ;

	$cidade = isset( $_POST[ 'cidade' ] ) ? $_POST[ 'cidade' ] : null ;

	if ($bairro == null && $cidade == null) {
		echo '<script>location.href="../criar-mesa.php";alert("Selecione um cidade e/ou um bairro!");</script>';
	}

	if ($bairro == null) {

		$cidade = $_POST['cidade'];
		$bairro = "null";

	}else{

		$cidade = "null";

	}

	if ($privacidade == 1) {

		$senha = "null";

	}else{

		$senha = "null";
	}

	$admin = $_SESSION['nick'];

	$iduser = $_SESSION['id'];

	

// --------------------------INSERTS e Verificações----------------------------- //


	$sqlNomeMesa = "select * from tb_mesa where nm_mesa = '$mesa'";

	$resultNomeMesa = $conexao->query($sqlNomeMesa);

	if ($resultNomeMesa->num_rows>0) {

		echo '<script>location.href="../criar-mesa.php";alert("Mesa com esse nome já existe!");</script>';
		
	}else{

		$sqlCdMesa = "select max(cd_mesa) + 1 as cd_mesa from tb_mesa;";

		$resultCdMesa = $conexao->query($sqlCdMesa);

		if ($resultCdMesa->num_rows>0) {

			while($row = $resultCdMesa->fetch_assoc())
			{
				$cd1 = $row['cd_mesa'];
			}

			$sqlmesa = "INSERT INTO `tb_mesa`(`cd_mesa`, `nm_mesa`, `nm_sistema`, `qt_usuario`, `qt_limite`, `dt_criacao`, `ic_privado`, `cd_senha`, `img_mesa`, `cd_bairro`, `cd_cidade`, `cd_admin`) VALUES ($cd1, '$mesa', '$sistema', 1, $quantidade, (select CURDATE()), $privacidade, $senha, null, $bairro, $cidade, $iduser)";

			if ($conexao->query($sqlmesa)) {

				$sqlomp = "INSERT INTO tb_omp (cd_mesa, cd_usuario) values ($cd1, $iduser);";
				$sqlnot = "INSERT INTO tb_not_mesa (cd_mesa, cd_usuario, ic_notificacao) values ($cd1, $iduser, true);";
				$conexao->query($sqlnot);

			    if($conexao->query($sqlomp) === TRUE){

		    	    echo '<script>location.href="../criar-mesa.php";alert("Cadastrado com sucesso!");</script>';
		    	    $conexao->close();

		    	}else{

		        	echo '<script>alert("Erro ao cadastrar!");</script>';
		    	}
			}else{
			}
		}
	}
?>