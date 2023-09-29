
<?php

include('conexao.php');


$meuid = $_GET['eu'];

$mesa = $_GET['mesa'];

$msg = $_GET['mensagem'];

$sqlInsert = "INSERT INTO tb_chat_mesa (cd_de, cd_mesa, ds_mensagem, dt_mensagem, dt_hora, ds_anexo) values ($meuid, $mesa, '$msg', (select CURDATE()), (SELECT TIME_FORMAT(CURTIME(), '%H:%i')), null)";

if ($conexao->query($sqlInsert) === true){

}else{
	echo "erro =".$conexao->error;;
}


$sqlSelect = "select *, date_format(dt_mensagem, '%d-%m-%Y') as dt_mensagem from tb_chat_mesa where cd_mesa = $mesa";

$resultSelect = $conexao->query($sqlSelect);

echo "<div id='msg-chat'>";

while ($row = $resultSelect->fetch_assoc()) {
	$mensagem = $row['ds_mensagem'];
	$mandante = $row['cd_de'];
	$hora = $row['dt_hora'];

   $sqlNickMensagem = "select * from tb_perfil where cd_usuario = $mandante";
  $resultNickMensagem = $conexao->query($sqlNickMensagem);

  while ($row = $resultNickMensagem->fetch_assoc()) {
    $nickck = $row['nm_nick'];
  }

	if ($mensagem != null) {
		if ($mandante == $meuid) {
			echo "<div id='msg-eu'>
          <div id='msg'>
            $mensagem
          </div>
          <div id='hora'>
            $hora
          </div>
        </div>";

		}else{

			echo "<div id='msg-amigo'>
          <div id='msg'>
          <div style='color: brown;'>
            $nickck
          </div> 
          <br>
            $mensagem
          </div>
          <div id='hora'>
            $hora
          </div>
        </div>";

		}
	}		
}

echo "</div>";

?>


