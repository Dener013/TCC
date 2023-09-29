<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Ativação de conta</title>

	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="css/confirmar.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

  	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>

  
  <!-- Modal -->
  <div id="isso">
    <div class="modal-dialog">
    <form action="php/ativacao.php" method="post">
      <!-- Modal content-->
      <div class="modal-content"  id="box-conf">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">Ativação de Conta</h4>
        </div>
        <div class="modal-body">
        	<div class="form-group">
        		<input class="form-control input-lg" id="nick" name="nick" type="text" placeholder="Nick" required="">
        		<br>
			    <input class="form-control input-lg" id="codigo" name="codigo" type="text" placeholder="Código" required="">
			  </div>
         </div>
        <div class="modal-footer">
          <button class="btn btn-default" id="ativar" type="submit">Ativar</button>
        </div>
      </div>
     </form>
    </div>
  </div>
  

</body>
</html>