<?php
$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "db_taverna";

//create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if($conn->connect_error) {
	die("Connection failed:".$conn->connect_error);
}

//array com os procedures
$arr = array(
	"sql1" => "CREATE PROCEDURE Login(
in nick varchar(30),
in senha char(16))
begin
	select nm_nick, cd_senha from tb_perfil
		where nm_nick = nick
			and cd_senha = senha;
end",

	"sql2" => "CREATE PROCEDURE CadastroValida(
in nick varchar(30),
in email varchar(30))
begin
	select nm_nick, nm_email from tb_perfil
		where nm_email = email
			and nm_nick = nick;
end",

	"sql3" => "CREATE PROCEDURE Cadastrar(
in nome varchar(15),
in sobrenome varchar(45),
in bio varchar(400),
in nick varchar(30),
in senha char(16),
in data varchar(10),
in email varchar(30),
in bairro varchar(45),
in ranking int(45))
begin
	insert into tb_perfil (cd_usuario, nm_usuario, nm_sobrenome, ds_bio, nm_nick, cd_senha, dt_nascimento, nm_email, cd_bairro, qt_xp, cd_ranking) 
	VALUES ((select max(cd_usuario) + 1 from tb_perfil), nome, sobrenome, bio, nick, senha, data, email, (select cd_bairro from tb_bairro where nm_bairro = bairro), 0 ,(select max(cd_ranking) + 1 from tb_ranking));
end",

	"sql4" => "CREATE PROCEDURE Buscarnoticia(
in info varchar(80))
begin
	SELECT nm_noticia FROM tb_noticia
		WHERE nm_noticia LIKE '%info%';

end",

	"sql5" => "CREATE PROCEDURE BuscarPerfil(
in nick varchar(30),
in bairro varchar(45))
begin
	if (nick != '' || nick != null) then

		select nm_nick from tb_perfil where nick = nm_nick;
		select nm_nick from tb_perfil where nm_nick like 'nick%';

	else

		select tb_perfil.nm_nick, tb_estado.sg_estado, tb_cidade.nm_cidade, tb_bairro.nm_bairro 
			from tb_perfil as p join tb_bairro as b on b.cd_bairro = p.cd_bairro
				join tb_cidade as c on c.cd_cidade = b.cd_cidade
					join tb_estado as e on e.cd_estado = c.cd_estado
						where (select nm_bairro from tb_bairro) = bairro;

	end if;

end",

	"sql6" => "CREATE PROCEDURE Rank(
in rank varchar(45))
begin
	select tb_rank.nm_posicao_rank, tb_perfil.nm_nick, tb_bairro.nm_bairro, tb_cidade.nm_cidade, tb_estado.sg_estado from tb_rank
		join tb_perfil on tb_perfil.cd_rank = tb_rank.cd_rank
			join tb_bairro on tb_perfil.cd_bairro = tb_bairro.cd_bairro
				join tb_cidade on tb_bairro.cd_cidade = tb_cidade.cd_cidade
					join tb_uf on tb_uf.sg_uf = tb_cidade.sg_uf
						where rank = nm_posicao_rank;
end",

	"sql7" => "CREATE PROCEDURE CriarMesa(
in nome varchar(45),
in sistema varchar(45),
in qt int(15),
in privado int(5),
in senha char(16),
in data varchar(10),
in bairro varchar(45))
begin

	if (privado <= 0) then
		INSERT INTO tb_mesa (cd_mesa, nm_mesa, nm_sistema, qt_usuario, dt_criacao, ic_privado, cd_senha, cd_bairro, img_mesa) values ((select max(cd_mesa) + 1 from tb_mesa), nome, sistema, qt, data, 0, NULL, (select cd_bairro from tb_bairro where nm_bairro = bairro), NULL);
	else
		INSERT INTO tb_mesa (cd_mesa, nm_mesa, nm_sistema, qt_usuario, dt_criacao, ic_privado, cd_senha, cd_bairro, img_mesa) values ((select max(cd_mesa) + 1 from tb_mesa), nome, sistema, qt, data, 1, senha, (select cd_bairro from tb_bairro where nm_bairro = bairro), NULL);
	end if;

end",

	"sql8" => "CREATE PROCEDURE ProcurarMesa(
in nome varchar(45),
in sistema varchar(45),
in bairro varchar(45))
begin

	if (nome != '' || nome != null) then

		select tb_mesa.nm_mesa, tb_mesa.nm_sistema, tb_estado.sg_estado, tb_cidade.nm_cidade, tb_bairro.nm_bairro from tb_mesa
				join tb_ordem_mesa_bairro on tb_mesa.cd_mesa = tb_ordem_mesa_bairro.cd_mesa
						join tb_bairro on tb_ordem_mesa_bairro.cd_bairro = tb_bairro.cd_bairro
								join tb_cidade on tb_bairro.cd_cidade = tb_cidade.cd_cidade
										join tb_estado on tb_estado.cd_estado = tb_cidade.cd_estado where tb_bairro.nm_bairro = bairro;

	else if (sistema != '' || sistema != null) then

		select tb_mesa.nm_mesa, tb_mesa.nm_sistema, tb_estado.sg_estado, tb_cidade.nm_cidade, tb_bairro.nm_bairro from tb_mesa
				join tb_ordem_mesa_bairro on tb_mesa.cd_mesa = tb_ordem_mesa_bairro.cd_mesa
						join tb_bairro on tb_ordem_mesa_bairro.cd_bairro = tb_bairro.cd_bairro
								join tb_cidade on tb_bairro.cd_cidade = tb_cidade.cd_cidade
										join tb_estado on tb_estado.cd_estado = tb_cidade.cd_estado where tb_mesa.nm_sistema = sistema;

	else if (bairro != '' || bairro != null) then

		select tb_mesa.nm_mesa, tb_mesa.nm_sistema, tb_estado.sg_estado, tb_cidade.nm_cidade, tb_bairro.nm_bairro from tb_mesa
				join tb_ordem_mesa_bairro on tb_mesa.cd_mesa = tb_ordem_mesa_bairro.cd_mesa
						join tb_bairro on tb_ordem_mesa_bairro.cd_bairro = tb_bairro.cd_bairro
								join tb_cidade on tb_bairro.cd_cidade = tb_cidade.cd_cidade
										join tb_estado on tb_estado.cd_estado = tb_cidade.cd_estado where tb_mesa.nm_mesa = nome or tb_mesa.nm_mesa like 'nome%';

	end if;

end",

	"sql9" => "CREATE PROCEDURE AtualizarConta(
in id varchar(5),
in nick varchar(45),
in senha char(16),
in bio varchar(400))
begin

	if(nick != '' || nick != null) then
		update tb_perfil set nm_nick = nick where cd_usuario = id;
	end if;

	if(senha != '' || senha != null) then
		update tb_perfil set cd_senha = senha where cd_usuario = id;
	end if;

	if(bio != '' || bio != null) then
		update tb_perfil set ds_bio = bio where cd_usuario = id;
	end if;

end",

	"sql10" => "CREATE PROCEDURE AtualizarMesa(
in antigonome varchar(45),
in nome varchar(45),
in sistema varchar(45))
begin
	
	if(nomeantigo != '' || nomeantigo != null) then
		update tb_mesa set nm_mesa = nome where nm_mesa = nomeantigo;
	end if;

	if(sistema != '' || sistema != null) then
		update tb_mesa set nm_sistema = sistema where nm_sistema = nome;
	end if;

end",

	"sql11" => "CREATE PROCEDURE DeletarConta(
in nick varchar(45),
in senha char(16))
begin
	
	delete from tb_perfil where nm_nick = nick and cd_senha = senha;

end",

	"sql12" => "CREATE PROCEDURE DeletarMesa(
in nome varchar(45),
in id int(16))
begin
	
	delete from tb_mesa where nm_mesa = nick and (select cd_usuario from tb_perfil join tb_ordem_mesa_perfil on tb_perfil.cd_usuario = tb_ordem_mesa_perfil.cd_usuario join tb_mesa on tb_mesa.cd_mesa = tb_ordem_mesa_perfil.cd_mesa) = id;

end"

);


//foreach para rodar todos os procedures de uma vez
$x = 0;

foreach ($arr as $valor) {
	if($conn->query($valor) === TRUE) {
		echo "Procedure ".$x." criada <br><br>";
		$x = $x + 1;
	} else {
		echo "Erro ao criar Procedure ".$x.": ".$conn->error."<br><br>";
		$x = $x + 1;
	}
}

//close connection
$conn->close();

?>