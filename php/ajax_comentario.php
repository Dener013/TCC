<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>

<?php

include("conexao.php");
session_start();

// ---------------Pegando valores--------------------- //

$ideu = $_GET['meuid'];

$meunick = $_SESSION['nick'];

$iddele = $_GET['iddele'];

$comentario = $_GET['comentario'];

$estrela = $_GET['estrela'];

$xpGanho = $estrela * 10;


// ---------------fazendo insert--------------------- //


$sqlComentario = "INSERT INTO tb_feedback (cd_para, cd_de, nm_nick, ds_feedback, dt_feedback) values 
($iddele, $ideu, '$meunick', '$comentario', (select CURDATE()))";

$conexao->query($sqlComentario);


// -------------------------Atualizando XP----------------------------- //

$sqlXpAntigo = "select * from tb_perfil where cd_usuario = $iddele";

$resultXpAntigo = $conexao->query($sqlXpAntigo);

while ($row = $resultXpAntigo->fetch_assoc()) {
  $xpAntigo = $row['qt_xp'];
}

$xpNovo = $xpAntigo + $xpGanho;

$sqlXpNovo = "UPDATE tb_perfil SET qt_xp = $xpNovo WHERE cd_usuario = $iddele";

$conexao->query($sqlXpNovo);



// echo "<script>location.href='../configuracoes.php?perfil=$iddele'</script>";


  $sqlComentario = "select p.* ,f.*, date_format(f.dt_feedback, '%d-%m-%Y') as 'dt_feedback' from tb_feedback as f join tb_perfil as p on f.cd_de = p.cd_usuario where cd_para = $iddele";

  $resultComentario = $conexao->query($sqlComentario);  

?>




 <div  class="container-fluid bg-3 text-left" id="feedback">
    <h2>Comentários</h2>
    <hr>
<?php
if ($iddele != null) {

  if ($resultComentario->num_rows>0) {

    while ($row = $resultComentario->fetch_assoc()) {

      $idcomentario = $row['cd_comentario'];

      $nickautor = $row['nm_nick'];

      $comentario = $row['ds_feedback'];

      $data = $row['dt_feedback'];

      $imgUser = $row['img_usuario'];

     if ($nickautor == $meunick) {

        echo "<div class='media' id='comentario'>
        <div class='media-left media-top'>
          <img src='perfil/$imgUser' class='media-object' id='img-comentario'>
        </div>
        <div class='media-body' id='comen-info'>

       <div class='dropdown' id='div-btn-op'>
            <button  id='btn-op' style='background-color: transparent;' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'><span class='glyphicon'>&#xe234;</span></button>
            <ul class='dropdown-menu' id='menu-drop'>
              <li><p id='btn-editar'>Editar</p></li>
              <li onclick='excluirComentario($idcomentario, $iddele)'><p id='btn-excluir'>Excluir</p></li>
            </ul>
          </div>

          <h3 class='media-heading'><strong>$nickautor</strong></h3>
          <h4>$comentario</h4>
          <p>$data</p>
        </div>
      </div>";

      }else{

        echo "<div class='media' id='comentario'>
        <div class='media-left media-top'>
          <img src='perfil/$imgUser' class='media-object' id='img-comentario'>
        </div>
        <div class='media-body' id='comen-info'>
          <h3 class='media-heading'><strong>$nickautor</strong></h3>
          <h4>$comentario</h4>
          <p>$data</p>
        </div>
      </div>";

      }


    }
  }
  else{
    echo "<h2>Nenhum Comentário1</h2>";
  }
  
}else{

  if ($resultComentario->num_rows>0) {

    while ($row = $resultComentario->fetch_assoc()) {

      $nickautor = $row['nm_nick'];

      $comentario = $row['ds_feedback'];

      $data = $row['dt_feedback'];

      echo "<div class='media' id='comentario'>
        <div class='media-left media-top'>
          <img src='img/Dener.jpg' class='media-object' id='img-comentario'>
        </div>
        <div class='media-body' id='comen-info'>
          <h3 class='media-heading'><strong>$nickautor</strong></h3>
          <h4>$comentario</h4>
          <p>$data</p>
        </div>
      </div>";

    }
  }
  else{
    echo "<h1>Nenhum Comentário2</h1>";
  }
  
}
?>


<!-- ---------Input de comentario----------- -->

<?php
if ($iddele != null) {
 echo "<div class='media' id='comentario'>
      <!-- <div class='media-left media-top'>
        <img src='img_avatar1.png' class='media-object' style='width:60px'>
      </div> -->
      <div class='media-body'>
        <h4 class='media-heading' id='fazer'>Fazer um Comentário</h4>
        <div class='estrelas'>
            <input type='radio' id='cm_star-empty' name='fb' value='' checked/>
            <label for='cm_star-1'><i class='fa'></i></label>
            <input type='radio' id='cm_star-1' name='fb' value='1'/>
            <label for='cm_star-2'><i class='fa'></i></label>
            <input type='radio' id='cm_star-2' name='fb' value='2'/>
            <label for='cm_star-3'><i class='fa'></i></label>
            <input type='radio' id='cm_star-3' name='fb' value='3'/>
            <label for='cm_star-4'><i class='fa'></i></label>
            <input type='radio' id='cm_star-4' name='fb' value='4'/>
            <label for='cm_star-5'><i class='fa'></i></label>
            <input type='radio' id='cm_star-5' name='fb' value='5'/>
          </div>
        <div class='input-group'>
          <input type='text' class='form-control' placeholder='Comentário' name='comentario' id='txt-comen'>
          <div class='input-group-btn'>
            <button class='btn btn-default' type='submit' onclick='fazerComentario($ideu, $iddele)'>Enviar</button>
          </div>
        </div>
      </div>
    </div>";
}
?>
  </div>

</body>
</html>