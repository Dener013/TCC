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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


// -----------------------Pegando valores--------------------------- //


$nome = $_POST['txt-nome'];

$nick = $_POST['txt-nick'];

$data = $_POST['data'];

$email = $_POST['email'];

$senha = $_POST['senha'];

$icone = $_POST['icon'];

$termos = isset($_POST['termos']);

$mail = new PHPMailer();


// -----------------------Verificando, fazendo os inserts e enviando email de confirmação--------------------------- //

if ($termos == null) {

	echo "<script>alert('Você não concordou com os termos de uso!');location.href='../cadastrar.html'</script>";
}
else{

	$sqlnick = "select nm_nick from tb_perfil where nm_nick = '$nick';";

	$resultnick = $conexao->query($sqlnick);

	if ($resultnick->num_rows>0) {

		$conexao->close();
		echo '<script>location.href="../cadastrar.html";alert("Nick já existe!");</script>';

	}else{

		$sqlemail = "select nm_email from tb_perfil where nm_email = '$email';";

		$resultemail = $conexao->query($sqlemail);

		if ($resultemail->num_rows>0) {

			$conexao->close();
			echo '<script>location.href="../cadastrar.html";alert("Email já existe!");</script>';

		}else{

			$sqliduser = "select max(cd_usuario) + 1 as cd_perfil from tb_perfil;";

			$resultiduser = $conexao->query($sqliduser);

			if ($resultiduser->num_rows>0) {

				while($row = $resultiduser->fetch_assoc())
				{
					$iduser = $row['cd_perfil'];
				}
			}

			$sqlrank = "select max(cd_ranking) + 1 as cd_rank from tb_ranking;";

			$resultrank = $conexao->query($sqlrank);

			if ($resultrank->num_rows>0) {

				while($row = $resultrank->fetch_assoc())
				{
					$rank = $row['cd_rank'];
				}
			}

			$gerar_codigo = md5(uniqid(""));

			$limitar_codigo = strtoupper(substr($gerar_codigo, 0,7));
					
			$assunto = "Ativação de conta - Taverna do Peregrino";

			$msg = "Ola $nome. \n Muito obrigado por realizar o cadastro em nosso servidor, por segurança sua conta esta desativada, para ativar acesse o link e digite o código de ativação que se encontra logo abaixo: \n \n Código de ativação: $limitar_codigo \n \n  http://localhost:8080/TavernaDoPeregrino/confirmar.php \n \n \n Atenciosamente, \n A Taverna de Todos os Peregrinos. ";
					
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tsl';
			$mail->Username = 'tavernadoperegrino@gmail.com';
			$mail->Password = 'ddfjl123';
			$mail->Port = 587;

			$mail->setFrom('TavernaDoPeregrino@gmail.com', 'Taverna do Peregrino');
			$mail->addAddress($email, $nome);

			$mail->isHTML(true);

			$mail->Subject = utf8_decode($assunto);
			$mail->Body    = utf8_decode(nl2br($msg));

			if ($mail->send()) {

				$sqlinsertrank = "INSERT INTO tb_ranking (cd_ranking, img_ranking) VALUES ($rank, null);";

				if ($conexao->query($sqlinsertrank) === true) {

					$sql = "INSERT INTO tb_perfil (cd_usuario, nm_usuario, ds_bio, nm_nick,  cd_senha, dt_nascimento, nm_email, cd_bairro, cd_cidade, qt_xp, cd_ranking, ic_confirmar, img_usuario, img_fundo, cd_confirmar) VALUES ($iduser, '$nome', null, '$nick', '$senha', DATE('$data'), '$email', 1, null, 0, $rank, 0, '$icone.png', '$icone-fundo.jpg', '$limitar_codigo')";

					if($conexao->query($sql) === TRUE) {

						echo "<script>alert('Cadastrado com Sucesso!'); location.href='../confirmar.php';</script>";
						
					}else{

						echo "<br><br>Error: <br>".$conexao->error;
						$conexao->close();

					}
					
				}else{

					echo "<br><br>Error: ".$sql."<br>".$conexao->error;
					$conexao->close();

				}
				
			}
			else{
				echo 'Não foi possível enviar a mensagem.<br>';
			    echo 'Erro: ' . $mail->ErrorInfo;
			}

		}

	}
}

?>