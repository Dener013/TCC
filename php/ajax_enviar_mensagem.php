
<?php

include('conexao.php');
$foto = isset( $_FILE[ 'attach' ] ) ? $_FILE[ 'attach' ] : null ;

if ($foto == null) {
  
$meuid = $_GET['meuid'];

$iddele = $_GET['iddele'];

$msg = $_GET['mensagem'];

$sqlInsert = "INSERT INTO tb_chat (cd_de, cd_para, ds_mensagem, dt_mensagem, dt_hora, ds_anexo) values ($meuid, $iddele, '$msg', (select CURDATE()), (SELECT TIME_FORMAT(CURTIME(), '%H:%i')), null)";

if ($conexao->query($sqlInsert) === true){

}else{
  echo "erro =".$conexao->error;;
}


$sqlSelect = "select *, date_format(dt_mensagem, '%d-%m-%Y') as dt_mensagem from tb_chat where cd_de = $meuid and cd_para = $iddele or cd_de = $iddele and cd_para = $meuid";

$resultSelect = $conexao->query($sqlSelect);

echo "<div id='msg-chat'>";

while ($row = $resultSelect->fetch_assoc()) {
  $mensagem = $row['ds_mensagem'];
  $hora = $row['dt_hora'];
  $mandante = $row['cd_de'];
  $remetente = $row['cd_para'];
  $hora = $row['dt_hora'];

  if ($mensagem != null) {
    if ($mandante == $meuid) {
      echo "<div id='msg-eu'>
          <div id='msg'>
            $mensagem
          </div>
          <div id='hora'>
            $hora
          </div>
        </div>";

    }else{

      echo "<div id='msg-amigo'>
          <div id='msg'>
            $mensagem
          </div>
          <div id='hora'>
            $hora
          </div>
        </div>";

    }
  }   
}

echo "</div>";

}else{
  $meuid = $_GET['meuid'];

$iddele = $_GET['iddele'];
  $msg = isset( $_GET[ 'msg' ] ) ? $_GET[ 'msg' ] : null ;
  // Largura máxima em pixels
    $largura = 10050;
    // Altura máxima em pixels
    $altura = 10080;
    // Tamanho máximo do arquivo em bytes
    $tamanho = 100000;

    $error = array();

      // Verifica se o arquivo é uma imagem
      if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
         $error[1] = "Isso não é uma imagem.";
      } 
  
    // Pega as dimensões da imagem
    $dimensoes = getimagesize($foto["tmp_name"]);
  
    // Verifica se a largura da imagem é maior que a largura permitida
    if($dimensoes[0] > $largura) {
      $error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
    }

    // Verifica se a altura da imagem é maior que a altura permitida
    if($dimensoes[1] > $altura) {
      $error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
    }
    
    // Verifica se o tamanho da imagem é maior que o tamanho permitido
    if($foto["size"] > $tamanho) {
        $error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
    }

    // Se não houver nenhum erro
    if (count($error) == 0) {
    
      // Pega extensão da imagem
      preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

          // Gera um nome único para a imagem
          $nome_imagem = md5(uniqid(time())) . "." . $ext[1];

          // Caminho de onde ficará a imagem
          $caminho_imagem = "usuario/" . $nome_imagem;

      // Faz o upload da imagem para seu respectivo caminho
      move_uploaded_file($foto["tmp_name"], $caminho_imagem);
    
      // Insere os dados no banco
      $result = $conexao->query("INSERT INTO tb_chat (cd_de, cd_para, ds_mensagem, dt_mensagem, dt_hora, ds_anexo) values ($meuid, $iddele, '$msg', (select CURDATE()), (SELECT TIME_FORMAT(CURTIME(), '%H:%i')), $foto)");
    
      // Se os dados forem inseridos com sucesso
      if ($result === TRUE){
        echo "Você foi cadastrado com sucesso.";
      }
    }
  
    // Se houver mensagens de erro, exibe-as
    if (count($error) != 0) {
      foreach ($error as $erro) {
        echo $erro . "<br />";
      }
    }
  }


?>


