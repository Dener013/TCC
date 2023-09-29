$("#info-delee").attr("readonly", true);

function editar(){
	var visivel = document.getElementById("salvar").style.visibility;

	if (visivel == "hidden" || visivel == "") {
		document.getElementById("cancelar").style.display = "inline";
		document.getElementById("salvar").style.display = "inline";
		document.getElementById("info-delee").style.border = "1px solid brown";
		document.getElementById("info-delee").style.borderRadius = "5px";
		document.getElementById("txt-bios").style.border = "1px solid brown";
    document.getElementById("regiao-box").style.display = "inline";
		$("#info-delee").attr("readonly", false);
		$("#txt-bios").attr("readonly", false);
    document.getElementById("editar").style.display = "none";
	}
	
}

function salvar(){
	var nick = document.getElementById("info-delee").value;
	var bio = document.getElementById("txt-bios").value;
  var bairro = $('#id-bairro').val();
	window.location.href = 'php/editar.php?editar='+nick+"&outro="+bio+"&bairro="+bairro;	
	document.getElementById("txt-bios").style.border = "none";
  $("#info-delee").attr("readonly", true);
    $("#txt-bios").attr("readonly", true);
    document.getElementById("editar").style.display = "inline";
}

function cancelar(nick){
	document.getElementById("salvar").style.display = "none";
	document.getElementById("cancelar").style.display = "none";
	document.getElementById("info-delee").style.border = "none";
	document.getElementById("txt-bios").style.border = "none";
  document.getElementById("regiao-box").style.display = "none";
  $("#info-delee").attr("readonly", true);
    $("#txt-bios").attr("readonly", true);
    document.getElementById("editar").style.display = "inline";
}

function fazerComentario(meuid, iddele){
	var comentario = document.getElementById('txt-comen').value;
	var meuid = meuid;
	var iddele = iddele;
	var estrela = $("input[name='fb']:checked").val();
	var url = 'php/ajax_comentario.php?comentario='+comentario+'&meuid='+meuid+'&iddele='+iddele+'&estrela='+estrela;
        $.get(url, function(dataReturn) {
          $('#box-feed').html(dataReturn);
        });
}

/*function excluirComentario(idcomen, iddele){
	var idcomen = idcomen;
	var iddele = iddele;

   var url = 'php/ajax_excluir_comentario.php?idcomentario='+idcomen+'&iddele='+iddele;
   		$.get(url, function(dataReturn) {
          $('#box-feed').html(dataReturn);
        });

}

function editarComentario(idcomen, iddele){
	var newcomen = document.getElementById('txt-comen').value;
	var idcomen = idcomen;
	var iddele = iddele;

    var url = 'php/ajax_editar_comentario.php?idcomentario='+idcomen+'&iddele='+iddele+'$newcomen='+newcomen;
    	$.get(url, function(dataReturn) {
          $('#box-feed').html(dataReturn);
        });

}
*/


function chooseBarbaro(id){
  var meuid = id;
  var barbaro = "barbaro";

  var url = 'php/ajax_icone.php?meuid='+meuid+'&icone='+barbaro;
        $.get(url, function(dataReturn) {
          $('#ajax').html(dataReturn);
        });
}

function chooseMago(id){
  var meuid = id;
  var mags = "mago";

  var url = 'php/ajax_icone.php?meuid='+meuid+'&icone='+mags;
        $.get(url, function(dataReturn) {
          $('#ajax').html(dataReturn);
        });
}

function chooseCavaleiro(id){
  var meuid = id;
  var cavalis = "cavaleiro";

  var url = 'php/ajax_icone.php?meuid='+meuid+'&icone='+cavalis;
        $.get(url, function(dataReturn) {
          $('#ajax').html(dataReturn);
        });
}

function chooseLadino(id){
  var meuid = id;
  var ladis = "ladino";

  var url = 'php/ajax_icone.php?meuid='+meuid+'&icone='+ladis;
        $.get(url, function(dataReturn) {
          $('#ajax').html(dataReturn);
        });
}


 function buscar_cidades(){
      var estado = $('#inputEstado').val();
      if(estado){
        var url = 'php/ajax_buscar_cidades.php?estado='+estado;
        $.get(url, function(dataReturn) {
          $('#cidade').html(dataReturn);
        });
         var url = 'php/ajax_limpar_bairros.php';
        $.get(url, function(dataReturn) {
          $('#id-bairro').html(dataReturn);
        });
      }
    }

    function buscar_bairros(){
      var cidade = $('#id-cidade').val();
     if(cidade){
        var url = 'php/ajax_buscar_bairros.php?cidade='+cidade;
        $.get(url, function(dataReturn) {
          $('#bairro').html(dataReturn);
        });

      }
    }

    function buscar_regiao(){
      var bairro = $('#id-bairro').val();
      var url = 'php/ajax_regiao.php?bairro='+bairro;

      if(bairro != "" || bairro != null){
        $.get(url, function(dataReturn) {
          $('#lista-jogadores').html(dataReturn);
        });
      }
      
      else{
        var cidade = $('#id-cidade').val();
        var url = 'php/ajax_regiao.php?cidade='+cidade;
        $.get(url, function(dataReturn) {
          $('#lista-jogadores').html(dataReturn);
        });
      }
    }