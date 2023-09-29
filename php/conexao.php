<?php  
define('HOST', 'localhost');
define('USUARIO','root');
define('SENHA', 'usbw');
define('DB', 'db_taverna');

$conexao = mysqli_connect(HOST,USUARIO,SENHA,DB) or die('Não foi possivel conectar');

?>