
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>



<?php

include('conexao.php');


$meuid = $_GET['meuid'];

$cdmesa = $_GET['cdmesa'];

$sqlFundo = "select * from tb_perfil where cd_usuario = $meuid";
$resultFundo = $conexao->query($sqlFundo);

while ($row = $resultFundo->fetch_assoc()) {
  $imgFundo = $row['img_fundo'];
}

$sqlSelect = "select * from tb_chat_mesa where cd_mesa = $cdmesa";
$resultSelect = $conexao->query($sqlSelect);


$sqlMesa = "select * from tb_not_mesa where cd_usuario = $meuid and ic_notificacao = 1";
$resultMesa = $conexao->query($sqlMesa);
$resultMesa2 = $conexao->query($sqlMesa);

$sqlI = "select * from tb_not_mesa where cd_mesa = $cdmesa and ic_notificacao = true";
$resultInte = $conexao->query($sqlI);

while ($row = $resultInte->fetch_assoc()) {
  $cduser = $row['cd_usuario'];

  $sqlNicks = "select * from tb_perfil where cd_usuario = $cduser";
  $resultNicks = $conexao->query($sqlNicks);
  while ($row = $resultNicks->fetch_assoc()) {
    $arrIntegrantes[$row['cd_usuario']] = $row['nm_nick'];  
  }
}

while ($row = $resultMesa2->fetch_assoc()) {

  $cdmesaa = $row['cd_mesa'];

  $sqlInfoMesa = "select * from tb_mesa where cd_mesa = $cdmesa";

  $resultInfoMesa = $conexao->query($sqlInfoMesa);

  while ($row = $resultInfoMesa->fetch_assoc()) {
    $nomeMesa = $row['nm_mesa'];
    $cdadmin = $row['cd_admin'];
    $idmesa = $row['cd_mesa'];
  }
}
?>
    <div id='cabecalho-chat'>
      <div id='img-mesa-chat'>
          <img <?php echo "src='perfil/$imgFundo'" ?>>
      </div>
      <div id='info-eu'>

        <h1><?php echo "$nomeMesa"; ?></h1>
        <div id='online'>
          <h5>
            <?php

            foreach ($arrIntegrantes as $value => $name) {
         echo "{$name}, ";}

            ?>
          </h5>
        </div>
      </div>
      <div id='componentes'>
        <div class='glyphicon glyphicon-paperclip' id='arquivo'><input type='file' class='file_upload' id="btn-arquivo" /></div>
<?php if ($cdadmin == $meuid) { ?>
            <div class='dropdown' class='glyphicon glyphicon-option-vertical' id='config'>
              <button class='glyphicon glyphicon-option-vertical' type='button' data-toggle='dropdown' id='btn-config'></button>
              <ul class='dropdown-menu' id='drop'>
                <li><a data-toggle="modal" <?php echo "data-target='#$cdmesa'" ?> >Excluir Mesa</a></li>
              </ul>
            </div>

     
    </div>
    </div>

 
<?php }else{
?>
            <div class='dropdown' class='glyphicon glyphicon-option-vertical' id='config'>
              <button class='glyphicon glyphicon-option-vertical' type='button' data-toggle='dropdown' id='btn-config'></button>
              <ul class='dropdown-menu' id='drop'>
                <li><a data-toggle="modal" <?php echo "data-target='#$cdmesa'" ?> >Sair da Mesa</a></li>
              </ul>
            </div>

  
    </div>
    </div>
<?php
} ?>
      

<div id="mensagem-chat" style="background-image: url('img/fundo-chat.jpg');">
      <div id="msg-chat">

<?php
while ($row = $resultSelect->fetch_assoc()) {
	$mensagem = $row['ds_mensagem'];
	$hora = $row['dt_hora'];
	$mandante = $row['cd_de'];

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

echo "</div>
	</div>";

echo "<div id='enviar-chat'>
      <div class='input-group' id='input-enviar'>
          <input id='enviar-msg' type='text' class='form-control' placeholder='Escreva um mensagem' name='search'>
          <div class='input-group-btn'>
            <button id='btn-enviar2' class='btn btn-default' type='submit' onclick='enviarChatMesa($meuid, $cdmesa)'>
              <i class='glyphicon glyphicon-arrow-right' id='foto' ></i>
            </button>
          </div>
      </div>
    </div>";


?>


</body>
</html>