
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>



<?php

include('conexao.php');


$meuid = $_GET['meuid'];

$iddele = $_GET['iddele'];

$imgFundo = $_GET['img'];


$sqlSelect = "select *, date_format(dt_mensagem, '%d-%m-%Y') as dt_mensagem from tb_chat where cd_de = $meuid and cd_para = $iddele or cd_de = $iddele and cd_para = $meuid";

$resultSelect = $conexao->query($sqlSelect);



$sqlAmigo = "select * from tb_perfil where cd_usuario = $iddele";

$resultAmigo = $conexao->query($sqlAmigo);



while ($row = $resultAmigo->fetch_assoc()) {
	$nick = $row['nm_nick'];
	$nome = $row['nm_usuario'];
	$img = $row['img_usuario'];
}


echo "	<div id='cabecalho-chat'>
      <div id='img-usuario-chat'>
          <img src='perfil/$img'>
      </div>
      <div id='info-eu'>
        <h1><a id='nick-amigo' onclick='perfil($iddele)'>$nick</a></h1>
        <div id='online'>
          <h5>Offline</h5>
        </div>
      </div>
      <div id='componentes'>
        <div class='glyphicon glyphicon-paperclip' id='arquivo'><input type='file' class='file_upload' onchange='pegaNomeArquivo(this, $iddele, $meuid)' /></div>

        <div class='dropdown' class='glyphicon glyphicon-option-vertical' id='config'>
          <button class='glyphicon glyphicon-option-vertical' type='button' data-toggle='dropdown' id='btn-config'></button>
          <ul class='dropdown-menu' id='drop'>
            <li data-toggle='modal' data-target='#$nick'><a>Excluir Amigo</a></li>
          </ul>
        </div>
      </div>
    </div>";

?>
<div id="mensagem-chat" style="background-image: url(<?php echo "perfil/$imgFundo"; ?>);">
      <div id="msg-chat">

<?php
while ($row = $resultSelect->fetch_assoc()) {
	$mensagem = $row['ds_mensagem'];
	$hora = $row['dt_hora'];
	$mandante = $row['cd_de'];
	$remetente = $row['cd_para'];

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
            $mensagem
          </div>
          <div id='hora'>
            $hora
          </div>
        </div>";

		}
	}
		
}

echo "</div>
	</div>";

echo "<div id='enviar-chat'>
      <div class='input-group' id='input-enviar'>
          <input id='enviar-msg' type='text' class='form-control' placeholder='Escreva um mensagem' name='search'>
          <div class='input-group-btn'>
            <button id='btn-enviar2' class='btn btn-default' type='submit' onclick='enviar($meuid, $iddele)'>
              <i class='glyphicon glyphicon-arrow-right' id='foto' ></i>
            </button>
          </div>
      </div>
    </div>";


?>


</body>
</html>