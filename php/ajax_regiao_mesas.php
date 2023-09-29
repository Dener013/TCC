<?php
include('conexao.php');

$bairro = $_GET['bairro'];



if ($bairro != "" || $bairro != null) {
  $sql = "select tb_mesa.*, tb_bairro.nm_bairro, tb_cidade.nm_cidade, tb_estado.nm_estado from tb_mesa
          join tb_omp on tb_mesa.cd_mesa = tb_omp.cd_mesa
            join tb_perfil on tb_omp.cd_usuario = tb_perfil.cd_usuario
              join tb_bairro on tb_mesa.cd_bairro = tb_bairro.cd_bairro
                join tb_cidade on tb_cidade.cd_cidade = tb_bairro.cd_cidade
                  join tb_estado on tb_cidade.cd_estado = tb_estado.cd_estado
                    where tb_bairro.cd_bairro = $bairro ORDER BY tb_mesa.nm_mesa;";
                                                   $result = $conexao->query($sql);

}else
{
  $cidade = $_GET['cidade'];
$sql = "select tb_mesa.*, tb_bairro.nm_bairro, tb_cidade.nm_cidade, tb_estado.nm_estado from tb_mesa
          join tb_omp on tb_mesa.cd_mesa = tb_omp.cd_mesa
            join tb_perfil on tb_omp.cd_usuario = tb_perfil.cd_usuario
              join tb_bairro on tb_mesa.cd_bairro = tb_bairro.cd_bairro
                join tb_cidade on tb_cidade.cd_cidade = tb_bairro.cd_cidade
                  join tb_estado on tb_cidade.cd_estado = tb_estado.cd_estado
                    where tb_cidade.cd_cidade = $cidade ORDER BY tb_mesa.nm_mesa;";

$result = $conexao->query($sql);
}

session_start();
$nick = $_SESSION['nick'];

?>


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
      </tr>
    </thead>
    <tbody id="myTable">
<?php

if($result->num_rows>0) 
{
  while($row = $result->fetch_assoc()) 
  {

    $mesa = $row['nm_mesa'];
    $sistema = $row['nm_sistema'];
    $jogadores = $row['qt_usuario'];
    $privado = $row['ic_privado'];
    $cidade = $row['nm_cidade'];
    $estado = $row['nm_estado'];
    $bairro = $row['nm_bairro'];
   
    if ($privado == 0) {
      $privado = "Aberto";
    }
    else {
      $privado = "Fechado";
    }

    echo "<tr>
            <td>".$mesa."</td>
            <td>".$sistema."</td>
            <td>".$jogadores."</td>
            <td>".$privado."</td>
            <td>".$estado."</td>
            <td>".$cidade."</td>
            <td>".$bairro."</td>
          </tr>";

  }
}

?>
    </tbody>
  </table>