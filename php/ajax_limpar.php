<?php
include('conexao.php');

$sql = "select r.cd_ranking, p.nm_nick, e.nm_estado, b.nm_bairro, c.nm_cidade
            from tb_ranking as r join tb_perfil as p
              on r.cd_ranking = p.cd_ranking
                join tb_bairro as b
                  on p.cd_bairro = b.cd_bairro
                    join tb_cidade as c
                      on b.cd_cidade = c.cd_cidade
                        join tb_estado as e
                          on c.cd_estado = e.cd_estado
                            order by r.cd_ranking asc;";

$result = $conexao->query($sql);

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