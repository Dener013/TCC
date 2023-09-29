function amizade(meuid, amigoid){
    var meuid = meuid;
    var amigoid = amigoid; 
    var url = 'php/ajax_amizade.php?meuid='+meuid+'&amigoid='+amigoid;
        $.get(url, function(dataReturn) {
          $('#mensagem-aja').html(dataReturn);
        });
  }

  function desamizade(meuid, amigoid){
    var meuid = meuid;
    var amigoid = amigoid;
    var url = 'php/ajax_desamizade.php?meuid='+meuid+'&amigoid='+amigoid;
        $.get(url, function(dataReturn) {
          $('#mensagem-aja').html(dataReturn);
        });
  
  }