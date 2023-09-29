<?php
session_start();
include('php/conexao.php');

$nick = $_SESSION['nick'];
$ideu = $_SESSION['id'];

$sqlMinhasInfo = "select * from tb_perfil where cd_usuario = $ideu";

$resultMinhasInfo = $conexao->query($sqlMinhasInfo);

while ($row = $resultMinhasInfo->fetch_assoc()) {
  $imgfundo = $row['img_fundo'];
}

$notificacaoMesa = "select n.* from tb_not_mesa as n
  join tb_mesa as m
    on n.cd_mesa = m.cd_mesa
      join tb_omp as o
        on m.cd_mesa = o.cd_mesa
          join tb_perfil as p 
            on o.cd_usuario = p.cd_usuario
              where p.cd_usuario = $ideu and n.ic_notificacao = 0";

$resultnotificacaoMesa = $conexao->query($notificacaoMesa);


$sqlMinhaMesas = "select * from tb_not_mesa where cd_usuario = $ideu and ic_notificacao = 1"; 

$resultMinhasMesas = $conexao->query($sqlMinhaMesas);




// -------------------Vendo quem é amigo do usuário logado---------------- //

$sqlAmigos = "select * from tb_notificacao where cd_de = $ideu and ic_notificacao = true or cd_para = $ideu and ic_notificacao = true;";

$resultAmigos = $conexao->query($sqlAmigos);



// --------------------------Vendo se tem Notificacao------------------------------------ //
$notificacao = "select * from tb_notificacao where cd_para = $ideu and ic_notificacao = false;";

$resultNotificacao = $conexao->query($notificacao);
$pedidos = $conexao->query($notificacao);

$x = 0;
$y = 0;

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Taverna do Peregrino</title>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />

	<link href="css/bootstrap.css" rel="stylesheet"/ >

	<link rel="stylesheet" type="text/css" href="css/index2.css">

  <link rel="stylesheet" type="text/css" href="css/home2.css">

  <link rel="stylesheet" type="text/css" href="css/amigos.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

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
        	<a id="nick" class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo "$nick"; ?><span class="caret"></span></a>
          		<ul class="dropdown-menu" id="menu-home">
        			<li><a href="configuracoes.php">Configurações</a></li>
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

<!-- ----------------------Chat----------------------- -->


<div id="box-chat-geral">
  <div id="box-lst-maior">
    <div id="box-myinfo">
      <div id="eu">
        <h1>Minha Guilda</h1>
      </div>

      <div id="pesquisar-chat">
        <div class="input-group" id="input-pesquisar">
             <input id="pesquisar-lst" type="text" class="form-control" placeholder="Pesquisar" name="search">
              <div class="input-group-btn">
                <button id="btn-pesquisar" class="btn btn-default" type="submit" onclick="pesquisar(<?php echo "$ideu"; ?>)">
                    <i class="glyphicon glyphicon-search" id="foto" ></i>
                </button>
              </div>
          </div>
      </div>
    </div>

    <div id="lst-amigos">

<!-- ----------------------Amigos----------------------- -->

<?php

if ($resultAmigos->num_rows==0 && $resultMinhasMesas->num_rows==0) {
  echo "<div id='nem-amigo'>
            <div id='myinfo'>
              <h1>Nenhum Amigo</h1>
            </div>
         </div>";
}
else{

  if ($resultAmigos->num_rows>0) {
    while ($row = $resultAmigos->fetch_assoc()) {
    $cdAmigo = $row['cd_de'];

    if ($cdAmigo == $ideu) {
      $cdAmigo = $row['cd_para'];
    }

    $sqlInfoAmigo = "select * from tb_perfil where cd_usuario = $cdAmigo";

    $resultInfoAmigo = $conexao->query($sqlInfoAmigo);

    if ($resultInfoAmigo->num_rows>0) {

      while ($row2 = $resultInfoAmigo->fetch_assoc()) {
        $imgAmigo = $row2['img_usuario'];
        $nickAmigo = $row2['nm_nick'];

        $sqlUlitmaMensagem = "select ds_mensagem, dt_hora from tb_chat where cd_de = $ideu and cd_para = $cdAmigo or cd_de = $cdAmigo and cd_para = $ideu ORDER BY cd_mensagem DESC limit 1";
        $resultUltimaMensagem = $conexao->query($sqlUlitmaMensagem);

        if ($resultUltimaMensagem->num_rows>0) {
          while ($row3 = $resultUltimaMensagem->fetch_assoc())
          {
            $hora = $row3['dt_hora'];
            $ultima = $row3['ds_mensagem'];
            break;
          }
        }else{
          $ultima = "";
          $hora = "";
       }

        echo "<div id='amigo' onclick='chooseFriend($ideu, $cdAmigo)'>

              <div id='img-usuario'>
                <img src='perfil/$imgAmigo'>
              </div>

              <div id='myinfo'>
                <h3>$nickAmigo</h3>
                <h4>$ultima $hora</h4>
              </div>

           </div>";
?>
 <!-- Modal -->
 <div id="isso">
    <div class="modal fade" <?php echo "id='$nickAmigo'" ?>role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content" id="mensagem-modal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Excluir Amizade</h4>
          </div>
          <div class="modal-body">
            <p>Você tem certeza de que gostaria de excluir <?php echo "$nickAmigo" ?> ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" id="mensagem-enviar" data-dismiss="modal" onclick="excluirAmigo(<?php echo "$cdAmigo, $ideu"; ?>)">Excluir</button>
            <button type="button" class="btn btn-default" id="mensagem-cancelar" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
        
      </div>
    </div>
  </div>
<?php
      }
    }
  }
}


  if ($resultMinhasMesas->num_rows>0) {
    while ($row2 = $resultMinhasMesas->fetch_assoc()) {
      
      $cdresmesa = $row2['cd_mesa'];

      $sqlInfoDasMesas = "select * from tb_mesa where cd_mesa = $cdresmesa";

      $resultInfoDasMesas = $conexao->query($sqlInfoDasMesas);

      while ($row = $resultInfoDasMesas->fetch_assoc()) {

        $cdMesa = $row['cd_mesa'];

        $nomeMesa = $row['nm_mesa'];

        $cdadmin = $row['cd_admin'];

         $sqlUlitmaMensagem = "select ds_mensagem, dt_hora from tb_chat_mesa where cd_mesa = $cdMesa ORDER BY cd_mensagem DESC limit 1";
        $resultUltimaMensagem = $conexao->query($sqlUlitmaMensagem);

        if ($resultUltimaMensagem->num_rows>0) {
          while ($row3 = $resultUltimaMensagem->fetch_assoc())
          {
            $hora = $row3['dt_hora'];
            $ultima = $row3['ds_mensagem'];
          }
        }else{
          $ultima = "";
          $hora = "";
       }

        echo "<div id='amigo' onclick='chooseTable($ideu, $cdMesa)'>

                <div id='img-mesa'>
                  <img src='perfil/$imgfundo'>
                </div>

                <div id='info-mesa'>
                  <h3>$nomeMesa</h3>
                  <h4>$ultima $hora</h4>
                </div>

             </div>";

             if ($cdadmin == $ideu) {
?>
     <div id="isso">
    <div class="modal fade" <?php echo "id='$cdMesa'" ?>role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content" id="mensagem-modal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Congigurações da Mesa</h4>
          </div>
          <div class="modal-body">
             <p>Você tem certeza de que gostaria de excluir a mesa <?php echo "$nomeMesa" ?>? </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" id="mensagem-enviar" data-dismiss="modal" onclick="excluirMesa(<?php echo "$cdMesa, $ideu"; ?>)">Excluir</button>
            <button type="button" class="btn btn-default" id="mensagem-cancelar" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
        
      </div>
    </div>
  </div>
<?php 
             }else{
?>
<div id="isso">
             <!-- Modal -->
    <div class="modal fade" <?php echo "id='$cdMesa'" ?> role="dialog" >
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content" id="mensagem-modal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Sair Mesa</h4>
          </div>
          <div class="modal-body">
            <p>Você tem certeza de que gostaria de sair da mesa <?php echo "$nomeMesa" ?>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" id="mensagem-enviar" onclick="sairMesa(<?php echo "$cdMesa, $ideu"; ?>)">Sair</button>
            <button type="button" class="btn btn-default" id="mensagem-cancelar" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
        
      </div>
    </div>
</div>
<?php
             }

      }
    }
  }

}

?>
    </div>
  </div>

  <div id="box-chat-maior">
    <div id="msg-chat">
     <div id="box-converse">
        <h1 id="con">Converse com Alguém</h1>
        <img class="img-coruja" id="img-coruja-chat" src="img/coruja.png">
        <br>
        <br>
        <br>
        <h3 style="color: white">1. Respeite todos os seus colegas e membros de sua mesa.</h3>
        <h3 style="color: white">2. Preconceitos são passivos de ban permanente.</h3>
        <h3 style="color: white">3. Envie arquivos por meio de links.</h3>
      </div>
    </div>
  </div>

</div>




<!-- ------------------------JS----------------------- -->

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/amigos.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
  
  function chooseFriend(meuid, idamigo, img){
    var iddele = idamigo;
    var meuid = meuid;
    var img = img;


    var url = 'php/ajax_chat_amigo.php?meuid='+meuid+'&iddele='+iddele+'&img='+<?php echo "'$imgfundo'"; ?>;
    $.get(url, function(dataReturn) {
      $('#box-chat-maior').html(dataReturn);
    });
  }

  function chooseTable(meuid, cdmesa){
    var cdmesa = cdmesa;
    var meuid = meuid;

    var url = 'php/ajax_chat_mesa.php?meuid='+meuid+'&cdmesa='+cdmesa;
    $.get(url, function(dataReturn) {
      $('#box-chat-maior').html(dataReturn);
    });
  }

  function perfil(id){
    var a = id;
    window.location.href = 'configuracoes.php?perfil='+a;
  }

  function enviar(meuid, iddele){

    var iddele = iddele;
    var meuid = meuid;
    var msg = document.getElementById('enviar-msg').value;

    if (msg != "") {
        var url = 'php/ajax_enviar_mensagem.php?mensagem='+msg+'&meuid='+meuid+'&iddele='+iddele;
      $.get(url, function(dataReturn) {
        $('#msg-chat').html(dataReturn);
      });

      var url2 = 'php/ajax_atualizar_amigos.php?meuid='+meuid+'&iddele='+iddele;
      $.get(url2, function(dataReturn) {
        $('#lst-amigos').html(dataReturn);
      });

      document.getElementById('enviar-msg').value = "";
    }else{
      alert("Escreva, por favor!");
    } 
  }

  function enviarChatMesa(eu, mesa){
    var msg = document.getElementById('enviar-msg').value;

    if (msg != "") {
        var url = 'php/ajax_enviar_mensagem_mesa.php?mensagem='+msg+'&mesa='+mesa+'&eu='+eu;
      $.get(url, function(dataReturn) {
        $('#msg-chat').html(dataReturn);
      });

      var url2 = 'php/ajax_atualizar_amigos.php?meuid='+eu;
      $.get(url2, function(dataReturn) {
        $('#lst-amigos').html(dataReturn);
      });

      document.getElementById('enviar-msg').value = "";
    }else{
      alert("Escreva, por favor!");
    }  
  }


  function pesquisar(meuid){
    var meuid = meuid;
    var info = document.getElementById('pesquisar-lst').value;
    document.getElementById('pesquisar-lst').value = "";

    var url = 'php/ajax_pesquisar.php?meuid='+meuid+'&info='+info;
      $.get(url, function(dataReturn) {
        $('#lst-amigos').html(dataReturn);
      }); 
  }

  function excluirMesa(mesa, eu){ 
    var url = 'php/ajax_excluir_mesa.php?meuid='+eu+'&mesa='+mesa;
          $.get(url, function(dataReturn) {
            $('#box-chat-geral').html(dataReturn);
          }); 
  }

  function sairMesa(mesa, eu){ 
    var url = 'php/ajax_sair_mesa.php?meuid='+eu+'&mesa='+mesa;
          $.get(url, function(dataReturn) {
            $('#box-chat-geral').html(dataReturn);
          }); 
  }

  function excluirAmigo(amigo, eu){
    var url = 'php/ajax_excluir_amigo.php?meuid='+eu+'&amigo='+amigo;
          $.get(url, function(dataReturn) {
            $('#box-chat-geral').html(dataReturn);
          }); 
  }

</script>
 <script src="js/bootbox.min.js"></script>
</body>
</html>