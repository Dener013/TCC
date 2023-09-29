<?php 

include('conexao.php');

$ideu = $_GET['meuid'];

$icone = $_GET['icone'];

$sqlUpdate = "update tb_perfil set img_usuario = '$icone.png', img_fundo = '$icone-fundo.jpg' where cd_usuario = $ideu";

if ($conexao->query($sqlUpdate) === true) {

	$sqlMinhasInfo = "select *, date_format(curdate(), '%Y')-date_format(dt_nascimento, '%Y') as idade from tb_perfil where cd_usuario = $ideu;";

    $resultMinhasInfo = $conexao->query($sqlMinhasInfo);

    $sqlMinhasMesas = "select * from tb_mesa where cd_admin = '$ideu';";

    $resultMinhasMesas = $conexao->query($sqlMinhasMesas);

    while ($row = $resultMinhasInfo->fetch_assoc()) {

      $nomeuser = $row['nm_usuario'];

      $nickuser = $row['nm_nick'];

      $idadeuser = $row['idade'];

      $biouser = $row['ds_bio'];

      $imguser = $row['img_usuario'];

      $background = $row['img_fundo'];
      
    }

	echo " <div class='personal-image' style='background-image: url(perfil/$background);' id='icone-box' >
           <label class='label'>
           <figure class='personal-figure' data-toggle='collapse' data-target='#icones'>
           <img src='perfil/$imguser' class='personal-avatar' alt='avatar'>
           </figure>
          </div>";
}else{
	echo "erro ".$conexao->error;
}

?>