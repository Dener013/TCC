<?php

include("conexao.php");

$meuid = $_GET['meuid'];
$amigoid = $_GET['amigoid'];


$sql = "UPDATE tb_notificacao SET ic_notificacao = true WHERE cd_de = $amigoid and cd_para = $meuid;";
$conexao->query($sql);


$x = 0;

$notificacao = "select * from tb_notificacao where cd_para = $meuid and ic_notificacao = false;";

$resultNotificacao = $conexao->query($notificacao);
$pedidos = $conexao->query($notificacao);


?>

<li id="mensagem-aja">
          <button class="btn btn-primary dropdown-toggle" type="button" id="mensa" data-toggle="dropdown">
              <span class="glyphicon glyphicon-bell"></span>
              <span class="badge" id="num">
<?php 

if ($resultNotificacao->num_rows>0) {
  echo "$resultNotificacao->num_rows";
}
else{
  echo "0";
}


?>
              </span>
          </button>

            <ul class="dropdown-menu">
<?php 
if($pedidos->num_rows>0) 
{
  while($row = $pedidos->fetch_assoc()) 
  {
    $remetente = $row['cd_de'];

    $sqlNickRemetente = "select nm_nick from tb_perfil where cd_usuario = $remetente";
    $ResultNickRemetente = $conexao->query($sqlNickRemetente);

    while($row2 = $ResultNickRemetente->fetch_assoc()) 
    {
      $nickRemetente = $row2['nm_nick'];

      echo "<li><a href='#' data-toggle='modal' data-target='#$x'>$nickRemetente gostaria de ser seu amigo</a></li>";
      $x++;
    }
  }
}
?>
            </ul>
        </li>