<?php

session_start();
include('php/conexao.php');

$ideu = $_SESSION['id'];
$meunick = $_SESSION['nick'];

$notificacaoMesa = "select n.* from tb_not_mesa as n
  join tb_mesa as m
    on n.cd_mesa = m.cd_mesa
      join tb_omp as o
        on m.cd_mesa = o.cd_mesa
          join tb_perfil as p 
            on o.cd_usuario = p.cd_usuario
              where p.cd_usuario = $ideu and n.ic_notificacao = 0";

$resultnotificacaoMesa = $conexao->query($notificacaoMesa);


$sql2 = $conexao->query("SELECT * FROM tb_estado ORDER BY sg_estado");

while($row = mysqli_fetch_array($sql2)){
  $arrEstados[$row['cd_estado']] = $row['nm_estado'];
}

// ---------------Verificando se o user ta vendo o perfil dele ou de outro user--------------------- //

if (isset($_GET['perfil']) != null) {

  $user = true;

  $iddele = $_GET['perfil'];

  if ($iddele != $ideu) {

    $sqlInfoUSer = "select *, date_format(curdate(), '%Y')-date_format(dt_nascimento, '%Y') as idade from tb_perfil where cd_usuario = $iddele;";

    $resultInfoUser = $conexao->query($sqlInfoUSer);

    while ($row = $resultInfoUser->fetch_assoc()) {

      $nomeuser = $row['nm_usuario'];

      $nickuser = $row['nm_nick'];

      $idadeuser = $row['idade'];

      $imguser = $row['img_usuario'];

      $biouser = $row['ds_bio'];

      $background = $row['img_fundo'];

    }


    $sqlMesasUser = "select * from tb_mesa where cd_admin = '$iddele';";

    $resultMesasUser = $conexao->query($sqlMesasUser);


    $sqlMesas = "select * from tb_not_mesa where cd_usuario = $iddele;";

    $resultMesas = $conexao->query($sqlMesas);


    // -----------Comentarios------------ //


    $sqlComentario = "select p.* ,f.*, date_format(f.dt_feedback, '%d-%m-%Y') as 'dt_feedback' from tb_feedback as f join tb_perfil as p on f.cd_de = p.cd_usuario where cd_para = $iddele";

    $resultComentario = $conexao->query($sqlComentario);
  }
  else{

    // ---------proteção contra burlamento de perfil(n fazer comentario no proprio perfil)-------- //

    $user = false;

    $sqlMinhasInfo = "select *, date_format(curdate(), '%Y')-date_format(dt_nascimento, '%Y') as idade from tb_perfil where cd_usuario = $ideu;";

    $resultMinhasInfo = $conexao->query($sqlMinhasInfo);

    $sqlMinhasMesas = "select * from tb_mesa where cd_admin = '$ideu';";

    $resultMinhasMesas = $conexao->query($sqlMinhasMesas);

    $sqlMesas = "select * from tb_not_mesa where cd_usuario = '$ideu';";

    $resultMesas = $conexao->query($sqlMesas);

    while ($row = $resultMinhasInfo->fetch_assoc()) {

      $nomeuser = $row['nm_usuario'];

      $nickuser = $row['nm_nick'];

      $idadeuser = $row['idade'];

      $biouser = $row['ds_bio'];

      $imguser = $row['img_usuario'];

      $background = $row['img_fundo'];

      $cidade = $row['cd_cidade'];

      $bairro = $row['cd_bairro'];

      $sqlRegiao = "select p.nm_nick, b.nm_bairro, c.nm_cidade, e.nm_estado from tb_perfil as p 
                      join tb_bairro as b on p.cd_bairro = b.cd_bairro
                        join tb_cidade as c on b.cd_cidade = c.cd_cidade
                          join tb_estado as e on c.cd_estado = e.cd_estado where p.cd_usuario = $ideu";

      $resultRegiao = $conexao->query($sqlRegiao);

      while ($row = $resultRegiao->fetch_assoc()) {
        $estado = $row['nm_estado'];
        $cidade = $row['nm_cidade'];
        $bairro = $row['nm_bairro'];
      }
      
    }

    // -----------Comentarios------------ //


    $sqlComentario = "select *, date_format(dt_feedback, '%d-%m-%Y') as 'dt_feedback' from tb_feedback where cd_para = $ideu";

    $resultComentario = $conexao->query($sqlComentario);  
    }

}
else{

  $user = false;

  $sqlMinhasInfo = "select *, date_format(curdate(), '%Y')-date_format(dt_nascimento, '%Y') as idade from tb_perfil where cd_usuario = $ideu;";

  $resultMinhasInfo = $conexao->query($sqlMinhasInfo);

  $sqlMinhasMesas = "select * from tb_mesa where cd_admin = '$ideu';";

  $resultMinhasMesas = $conexao->query($sqlMinhasMesas);

  $resultMinhasMesas = $conexao->query($sqlMinhasMesas);

  $sqlMesas = "select * from tb_not_mesa where cd_usuario = '$ideu';";
  $resultMesas = $conexao->query($sqlMesas);

  while ($row = $resultMinhasInfo->fetch_assoc()) {

    $nomeuser = $row['nm_usuario'];

    $nickuser = $row['nm_nick'];

    $idadeuser = $row['idade'];

    $biouser = $row['ds_bio'];

    $imguser = $row['img_usuario'];

    $background = $row['img_fundo'];

    $cidade = $row['cd_cidade'];

    $bairro = $row['cd_bairro'];

    $sqlRegiao = "select p.nm_nick, b.nm_bairro, c.nm_cidade, e.nm_estado from tb_perfil as p 
                      join tb_bairro as b on p.cd_bairro = b.cd_bairro
                        join tb_cidade as c on b.cd_cidade = c.cd_cidade
                          join tb_estado as e on c.cd_estado = e.cd_estado where p.cd_usuario = $ideu";

    $resultRegiao = $conexao->query($sqlRegiao);

      while ($row = $resultRegiao->fetch_assoc()) {
        $estado = $row['nm_estado'];
        $cidade = $row['nm_cidade'];
        $bairro = $row['nm_bairro'];
    }
  }

  // -----------Comentarios------------ //


  $sqlComentario = "select p.* ,f.*, date_format(f.dt_feedback, '%d-%m-%Y') as 'dt_feedback' from tb_feedback as f join tb_perfil as p on f.cd_de = p.cd_usuario where cd_para = $ideu";

  $resultComentario = $conexao->query($sqlComentario);  

}

$y = 1;

$sqlRank = "select nm_nick from tb_perfil order by qt_xp desc;";

$resultRank = $conexao->query($sqlRank);

while ($row = $resultRank->fetch_assoc()) {

  $nickRank = $row['nm_nick'];

  if ($nickRank == $nickuser) {
    $rank = $y;
    break;
  }
  $y++;
}


// -----------------------------Notificacao------------------------------- //

$x = 0;

$ideu = $_SESSION['id'];

$notificacao = "select * from tb_notificacao where cd_para = $ideu and ic_notificacao = false;";

$resultNotificacao = $conexao->query($notificacao);
$pedidos = $conexao->query($notificacao);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Taverna do Peregrino - Seja Bem Vindo!</title>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />

	<link href="css/bootstrap.css" rel="stylesheet"/ >

  <link rel="stylesheet" type="text/css" href="css/index2.css">

	<link rel="stylesheet" type="text/css" href="css/home2.css">

	<link rel="stylesheet" type="text/css" href="css/configuracoes.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  
</head>
<body>
	<nav id="menu" class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" id="logo" href="home.php"><img id="logo" class="img-responsive" src="img/logo-azul.png"></a>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
   
    <div class="collapse navbar-collapse" id="myNavbar">
    	 <form class="navbar-form navbar-right" action="pesquisar.php">
          <div class="input-group">
             <input id="pesquisar" type="text" class="form-control" placeholder="Pesquisar" name="search">

              <div class="input-group-btn">
                <button id="btn-pesquisar" class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-search" id="foto" ></i>
                </button>
              </div>
          </div>
        </form>
      <ul id="barra-menu" class="nav navbar-nav navbar-right">
            <li><a id="home" href="home.php"> Home</a></li>
            <li><a id="minha-guilda" href="amigos.php"> Minha Guilda</a></li>
            <li><a id="jogadores" href="jogadores.php"> Jogadores</a></li>
            <li><a id="mesas" class="dropdown-toggle" data-toggle="dropdown" href="#"> Mesas<span class="caret"></span></a>
            	<ul class="dropdown-menu" id="menu-home">
        			<li><a href="criar-mesa.php">Criar Mesa</a></li>
        			<li><a href="procurar-mesa.php">Procurar Mesa</a></li>                      
     		    </ul>
            </li>
        <li>
        	<a id="nick" class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo "$meunick"; ?><span class="caret"></span></a>
          		<ul class="dropdown-menu" id="menu-home">
        			<li><a href="configuracoes.php">Meu Perfil</a></li>
        			<li><a href="index.php">Sair</a></li>                      
     		    </ul>
     	  </li>
      
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
       </ul>

    </div>
  </div>
</nav>


<?php 
$x = 0;

$notificacao = "select * from tb_notificacao where cd_para = $ideu and ic_notificacao = false;";

$pedidos = $conexao->query($notificacao);

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

  echo "<div class='modal fade' id='$x' role='dialog'>
    <div class='modal-dialog' >
    
      <!-- Modal content-->
      <div class='modal-content' id='mensagem'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title'>Solicitação de Amizade</h4>
        </div>
        <div class='modal-body'>
          <p>$nickRemetente gostaria de ser seu amigo. Você aceita?</p>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' data-dismiss='modal' id='mensagem-enviar' onclick='amizade($ideu, $remetente)'>Sim</button>
          <button type='button' class='btn btn-default' data-dismiss='modal' id='mensagem-cancelar' onclick='desamizade($ideu, $remetente)'>Não</button>

        </div>
      </div>
      
    </div>
  </div>";
  $x++;
      }
  }
}
?>



<?php 
$y = 0;

$notificacaoMesa = "select n.* from tb_not_mesa as n
  join tb_mesa as m
    on n.cd_mesa = m.cd_mesa
      join tb_omp as o
        on m.cd_mesa = o.cd_mesa
          join tb_perfil as p 
            on o.cd_usuario = p.cd_usuario
              where p.cd_usuario = $ideu and n.ic_notificacao = false";

$resultnotificacaoMesa = $conexao->query($notificacaoMesa);

if($resultnotificacaoMesa->num_rows>0) 
{

  while ($row = $resultnotificacaoMesa->fetch_assoc()) {
    $idPedinte = $row['cd_usuario'];
    $idMesa = $row['cd_mesa'];

    $sqlInfoMesa = "select * from tb_mesa where cd_mesa = $idMesa";
    $sqlInfoPedinte = "select * from tb_perfil where cd_usuario = $idPedinte";

    $resultInfoMesa = $conexao->query($sqlInfoMesa);
    $resultInfoPedinte = $conexao->query($sqlInfoPedinte);

    while ($row1 = $resultInfoMesa->fetch_assoc()) {
      $nmMesa = $row1['nm_mesa'];
    }

    while ($row1 = $resultInfoPedinte->fetch_assoc()) {
      $nmNick = $row1['nm_nick'];
    }
  }

  echo "<div class='modal fade' id='$y' role='dialog'>
    <div class='modal-dialog' >
    
      <!-- Modal content-->
      <div class='modal-content' id='mensagem'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title'>Solicitação de Mesa</h4>
        </div>
        <div class='modal-body'>
          <p>$nmNick gostaria entrar na mesa $nmMesa. Você aceita?</p>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' data-dismiss='modal' id='mensagem-enviar' onclick='solitMesa($ideu, $idPedinte, $idMesa)'>Sim</button>
          <button type='button' class='btn btn-default' data-dismiss='modal' id='mensagem-cancelar' onclick='exluiMesa($ideu, $idPedinte, $idMesa)'>Não</button>

        </div>
      </div>
      
    </div>
  </div>";
  $y++;
      }
  

?>

  <div class="container text-center" id="info-box">    

<?php
  if ($user == true) {
    echo "<div id='ajax'><div class='personal-image' style='background-image: url(perfil/$background);' id='icone-box' >
           <label class='label'>
           <figure class='personal-figure-user' data-toggle='collapse' data-target='#icones'>
           <img src='perfil/$imguser' class='personal-avatar' alt='avatar'>
           </figure>
          </div></div>";
  }else{
    echo "<div id='ajax'><div class='personal-image'  style='background-image: url(perfil/$background)'  id='icone-box' >
           <label class='label'>
           <figure class='personal-figure' data-toggle='collapse' data-target='#icones'>
           <img src='perfil/$imguser' class='personal-avatar' alt='avatar'>
           </figure>
          </div></div>
  <div id='icones' class='collapse'>
        <div id='barbaro' onmouseover='BarbaroOver()' onmouseout='BarbaroOut()' onclick='chooseBarbaro($ideu)'>
          <img src='perfil/barbaro.png' id='ba'>
        </div>

        <div id='mago' onmouseover='MagoOver()' onmouseout='MagoOut()' onclick='chooseMago($ideu)'>
          <img src='perfil/mago.png' id='ba'>
        </div>

        <div id='cavaleiro' onmouseover='CavaleiroOver()' onmouseout='CavaleiroOut()' onclick='chooseCavaleiro($ideu)'>
          <img src='perfil/cavaleiro.png' id='ba'>
        </div>

        <div id='ladino' onmouseover='LadinoOver()' onmouseout='LadinoOut()'  onclick='chooseLadino($ideu)'>
          <img src='perfil/ladino.png' id='ba'>
        </div>
  </div>";
  }
?>

    
  <div class="row">
    <div class="col-sm-4" id="info-user">
<?php 

    echo "<label id='title-info'>
      Minhas Informações
    </label>
    <br>
    <hr>
    <label id=''>
      Nome: <label id='info-dele'>$nomeuser</label>
    </label>
    <br>
    <label id=''>
      Rank: <label id='info-dele'>#$rank</label>
    </label>
    <br>
    <label id=''>
      Idade: <label id='info-dele'>$idadeuser</label>
    </label>
    <br>
    <label id=''>
      Nickname: <input id='info-delee' value='$nickuser'>
    </label>
    
    ";

?>
    </div>
    <div class="col-sm-4" id="mesas-user"> 
      <label id='title-info-mesa'>
      Minhas Mesas
      </label> 
      <hr>
 <div id="box-mesas">     
  <div id="tb-mesas">
    <table class="table table-bordered table-striped" >
      <thead>
        <tr class="">
          <th>Nome da Mesa</th>
          <th>Sistema</th>
          <th>Jogadores</th>
          <th>Privado</th>
          <th>Mestre</th>
        </tr>
      </thead>
      <tbody id="myTable">

  <?php 

  if ($user == true) {

      while ($row2 = $resultMesasUser->fetch_assoc()) {

      $nomemesa = $row2['nm_mesa'];

      $sistema = $row2['nm_sistema'];

      $jogadores = $row2['qt_usuario'];

      $privado = $row2['ic_privado'];

      $admin = $nickuser;

      if ($privado == false || $privado == 0) {

        $privado = "Aberto";

      }else{

        $privado = "Fechado";

      }
      echo "<tr>
              <td>$nomemesa</td>
              <td>$sistema</td>
              <td>$jogadores</td>
              <td>$privado</td>
              <td>$admin</td>
            </tr>";
      }

      }

    
    else{

      while ($row2 = $resultMinhasMesas->fetch_assoc()) {

      $nomemesa = $row2['nm_mesa'];

      $sistema = $row2['nm_sistema'];

      $jogadores = $row2['qt_usuario'];

      $limite = $row2['qt_limite'];

      $privado = $row2['ic_privado'];

      $admin = $meunick;

      if ($privado == false || $privado == 0) {

        $privado = "Aberto";

      }else{

        $privado = "Fechado";

      }

      

            while ($row2 = $resultMesas->fetch_assoc()) {
        $cdmesa = $row2['cd_mesa'];

        $sqlMesaa = "select tb_mesa.*, tb_perfil.* from tb_mesa join tb_omp on tb_mesa.cd_mesa = tb_omp.cd_mesa join tb_perfil on tb_omp.cd_usuario = tb_perfil.cd_usuario where tb_mesa.cd_mesa = $cdmesa";

        $resultMesaa = $conexao->query($sqlMesaa);

        while ($row3 = $resultMesaa->fetch_assoc()) {
          $nomemesa = $row3['nm_mesa'];

          $sistema = $row3['nm_sistema'];

          $jogadores = $row3['qt_usuario'];

          $privado = $row3['ic_privado'];

          $admin = $row3['nm_nick'];

          if ($privado == false || $privado == 0) {

            $privado = "Aberto";

          }else{

            $privado = "Fechado";

          }
          echo "<tr>
                  <td>$nomemesa</td>
                  <td>$sistema</td>
                  <td>$jogadores</td>
                  <td>$privado</td>
                  <td>$admin</td>
                </tr>";
          }
        }

      }
    }

  ?>
      </tbody>
    </table>
  </div>
</div>

    </div>
    <div class="col-sm-4" id="bio-user">
      <br>
      <br>
      <label id='title-info-mesa'>
      Minha História
      </label> 
      <hr>
      <br>
<?php
    echo "
    <label id=''>
      <textarea id='txt-bios' rows='5' cols='30' readonly=''>$biouser</textarea>
    </label>";
?>

    </div>

  
  </div>
  <div id="regiao-box">
    <label id='title-info-mesa'>
      Região
      </label> 
    <br>
    <br>
      <div class="container" id="estado" onchange="buscar_cidades()">
      <select class="form-control" id="inputEstado">
  <?php 
  foreach ($arrEstados as $value => $name) {
        if ($name == $estado) {
          echo "<option value='{$value}' selected=''>{$name}</option>";
          $idestado = $value;
        }
         echo "<option value='{$value}'>{$name}</option>";
       }
   ?>
      </select>
    </div>

    <div class="container" id="cidade">

      <?php
      $sql = $conexao->query("SELECT * FROM tb_cidade WHERE cd_estado = $idestado  ORDER BY nm_cidade");

      while($row = mysqli_fetch_array($sql)){
        $arrCidades[$row['cd_cidade']] = $row['nm_cidade'];
      }

      ?>

      <select class="form-control" id="inputEstado">
        <?php 
        foreach ($arrCidades as $value => $name) {
              if ($name == $cidade) {
                echo "<option value='{$value}' selected=''>{$name}</option>";
                $idcidade = $value;
              }
               echo "<option value='{$value}'>{$name}</option>";
             }
         ?>
      </select>

     </div>

     <div class="container" id="bairro">

      <?php
      $sql = $conexao->query("SELECT * FROM tb_bairro WHERE cd_cidade = $idcidade  ORDER BY nm_bairro");

      while($row = mysqli_fetch_array($sql)){
        $arrBairros[$row['cd_bairro']] = $row['nm_bairro'];
      }

      ?>

      <select name="bairro" id="id-bairro" class="form-control">
        <?php foreach($arrBairros as $value => $name){
          if ($name == $bairro) {
            echo "<option value='{$value}' selected=''>{$name}</option>";
          }
          echo "<option value='{$value}'>{$nome}</option>";
        }
      ?>
      </select>
     </div>
    </div>  
    <br>
    <br>
<?php
if ($user != true) {
  echo "<br><br><br><br><button class='btn btn-primary' id='salvar' onclick='salvar()'>Salvar</button>
    <button class='btn btn-primary' id='editar' onclick=editar()>Editar</button>
    <button class='btn btn-primary' id='cancelar' onclick=cancelar('$nickuser')>Cancelar</button>";
}
?>
    
</div>

  <br>
  <br>  
  <br>
  <br>
<div id="box-feed">
  <div  class="container-fluid bg-3 text-left" id="feedback">
    <h2>Comentários</h2>
    <hr>
<?php
if ($user != true) {

  if ($resultComentario->num_rows>0) {

    while ($row = $resultComentario->fetch_assoc()) {

      $idcomentario = $row['cd_comentario'];

      $nickautor = $row['nm_nick'];

      $comentario = $row['ds_feedback'];

      $data = $row['dt_feedback'];

      $imguser2 = $row['img_usuario'];

      echo "<div class='media' id='comentario'>
        <div class='media-left media-top'>
          <img src='perfil/$imguser2' class='media-object' id='img-comentario'>
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
    echo "<h2>Nenhum Comentário</h2>";
  }
  
}else{

  if ($resultComentario->num_rows>0) {

    while ($row = $resultComentario->fetch_assoc()) {

      $idcomentario = $row['cd_comentario'];

      $nickautor = $row['nm_nick'];

      $comentario = $row['ds_feedback'];

      $data = $row['dt_feedback'];

      $imguser2 = $row['img_usuario'];

      if ($nickautor == $meunick) {

        echo "<div class='media' id='comentario'>
        <div class='media-left media-top'>
          <img src='perfil/$imguser2' class='media-object' id='img-comentario'>
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
          <img src='perfil/$imguser2' class='media-object' id='img-comentario'>
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
    echo "<h1>Nenhum Comentário</h1>";
  }
  
}
?>


<!-- ---------Input de comentario----------- -->

<?php
if ($user == true) {
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
</div>

<script type="text/javascript" src="js/cadastro.js"></script>
<script type="text/javascript" src="js/amigos.js"></script>
<script type="text/javascript" src="js/configuracoes.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</body>
</html>
