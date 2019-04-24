<?php
session_start();
if ($_SESSION["CONTROLE"] != "ABRACADABRA") {
   header ("Location: index.php");
}  
include_once "config.php";
$conntemp = conectadb($banco);

$direcao = 1;

?>

<!DOCTYPE html>
<html lang="pt_BR">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Horário 2.0</title>

    <meta name="description" content="Fazedor de Horário">
    <meta name="author" content="Prof. Uirá Ribeiro">

	
    <link href="horario_css/bootstrap.min.css" rel="stylesheet">
    <link href="horario_css/style.css" rel="stylesheet">
		<script src="horario_js/jquery.min.js"></script>
		<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
		<script src="horario_js/popper.min.js"></script>
		<script src="horario_js/bootstrap.min.js"></script>
		<script src="horario_js/scripts.js"></script>
    <script>
		function MontaTabela(montid) {
	       
					$.ajax({
							url: 'horario_getturmas_montante.php',
							method: "POST",
							data: {montante:montid},
							dataType: "html",
							success:function(response){
               
							
								$("#turmasmont").html(response);

						
							}
						});
		}

		function salvar(turno,idmont) {
			if ($('#proid').val() == "0") {
				alert("Informe o Professor(a)");
				return false;
			}
			var data = "idmont="+idmont+"&idprof="+$('#proid').val()+"&idsala="+$('#idsala').val()+"&idcur="+$('#idcur').val()+"&idtur="+$('#idtur').val()+'&iddis='+$('#iddis').val()+'&turno='+turno; 

			$.post('horario_gravaturma.php',data,function(json) {
					if (json.status == 'sucesso') {
						
							$('#exampleModal').modal('hide');

						    MontaTabela($('#montante').val());
							//$('#montante').triguer("change");
					} else {
						alert(json.message);  
					}   
			},"json");

		}  

		 $(document).ready(function(){
		  
				$("#curso").change(function(){
					var curso = $(this).val();
					$.ajax({
							url: 'horario_getturmas.php',
							type: 'post',
							data: {idcurso:curso},
							dataType: 'json',
							success:function(response){

								var len = response.length;

								$("#montante").empty();
								for( var i = 0; i<len; i++){
									var id = response[i]['id'];
									var nome = response[i]['nome'];
									
									$("#montante").append("<option value='"+id+"'>"+nome+"</option>");

								}
							}
						});
				});	


				$("#montante").change(function(){
				  MontaTabela($(this).val());
				});	

				$('#turmasmont').delegate('.merda','show.bs.modal', function (event) {

					var button = $(event.relatedTarget); // Button that triggered the modal
				
					var disc = button.data('disc'); // Extract info from data-* attributes
					var turma = button.data('turma'); // Extract info from data-* attributes
				
				  
					// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
					// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
					var modal = $(this);

					$('#idcur').val(button.data('curso')); 
					$('#idtur').val(button.data('turma')); 
					$('#iddis').val(button.data('disc')); 
        
					setSelectByValue('proid',button.data('prof'));
					setSelectByValue('idsala',button.data('sala'));

					//var titulo =  button.data('titulo');
					modal.find('.modal-title').text(button.text());
					//modal.find('.modal-body input').val(recipient)
				});

				

	   });	

    </script>

  </head>
  <body>

<div class="container-fluid">
  <div class='row'>
		<div class="col-md-10">
			<h1>Horário Maker 2.0</h1>
		</div>
		<div class="col-md-2">
			<a href='horario.php' class='btn btn-warning'>Horário</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action='horario_turma.php' mathod='post' id='fmontante'>
				<div class='row'>
				  <div class='col-md-3'>
					<label>Curso </label>
					<select name='curso' id='curso' class="form-control">
					
					<?PHP
						echo "<option value='0'> -- Selecione o curso -- </option>";
						$sql = "select idcurso,nome from curso order by nome";
						if ($direcao==0)
						{
							$sql.=" where idprof = $idprof";
						}
						echo $sql;
						$rstemp_query=mysqli_query($conntemp,$sql);
						$rstemp=mysqli_fetch_array($rstemp_query);
						while(!($rstemp==0))
						{
							echo "<option value='".$rstemp["idcurso"]."'>".$rstemp["nome"]."</option>";
							$rstemp=mysqli_fetch_array($rstemp_query);	
						}
					?>
					</select>
          </div>
					<div class='col-md-3'>
          <label> Montante </label>
					<select name='montante' id='montante'  class="form-control">					
					</select>
					</label>
					</div>
					<div class='col-md-12'>
			    <div id="turmasmont"></div>



				</div>
				</div> <!-- fim linha -->
				
				
			</form>
			</div>
		
			  	

     </div>
    </div>
		
	</div>
</div>


 
  </body>

</html>