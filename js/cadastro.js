
document.getElementById("btn-cadastrar3").disabled = true;

var termost;

function proximo2(){

		var nome, nick, data, senha, confsenha, senha2;

		nome = document.getElementById('txt-nome').value;
		nome = nome.length;
		nick = document.getElementById('txt-nick').value;
		nick = nick.length;
		data = document.getElementById('txt-data').value;
		senha = document.getElementById('txt-senha').value;
		senha2 = senha.length;
		confsenha = document.getElementById('txt-confsenha').value;

		if (senha == confsenha) {
			if (termost != false && termost != "undefined" && nome >= 2 && nick >= 2 && data != null && data != "" && senha2 >= 8) {
				document.getElementById('box-cadastro').style.display = "none";
				document.getElementById('box-cadastro3').style.display = "inline";				
			}else{
				alert("Preencha as informações corretamente!");	
			}
		}	
	}	


function proximo3(){
		document.getElementById('box-cadastro3').style.display = "none";
		document.getElementById('box-cadastro2').style.display = "inline";
	}





$('input:radio[name="icon"]').change(
function(){
    if (this.value == "barbaro") {
       	document.getElementById("barbaroimg").style.opacity = "1";
        document.getElementById("magoimg").style.opacity = "0.2";
		document.getElementById("ladinoimg").style.opacity = "0.2";
		document.getElementById("cavaleiroimg").style.opacity = "0.2";
		document.getElementById("btn-cadastrar3").disabled = false;
    }
    if (this.value == "mago") {
        document.getElementById("magoimg").style.opacity = "1";
        document.getElementById("barbaroimg").style.opacity = "0.2";
		document.getElementById("ladinoimg").style.opacity = "0.2";
		document.getElementById("cavaleiroimg").style.opacity = "0.2";
		document.getElementById("btn-cadastrar3").disabled = false;
    }
    if (this.value == "ladino") {
        document.getElementById("ladinoimg").style.opacity = "1";
        document.getElementById("magoimg").style.opacity = "0.2";
		document.getElementById("barbaroimg").style.opacity = "0.2";
		document.getElementById("cavaleiroimg").style.opacity = "0.2";
		document.getElementById("btn-cadastrar3").disabled = false;
    }
    if (this.value == "cavaleiro") {
        document.getElementById("cavaleiroimg").style.opacity = "1";
       	document.getElementById("magoimg").style.opacity = "0.2";
		document.getElementById("ladinoimg").style.opacity = "0.2";
		document.getElementById("barbaroimg").style.opacity = "0.2";
		document.getElementById("btn-cadastrar3").disabled = false;
    }
});



	function BarbaroOver(){ 
		document.getElementById("mago").style.transitionDuration = "0.2s";
		document.getElementById("ladino").style.transitionDuration = "0.2s";
		document.getElementById("cavaleiro").style.transitionDuration = "0.2s";

		document.getElementById("mago").style.opacity = "0.2";
		document.getElementById("ladino").style.opacity = "0.2";
		document.getElementById("cavaleiro").style.opacity = "0.2";
	}
	function BarbaroOut(){
		document.getElementById("mago").style.opacity = "1";
		document.getElementById("cavaleiro").style.opacity = "1";
		document.getElementById("ladino").style.opacity = "1";
	}


	function MagoOver(){ 
		document.getElementById("barbaro").style.transitionDuration = "0.2s";
		document.getElementById("ladino").style.transitionDuration = "0.2s";
		document.getElementById("cavaleiro").style.transitionDuration = "0.2s";

		document.getElementById("barbaro").style.opacity = "0.2";
		document.getElementById("ladino").style.opacity = "0.2";
		document.getElementById("cavaleiro").style.opacity = "0.2";
	}
	function MagoOut(){
		document.getElementById("barbaro").style.opacity = "1";
		document.getElementById("cavaleiro").style.opacity = "1";
		document.getElementById("ladino").style.opacity = "1";
	}

	function LadinoOver(){ 
		document.getElementById("mago").style.transitionDuration = "0.2s";
		document.getElementById("barbaro").style.transitionDuration = "0.2s";
		document.getElementById("cavaleiro").style.transitionDuration = "0.2s";

		document.getElementById("mago").style.opacity = "0.2";
		document.getElementById("barbaro").style.opacity = "0.2";
		document.getElementById("cavaleiro").style.opacity = "0.2";
	}
	function LadinoOut(){
		document.getElementById("mago").style.opacity = "1";
		document.getElementById("cavaleiro").style.opacity = "1";
		document.getElementById("barbaro").style.opacity = "1";
	}

	function CavaleiroOver(){ 
		document.getElementById("mago").style.transitionDuration = "0.2s";
		document.getElementById("ladino").style.transitionDuration = "0.2s";
		document.getElementById("barbaro").style.transitionDuration = "0.2s";

		document.getElementById("mago").style.opacity = "0.2";
		document.getElementById("ladino").style.opacity = "0.2";
		document.getElementById("barbaro").style.opacity = "0.2";
	}
	function CavaleiroOut(){
		document.getElementById("mago").style.opacity = "1";
		document.getElementById("barbaro").style.opacity = "1";
		document.getElementById("ladino").style.opacity = "1";
	}











	function nome(){
		var nome = document.getElementById('txt-nome').value;
		var x = nome.length;
		if (x <= 2) {
			document.getElementById("txt-nome").style.borderBottom = "2px solid red";
			document.getElementById("nome-error").style.visibility = "visible";			
		}
		else{
			document.getElementById("txt-nome").style.borderBottom = "2px solid #194544";
			document.getElementById("nome-error").style.visibility = "hidden";
		}
	}

	function senhalimite(){
		var senha = document.getElementById('txt-senha').value;
		var x = senha.length;
		if (x <= 8) {
			document.getElementById("txt-senha").style.borderBottom = "2px solid red";
			document.getElementById("limitesenha-error").style.visibility = "visible";
		}
		else{
			document.getElementById("txt-senha").style.borderBottom = "2px solid #194544";
			document.getElementById("limitesenha-error").style.visibility = "hidden";
		}
	}

	function nick(){
		var nome = document.getElementById('txt-nick').value;
		var x = nome.length;

		if (x <= 2) {
			document.getElementById("txt-nick").style.borderBottom = "2px solid red";
			document.getElementById("nick-error").style.visibility = "visible";
		}
		else{
			document.getElementById("txt-nick").style.borderBottom = "2px solid #194544";
			document.getElementById("nick-error").style.visibility = "hidden";
		}
	}

	$('input:checkbox[name="termos"]').change(
function(){
    if (this.checked == true) {
    	termost = true;
    }else{
    	termost = false;
    }
});

	function confsenha(){
		var confemail = document.getElementById('txt-confsenha').value;
		var email = document.getElementById('txt-senha').value;

		if (confemail != email) {
			document.getElementById("txt-confsenha").style.borderBottom = "2px solid red";
			document.getElementById("senha-error").style.visibility = "visible";
			document.getElementById("btn-cadastrar2").disabled = true;
		}
		else{
			document.getElementById("txt-confsenha").style.borderBottom = "2px solid #194544";
			document.getElementById("senha-error").style.visibility = "hidden";
		}
	}








	function confemail(){
		var confemail = document.getElementById('txt-confemail').value;
		var email = document.getElementById('txt-email').value;

		if (confemail != email) {
			document.getElementById("txt-confemail").style.borderBottom = "2px solid red";
			document.getElementById("email-error").style.visibility = "visible";
			document.getElementById("btn-cadastrar2").disabled = true;

		}
		else{
			document.getElementById("txt-confemail").style.borderBottom = "2px solid #194544";
			document.getElementById("email-error").style.visibility = "hidden";
			document.getElementById("btn-cadastrar2").disabled = false;
		}
	}






	window.onload = function(){
		var nome = document.getElementById('txt-nome').value;
		var nick = document.getElementById('txt-nick').value;
		var email = document.getElementById('txt-email').value;
		var emailcon = document.getElementById('txt-confemail').value;
		var senha = document.getElementById('txt-senha').value;
		var senhacon = document.getElementById('txt-confsenha').value;

		if (nome == "" || nome == null || nick == "" || nick == null || email == "" || email == null || emailcon == "" || emailcon == null || senha == "" || senha == null || senhacon == "" || senhacon == null) {
			document.getElementById("btn-cadastasdrar").disabled = true;
		}
		else{
			document.getElementById("btn-cadastasdrar").disabled = false;
		}
	}