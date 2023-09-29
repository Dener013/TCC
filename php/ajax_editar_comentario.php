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


$ideu = $_SESSION['id'];


$iddele = $_GET['iddele'];


$idcomentario = $_GET['idcomentario'];


$newcomen = $_GET['newcomen'];


// ---------------fazendo insert--------------------- //


$sqlComentario = "UPDATE tb_feedback set ds_feedback = '$newcomen' WHERE cd_comentario = $idcomentario";

$conexao->query($sqlComentario);

  $sqlComentario = "select *, date_format(dt_feedback, '%d-%m-%Y') as 'dt_feedback' from tb_feedback where cd_para = $iddele";

  $resultComentario = $conexao->query($sqlComentario);  

?>




 <div  class="container-fluid bg-3 text-left" id="feedback">
    <h2>Comentários</h2>
    <hr>
<?php
if ($iddele != null) {

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
        <br>
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