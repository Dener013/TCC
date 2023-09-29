
<?php
include('conexao.php');

$cidade = $_GET['cidade'];

$sql = $conexao->query("SELECT * FROM tb_bairro WHERE cd_cidade = $cidade ORDER BY nm_bairro");

while($row = mysqli_fetch_array($sql)){
  $arrBairros[$row['cd_bairro']] = $row['nm_bairro'];
}

?>


<select name="bairro" id="id-bairro" class="form-control">
  <?php foreach($arrBairros as $value => $nome){
    echo "<option value='{$value}'>{$nome}</option>";
  }
?>
</select>


