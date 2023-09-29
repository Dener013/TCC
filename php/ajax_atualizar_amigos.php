
<?php

include('conexao.php');


$ideu = $_GET['meuid'];

$sqlAmigos = "select * from tb_notificacao where cd_de = $ideu and ic_notificacao = true or cd_para = $ideu and ic_notificacao = true;";

$resultAmigos = $conexao->query($sqlAmigos);


$sqlMinhaMesas = "select * from tb_not_mesa where cd_usuario = $ideu and ic_notificacao = 1"; 

$resultMinhasMesas = $conexao->query($sqlMinhaMesas);
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
                  <img src='perfil/barbaro-fundo.jpg'>
                </div>

                <div id='info-mesa'>
                  <h3>$nomeMesa</h3>
                  <h4>$ultima $hora</h4>
                </div>

             </div>";
  ?>
   <!-- Modal -->
    <div class="modal fade" id="my-modal" role="dialog" >
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content" id="mensagem-modal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Excluir Mesa</h4>
          </div>
          <div class="modal-body">
            <p>Você tem certeza de que quer excluir <?php echo "$nomeMesa" ?> ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" id="mensagem-enviar" data-dismiss="modal" onclick="excluirMesa(<?php echo "$cdMesa, $ideu"; ?>)">Excluir</button>
            <button type="button" class="btn btn-default" id="mensagem-cancelar" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
        
      </div>
    </div>

  <?php

      }
    }
  }

}

?>