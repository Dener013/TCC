<?php
include('conexao.php');

$bairro = $_GET['bairro'];

if ($bairro != "" || $bairro != null) {
  $sql = "select tb_perfil.nm_nick, tb_bairro.nm_bairro, tb_cidade.nm_cidade, tb_estado.nm_estado
                            from tb_perfil join tb_bairro 
                                on tb_perfil.cd_bairro = tb_bairro.cd_bairro
                                    join tb_cidade
                                        on tb_cidade.cd_cidade = tb_bairro.cd_cidade
                                            join tb_estado
                                                on tb_estado.cd_estado = tb_cidade.cd_estado
                                                   WHERE tb_bairro.cd_bairro = $bairro ORDER BY tb_perfil.nm_nick;"; 
                                                   $result = $conexao->query($sql);

}else
{
  $cidade = $_GET['cidade'];
  $sql = "select tb_perfil.nm_nick, tb_cidade.nm_cidade, tb_estado.nm_estado
                            from tb_perfil join tb_bairro 
                                on tb_perfil.cd_bairro = tb_bairro.cd_bairro
                                    join tb_cidade
                                        on tb_cidade.cd_cidade = tb_bairro.cd_cidade
                                            join tb_estado
                                                on tb_estado.cd_estado = tb_cidade.cd_estado
                                                   WHERE tb_cidade.cd_cidade = $bairro ORDER BY tb_perfil.nm_nick;";

$result = $conexao->query($sql);
}


session_start();
$nick = $_SESSION['nick'];

?>


<table class="table table-bordered table-striped" id="lista-jogadores">
    <thead>
      <tr class="menu-jogadores">
        <th>Nickname</th>
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
    $nicksql = $row['nm_nick'];
    if ($nick != $nicksql) {
      $nicksql = $row['nm_nick'];
    $sigla = $row['nm_estado'];
    $cidade = $row['nm_cidade'];
    $bairro = $row['nm_bairro'];

    echo "<tr data-target='#$nicksql' data-toggle='modal'>
            <td>".$nicksql."</td>
            <td>".$sigla."</td>
            <td>".$cidade."</td>
            <td>".$bairro."</td>
          </tr>

           <div class='modal fade' id='$nicksql' role='dialog'>
            <div class='modal-dialog'>
            
              <!-- Modal content-->
              <div class='modal-content' id='mensagem'>
                <div class='modal-header'>
                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  <h4 class='modal-title'>Amizade</h4>
                </div>
                <div class='modal-body'>
                  <p>Gostaria de enviar uma solicitação de Amizade?</p>
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-default' data-dismiss='modal' id='mensagem-enviar'>Enviar</button>
                  <button type='button' class='btn btn-default' data-dismiss='modal' id='mensagem-cancelar'>Cancelar</button>
                </div>
              </div>
              
            </div>
          </div>";
    }
  }
}

?>
    </tbody>
  </table>