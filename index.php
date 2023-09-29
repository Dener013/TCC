<?php

include("php/conexao.php");

$sql = "select cd_noticia, nm_noticia, img_noticia, date_format(dt_noticia, '%d-%m-%Y') as 'dt_noticia'
          from tb_noticia;";

$sql3 = "select r.cd_ranking, p.nm_nick, e.sg_estado
            from tb_ranking as r join tb_perfil as p
              on r.cd_ranking = p.cd_ranking
                join tb_bairro as b
                  on p.cd_bairro = b.cd_bairro
                    join tb_cidade as c
                      on b.cd_cidade = c.cd_cidade
                        join tb_estado as e
                          on c.cd_estado = e.cd_estado
                            order by p.qt_xp desc;";

$result = $conexao->query($sql);
$result2 = $conexao->query($sql);
$result3 = $conexao->query($sql3);

session_start();

$_SESSION['logado'] = false;

unset($_SESSION['nick']);
unset($_SESSION['id']);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Taverna do Peregrino - Seja Bem Vindo!</title>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32"/>

	<link href="css/bootstrap.css" rel="stylesheet"/>

	<link rel="stylesheet" type="text/css" href="css/index2.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

</head>
<body>

<nav id="menu" class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" id="logo" href="index.php"><img id="logo" class="img-responsive" src="img/logo-azul.png"></a>
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
          <li><a id="login" href="login.html">Login</a></li>
          <li><a id="cadastrar" href="cadastrar.html">Cadastrar</a></li>
      </ul>
    </div>
  </div>
</nav>

<div id="mycarousel">
<div class="container">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" id="carousel">
<?php

if($result->num_rows>0) 
{
  $limite = 1;
  while ($row = $result->fetch_assoc()) 
  {
    $image = $row['img_noticia'];
    $id = $row['cd_noticia'];
    if ($limite == 1) 
    {
  echo "<div class='item active'>
          <a href='noticia.php?noticia=$id'>
          <img src='".$image."'  alt='Los Angeles' style='width:100%;'>
          </a>
          <div class='carousel-caption'>
          </div>
        </div>";
    }
    else 
    {
  echo "<div class='item'>
          <a href='noticia.php?noticia=$id'>
          <img src='".$image."' alt='Chicago' style='width:100%;'>
          </a>
          <div class='carousel-caption'>
          </div>
        </div>";
    }
    if ($limite == 3) 
    {
      break;
    }
    $limite++;
  }
}
?>
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
</div>

<div id="geral">
 <div id="noticia" class="container-fluid bg-3 text-left">    
    <h3>Notícias</h3>
    <hr>
    <div class="row">
<?php

if($result2->num_rows>0) 
{
  while ($row2 = $result2->fetch_assoc()) 
  {
    $id = $row2['cd_noticia'];
    $manchete = $row2['nm_noticia'];
    $image = $row2['img_noticia'];
    $data = $row2['dt_noticia'];

    echo "<a href='noticia.php?noticia=$id'>
            <div id='noticiaa'>
              <img src='".$image."' class='img-responsive' style='width:100%;' alt='Image'>
              <p>".$data."</p>
            </div>
          </a>";
          
  }    
}

?>
    </div>
  </div>
  <br>
  <br>
  <div id="ranking" class="container">
    <h2 id="txt-h2">Ranking</h2>
    <hr>                                                                                    
      <div class="table-responsive">          
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nick</th>
              <th>Estado</th>
            </tr>
          </thead>

          <tbody>
<?php

$r = 1;

if($result3->num_rows>0) 
{

  $x = 1;

  while($row3 = $result3->fetch_assoc()) 
  {

    $rank = $row3['cd_ranking'];
    $nick = $row3['nm_nick'];
    $sigla = $row3['sg_estado'];

    echo "<tr>
            <td>".$r."</td>
            <td>".$nick."</td>
            <td>".$sigla."</td>
          </tr>";

    if ($x == 10) 
    {
      break;
    }

    $x++;
    $r++;

  }
}

?>
          </tbody>
        </table>
      </div>
    </div>


  <div class="" id="propaganda">          
    <a href="https://www.vestibulinhoetec.com.br/home/"><img src="img/props.png" class="img-thumbnail" alt="Cinque Terre" width="304" height="236"> </a>
  </div>

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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

</body>
</html>