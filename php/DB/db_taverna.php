<?php

$servername = "localhost";
$username = "root";
$password = "usbw";

//criar conexão
$conn = new mysqli($servername, $username, $password);

//checar a conexão
if($conn->connect_error) {
	die("Connection failed:".$conn->connect_error);
}

//create db
$sql = "drop database if exists db_taverna;";
$conn->query($sql);

$sql2 = "create database db_taverna;";
if($conn->query($sql2) === TRUE) {
	echo "Base Criada";
} else {
	echo "Erro ao criar Base: ".$conn->error;
}

$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "db_taverna";

//criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

//checar conexão
if($conn->connect_error) {
	die("Connection failed:".$conn->connect_error);
}

$arr = array(
	"sql0" => "SET FOREIGN_KEY_CHECKS = 0;",


	"sql1" => "create table tb_estado(
cd_estado int,
sg_estado char(2),
nm_estado varchar(45),
constraint pk_estado
	primary key(cd_estado));",


	"sql2" => "create table tb_noticia(
cd_noticia int,
nm_noticia varchar(80),
img_noticia varchar(500),
ds_noticia varchar(5000),
nm_autor varchar(45),
dt_noticia date,
constraint pk_noticia
	primary key(cd_noticia));",


	"sql3" => "create table tb_ranking(
cd_ranking int,
img_ranking varchar(500),
constraint pk_ranking
	primary key(cd_ranking));",


	"sql4" => "create table tb_cidade(
cd_cidade int,
nm_cidade varchar(70),
cd_estado int,
constraint pk_cidade
	primary key(cd_cidade),
constraint fk_cidade_estado foreign key (cd_estado) references tb_estado (cd_estado));",


	"sql5" => "create table tb_bairro(
cd_bairro int,
nm_bairro varchar(70),
cd_cidade int,
constraint pk_bairro
	primary key(cd_bairro),
constraint fk_bairro_cidade foreign key (cd_cidade) references tb_cidade (cd_cidade));",


	"sql6" => "create table tb_perfil(
cd_usuario int,
nm_usuario varchar(80),
ds_bio varchar(400),
nm_nick varchar(30),
cd_senha char(16),
dt_nascimento date,
nm_email varchar(30),
cd_bairro int,
cd_cidade int,
qt_xp int,
cd_ranking int,
img_usuario varchar(200),
img_fundo varchar(200),
ic_confirmar bool,
cd_confirmar varchar(200),
constraint pk_perfil
	primary key(cd_usuario),
constraint fk_perfil_ranking foreign key (cd_ranking) references tb_ranking (cd_ranking),
constraint fk_perfil_bairro foreign key (cd_bairro) references tb_bairro (cd_bairro));",


"sql7" => "create table tb_mesa(
cd_mesa int,
nm_mesa varchar(45),
nm_sistema varchar(45),
qt_usuario int,
qt_limite int,
dt_criacao date,
ic_privado bool,
cd_senha char(16),
img_mesa varchar(500),
cd_bairro int,
cd_cidade int,
cd_admin int,
constraint pk_mesa
	primary key(cd_mesa));",


	"sql8" => "create table tb_notificacao(
cd_notificacao int auto_increment,
cd_de int,
cd_para int,
ic_notificacao bool,
constraint pk_notificacao
	primary key(cd_notificacao),
constraint fk_dede foreign key (cd_de) references tb_perfil (cd_usuario),
constraint fk_para foreign key (cd_para) references tb_perfil (cd_usuario));",


	"sql9" => "create table tb_not_mesa(
cd_notificacao int auto_increment,
cd_mesa int,
cd_usuario int,
ic_notificacao bool,
constraint pk_notificacao_mesa
	primary key(cd_notificacao),
constraint fk_not_mesa foreign key (cd_mesa) references tb_mesa (cd_mesa));",


	"sql10" => "create table tb_feedback(
cd_comentario int auto_increment,
cd_para int,
cd_de int,
nm_nick varchar(80),
ds_feedback varchar(2000),
dt_feedback date,
constraint pk_comentario
	primary key(cd_comentario),
constraint fk_de foreign key (cd_de) references tb_perfil (cd_usuario));",

	"sql11" => "create table tb_chat(
cd_mensagem int auto_increment,
cd_de int,
cd_para int,
ds_mensagem varchar(80),
dt_mensagem varchar(20),
dt_hora varchar(20),
ds_anexo varchar(200),
constraint pk_mensagem
	primary key(cd_mensagem),
constraint fk_dedede foreign key (cd_de) references tb_perfil (cd_usuario),
constraint fk_parara foreign key (cd_para) references tb_perfil (cd_usuario));",

"sql12" => "create table tb_chat_mesa(
cd_mensagem int auto_increment,
cd_de int,
cd_mesa int,
ds_mensagem varchar(80),
dt_mensagem varchar(20),
dt_hora varchar(20),
ds_anexo varchar(200),
constraint pk_mensagem_chat
	primary key(cd_mensagem),
constraint fk_dededede foreign key (cd_de) references tb_perfil (cd_usuario),
constraint fk_para_mesa foreign key (cd_mesa) references tb_mesa (cd_mesa));",

"sql13" => "create table tb_omp(
cd_mesa int,
cd_usuario int,
constraint fk_omp_perfil foreign key (cd_mesa) references tb_mesa (cd_mesa),
constraint fk_omp_mesa foreign key (cd_usuario) references tb_perfil (cd_usuario));",

);

$x = 0;

foreach ($arr as $valor) {
	if($conn->query($valor) === TRUE) {
		echo "Tabela ".$x." criada <br><br>";
		$x = $x + 1;
	} else {
		echo "Erro ao criar Tabela ".$x.": ".$conn->error."<br><br>";
		$x = $x + 1;
	}
}

//fechar conexao
$conn->close();
?>