 function perfil(a){
  window.location.href = 'configuracoes.php?perfil='+a;
 }

 function mensagem(a){
  var a = a;
  window.location.href = 'php/notificacao.php?usuario='+a;
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

    function limpar(){

      document.getElementById('myInput').value='';

      var url = 'php/ajax_limpar.php';

        $.get(url, function(dataReturn) {
          $('#lista-jogadores').html(dataReturn);
        });
    }


$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});