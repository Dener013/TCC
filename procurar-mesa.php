<?php
session_start();
include('php/conexao.php');


$sql2 = $conexao->query("SELECT * FROM tb_estado ORDER BY sg_estado");

while($row = mysqli_fetch_array($sql2)){
  $arrEstados[$row['cd_estado']] = $row['nm_estado'];
}

$nick = $_SESSION['nick'];

$x = 0;
$ideu = $_SESSION['id'];

$notificacaoMesa = "select n.* from tb_not_mesa as n
  join tb_mesa as m
    on n.cd_mesa = m.cd_mesa
      join tb_omp as o
        on m.cd_mesa = o.cd_mesa
          join tb_perfil as p 
            on o.cd_usuario = p.cd_usuario
              where p.cd_usuario = $ideu and n.ic_notificacao = 0";

$resultnotificacaoMesa = $conexao->query($notificacaoMesa);

$notificacao = "select * from tb_notificacao where cd_para = $ideu and ic_notificacao = false;";

$resultNotificacao = $conexao->query($notificacao);
$pedidos = $conexao->query($notificacao);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Taverna do Peregrino - Seja Bem Vindo!</title>

  <meta charset="utf-8">

  <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="css/bootstrap.css" rel="stylesheet"/ >

  <link rel="stylesheet" type="text/css" href="css/index2.css">

  <link rel="stylesheet" type="text/css" href="css/home2.css">

  <link rel="stylesheet" type="text/css" href="css/jogadores.css">

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


  <div class="container" id="jogadores-box">
  <h2>Encontre uma Mesa</h2>
  <hr>
    
  <input class="form-control" id="myInput" type="text" placeholder="Mesa  /  Sistema  /  Jogadores  /  Privado">

    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#box-selects" id="colapse-btn"><span class="glyphicon glyphicon-plus"></button>

 <div class="collapse" id="box-selects">
    <br>
    <h2>Procure por Região</h2>
    <hr>
    <div class="container" id="estado" onchange="buscar_cidades()">
      <select class="form-control" id="inputEstado">
        <option value="">Selecione...</option>
  <?php foreach ($arrEstados as $value => $name) {
         echo "<option value='{$value}'>{$name}</option>";}
   ?>
      </select>
    </div>

    <div class="container" id="cidade">
      <select class="form-control">
            <option>Cidade</option>
      </select>
     </div>

     <div class="container" id="bairro">
      <select class="form-control">
            <option>Bairro</option>
      </select>
     </div>
     <br>
     <br>
     <button type="button" class="btn btn-primary btn-block" id="btn-procurar" onclick="buscar_regiao()">Procurar</button>

  </div>
  <br>
  <div class="box-lista">
  <table class="table table-bordered table-striped" id="lista-mesas">
    <thead>
      <tr class="menu-jogadores">
        <th>Mesa</th>
        <th>Sistema</th>
        <th>Jogadores</th>
        <th>Privado</th>
        <th>Estado</th>
        <th>Cidade</th>
        <th>Bairro</th>
        <th>Mestre</th>
      </tr>
    </thead>
    <tbody id="myTable">
<?php
$sql = "select tb_mesa.*, tb_perfil.*, tb_bairro.nm_bairro, tb_cidade.nm_cidade, tb_estado.nm_estado from tb_mesa
          join tb_omp on tb_mesa.cd_mesa = tb_omp.cd_mesa
            join tb_perfil on tb_omp.cd_usuario = tb_perfil.cd_usuario
              join tb_bairro on tb_mesa.cd_bairro = tb_bairro.cd_bairro
                join tb_cidade on tb_cidade.cd_cidade = tb_bairro.cd_cidade
                  join tb_estado on tb_cidade.cd_estado = tb_estado.cd_estado;";

$result = $conexao->query($sql);

if($result->num_rows>0) 
{
  while($row = $result->fetch_assoc()) 
  { 

    $cdadmin = $row['cd_admin'];
    $cdmesa = $row['cd_mesa'];
    $mesa = $row['nm_mesa'];
    $sistema = $row['nm_sistema'];
    $jogadores = $row['qt_usuario'];
    $limite = $row['qt_limite'];
    $privado = $row['ic_privado'];
    $cidade = $row['nm_cidade'];
    $estado = $row['nm_estado'];
    $bairro = $row['nm_bairro'];
    $mestre = $row['nm_nick'];

    if ($cdadmin != $ideu) {
      if ($privado == 0) {
        $privado = "Aberto";
        $privadoa = 0;

         echo "<tr data-target='#$cdmesa' data-toggle='modal'>
              <td>".$mesa."</td>
              <td>".$sistema."</td>
              <td>".$jogadores." / ".$limite."</td>
              <td>".$privado."</td>
              <td>".$estado."</td>
              <td>".$cidade."</td>
              <td>".$bairro."</td>
              <td>".$mestre."</td>
            </tr>

            <div class='modal fade' id='$cdmesa' role='dialog'>
            <div class='modal-dialog'>
            
              <!-- Modal content-->
              <div class='modal-content' id='mensagem'>
                <div class='modal-header'>
                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  <h4 class='modal-title'>Mesa</h4>
                </div>
                <div class='modal-body'>
                  <p>Gostaria de entrar na $mesa?</p>
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-default' id='mensagem-enviar' onclick='notMesa($cdmesa, $privadoa)'>Entrar</button>
                  <button type='button' class='btn btn-default' data-dismiss='modal' id='mensagem-cancelar'>Cancelar</button>
                </div>
              </div>
              
            </div>
          </div>";
      }
      else {
        $privado = "Fechado";
        $privadoa = 1;

         echo "<tr data-target='#$cdmesa' data-toggle='modal'>
              <td>".$mesa."</td>
              <td>".$sistema."</td>
              <td>".$jogadores." / ".$limite."</td>
              <td>".$privado."</td>
              <td>".$estado."</td>
              <td>".$cidade."</td>
              <td>".$bairro."</td>
              <td>".$mestre."</td>
            </tr>

            <div class='modal fade' id='$cdmesa' role='dialog'>
            <div class='modal-dialog'>
            
              <!-- Modal content-->
              <div class='modal-content' id='mensagem'>
                <div class='modal-header'>
                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  <h4 class='modal-title'>Solicitação para entrar na Mesa</h4>
                </div>
                <div class='modal-body'>
                  <p>$mesa é uma mesa fechada, deseja enviar uma solicitação?</p>
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-default' id='mensagem-enviar' onclick='notMesaPriv($cdmesa, $privadoa)'>Enviar</button>
                  <button type='button' class='btn btn-default' data-dismiss='modal' id='mensagem-cancelar'>Cancelar</button>
                </div>
              </div>
              
            </div>
          </div>";
      }
    }
  }
}


?>
    </tbody>
  </table>
</div>
<br><br>
   <button type="button" id="btn-limpar" class="btn btn-primary btn-block" onclick="limpar()">Limpar </button>
  <br>
</div>

  <footer class="container-fluid text-center">
      <div class="info">
      <div class="quemsomos">
        <img class="img-espada" src="img/espada.png">
        <h3><a href="quem-somos.html">Quem somos</a></h3>
        <p>A Taverna do Peregrino é um site onde você jogador de RPG de Mesa, consegue encontrar outros jogadores, ou mesas, perto de você!</p>
      </div>

      <div class="fale-conosco">
        <img class="img-coruja" src="img/coruja.png">
        <h3>Fale Conosco</h3>
        <p>TavernaDoPeregrino@gmail.com</p>
      </div>
    </div>
  </footer>

<script type="text/javascript" src="js/amigos.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/mesas.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="jquery-3.3.1.min.js"></script>

<script type="text/javascript">
  function notMesa(mesa, privado){
    
    window.location.href = 'php/notificacao_mesa.php?mesa='+mesa+'&privado='+privado;
  }

  function notMesaPriv(mesa, privado){
    window.location.href = 'php/notificacao_mesa.php?mesa='+mesa+'&privado='+privado;
  }
</script>

</body>
</html>
