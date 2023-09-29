<?php
include('conexao.php');
session_start();
$ideu = $_SESSION['id'];

$sql = "select tb_mesa.*, tb_perfil.*, tb_bairro.nm_bairro, tb_cidade.nm_cidade, tb_estado.nm_estado from tb_mesa
          join tb_omp on tb_mesa.cd_mesa = tb_omp.cd_mesa
            join tb_perfil on tb_omp.cd_usuario = tb_perfil.cd_usuario
              join tb_bairro on tb_mesa.cd_bairro = tb_bairro.cd_bairro
                join tb_cidade on tb_cidade.cd_cidade = tb_bairro.cd_cidade
                  join tb_estado on tb_cidade.cd_estado = tb_estado.cd_estado;";

$result = $conexao->query($sql);


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
        <th>Mestre</th>
      </tr>
    </thead>
    <tbody id="myTable">
<?php
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