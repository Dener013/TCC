
<?php
include('conexao.php');

$estado = $_GET['estado'];

$sql = $conexao->query("SELECT * FROM tb_cidade WHERE cd_estado = $estado ORDER BY nm_cidade");

while($row = mysqli_fetch_array($sql)){
  $arrCidades[$row['cd_cidade']] = $row['nm_cidade'];
}

?>


<select name="cidade" id="id-cidade" class="form-control" onchange="buscar_bairros()">
  <?php foreach($arrCidades as $value => $nome){
    echo "<option value='{$value}'>{$nome}</option>";
  }
?>
</select>


