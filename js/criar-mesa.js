function mesaNome(){
    var nome = document.getElementById('mesa').value;
    nome = nome.length;

    if (nome < 3) {
      document.getElementById('mesa').style.borderBottom = "2px solid red";
      document.getElementById('nome-error').style.visibility = "visible";
      document.getElementById("criar").disabled = true;
    }else{
      document.getElementById('mesa').style.border = "none";
      document.getElementById('nome-error').style.visibility = "hidden";
      document.getElementById("criar").disabled = false;
    }
}

function sistemaNome(){
    var nome = document.getElementById('sistema').value;
    nome = nome.length;

    if (nome < 3) {
      document.getElementById('sistema').style.borderBottom = "2px solid red";
      document.getElementById('sistema-error').style.visibility = "visible";
      document.getElementById("criar").disabled = true;
    }else{
      document.getElementById('sistema').style.border = "none";
      document.getElementById('sistema-error').style.visibility = "hidden";
      document.getElementById("criar").disabled = false;
    }
}


function limiteSenha(){
    var nome = document.getElementById('senha').value;
    nome = nome.length;

    if (nome < 8) {
      document.getElementById('senha').style.borderBottom = "2px solid red";
      document.getElementById('senha-error').style.visibility = "visible";
      document.getElementById("criar").disabled = true;
    }else{
      document.getElementById('senha').style.border = "none";
      document.getElementById('senha-error').style.visibility = "hidden";
      document.getElementById("criar").disabled = false;
    }
}


function confSenha(){
    var senha = document.getElementById('senha').value;
    var csenha = document.getElementById('confsenha').value;

    if (senha != csenha) {
      document.getElementById('confsenha').style.borderBottom = "2px solid red";
      document.getElementById('csenha-error').style.visibility = "visible";
      document.getElementById("criar").disabled = true;
    }else{
      document.getElementById('confsenha').style.border = "none";
      document.getElementById('csenha-error').style.visibility = "hidden";
      document.getElementById("criar").disabled = false;
    }
}







 function cadeira(){
      var cadeira = document.getElementById("cadeira").value;
      if (cadeira == 3) {
        document.getElementById("isso").style.background = "url('img/mesa3.png')";
        document.getElementById("isso").style.transitionDuration = "1s";
        document.getElementById("isso").style.backgroundRepeat = "no-repeat";
        document.getElementById("isso").style.backgroundPosition = "center";
      }
      else if (cadeira == 4) {
        document.getElementById("isso").style.background = "url('img/mesa4.png')";
        document.getElementById("isso").style.transitionDuration = "1s";
        document.getElementById("isso").style.backgroundRepeat = "no-repeat";
        document.getElementById("isso").style.backgroundPosition = "center";
      }
      else if (cadeira == 5) {
        document.getElementById("isso").style.background = "url('img/mesa5.png')";
        document.getElementById("isso").style.transitionDuration = "1s";
        document.getElementById("isso").style.backgroundRepeat = "no-repeat";
        document.getElementById("isso").style.backgroundPosition = "center";
      }
      else if (cadeira == 6) {
        document.getElementById("isso").style.background = "url('img/mesa6.png')";
        document.getElementById("isso").style.transitionDuration = "1s";
        document.getElementById("isso").style.backgroundRepeat = "no-repeat";
        document.getElementById("isso").style.backgroundPosition = "center";
      }
      else if (cadeira == 7) {
        document.getElementById("isso").style.background = "url('img/mesa7.png')";
        document.getElementById("isso").style.transitionDuration = "1s";
        document.getElementById("isso").style.backgroundRepeat = "no-repeat";
        document.getElementById("isso").style.backgroundPosition = "center";
      }
      else if (cadeira == 8) {
        document.getElementById("isso").style.background = "url('img/mesa8.png')";
        document.getElementById("isso").style.transitionDuration = "1s";
        document.getElementById("isso").style.backgroundRepeat = "no-repeat";
        document.getElementById("isso").style.backgroundPosition = "center";
      }
      else if (cadeira == 9) {
        document.getElementById("isso").style.background = "url('img/mesa9.png')";
        document.getElementById("isso").style.transitionDuration = "1s";
        document.getElementById("isso").style.backgroundRepeat = "no-repeat";
        document.getElementById("isso").style.backgroundPosition = "center";
      }
      else if (cadeira == 10) {
        document.getElementById("isso").style.background = "url('img/mesa10.png')";
        document.getElementById("isso").style.transitionDuration = "1s";
        document.getElementById("isso").style.backgroundRepeat = "no-repeat";
        document.getElementById("isso").style.backgroundPosition = "center";
      }
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