<?php

include("conexao.php");

$meuid = $_GET['meuid'];
$amigoid = $_GET['amigoid'];
$mesa = $_GET['mesa'];


$sql = "DELETE FROM tb_not_mesa WHERE cd_usuario = $amigoid and cd_mesa = $mesa;";
$conexao->query($sql);


$x = 0;
$y = 0;

$notificacao = "select * from tb_notificacao where cd_para =  $meuid and ic_notificacao = false;";

$resultNotificacao = $conexao->query($notificacao);
$pedidos = $conexao->query($notificacao);


$notificacaoMesa = "select n.* from tb_not_mesa as n
  join tb_mesa as m
    on n.cd_mesa = m.cd_mesa
      join tb_omp as o
        on m.cd_mesa = o.cd_mesa
          join tb_perfil as p 
            on o.cd_usuario = p.cd_usuario
              where p.cd_usuario = $ideu and n.ic_notificacao = 0";

$resultnotificacaoMesa = $conexao->query($notificacaoMesa);



?>

<li id="mensagem-aja">
          <button class="btn btn-primary dropdown-toggle" type="button" id="mensa" data-toggle="dropdown">
              <span class="glyphicon glyphicon-bell"></span>
              <span class="badge" id="num">
<?php 

if ($resultNotificacao->num_rows>0 ||  $resultnotificacaoMesa->num_rows>0) {
  $not = $resultNotificacao->num_rows + $resultnotificacaoMesa->num_rows;
  echo "$not";
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
if($resultnotificacaoMesa->num_rows>0) 
{
  while($row = $resultnotificacaoMesa->fetch_assoc()) 
  {
    $remetente = $row['cd_usuario'];
    $mesa = $row['cd_mesa'];

    $sqlNickRemetente = "select nm_nick from tb_perfil where cd_usuario = $remetente";
    $ResultNickRemetente = $conexao->query($sqlNickRemetente);

    while($row2 = $ResultNickRemetente->fetch_assoc()) 
    {
      $nickRemetente = $row2['nm_nick'];

      $sqlMesa = "select nm_mesa from tb_mesa where cd_admin = $ideu and cd_mesa = $mesa";
      $resultMesa = $conexao->query($sqlMesa);

      while ($row3 = $resultMesa->fetch_assoc()) {
        $nmesa = $row3['nm_mesa'];
      }

      echo "<li><a href='#' data-toggle='modal' data-target='#$y'>$nickRemetente gostaria de entrar na mesa $nmesa</a></li>";
      $y++;
    }
  }
}
?>
            </ul>
        </li>