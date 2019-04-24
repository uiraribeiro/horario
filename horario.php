<?php

session_start();
if ($_SESSION["CONTROLE"] != "ABRACADABRA") {
   header ("Location: index.php");
}  

include_once "config.php";
$conntemp = conectadb($banco);

$banco = array($BDURL,$BDUSER,$BDPASS,$BANCO);

$direcao = 1;
$idprof = 58;
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
		<style> 
		  .titulo { 
					font-size:2rem;
					font-weight:bold;
					border-radius: 5px;
					border-width: 2px;
					background-color:DodgerBlue;
					color:white;
					padding:10px;
					margin: 10px 10px 10px 10px;
			}
			.subtitulo {
				font-size:1.5rem;
				font-weight:bold;

			}
		
		</style>
  </head>
  <body>

    <div class="container-fluid">
	<div class='row'>
		<div class="col-md-7">
			<span class='titulo'>Horário Maker 2.0</span>&nbsp;&nbsp;&nbsp;  <span class='subtitulo'> <?php echo $_SESSION['MATRICULA']." - ".$_SESSION['NOME']; ?> </span>
		</div>
		<div class="col-md-1">
			<?php
			if ($direcao==1)
			{
				echo "<a href='horario_montante.php' class='btn btn-warning'>Montantes</a>";
			}
		echo "</div><div class='col-md-1'>";
			if ($direcao==1)
			{
				echo "<a href='horario_turma.php' class='btn btn-warning'>Turmas</a>";
			}
		echo "</div><div class='col-md-1'>";
			if ($direcao==1)
			{
				echo "<a href='horario_prof.php' class='btn btn-warning'>Professor</a>";
			}
			?>
		</div>

	</div>
	<div class="row">
		<div class="col-md-6">
			<form action='horario.php' mathod='post'>
				<div class='card'>
					<label>Selecione o Curso
					<select name='curso' id='curso'>
					
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
					</select></label>
					<label>Selecione a Turma
					<select name='montante' id='montante'>
					<?php echo "<option value='0'> -- Selecione a turma -- </option>";	?>
					</select></label>
					<label>Selecione a Disciplina
					<select name='disciplina' id='disciplina'>
						
					</select></label>
					
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<h3>
						<div id='nometurma'></div>
						</h3>
						<input type='button' id='btnadd' class='btn btn-primary' value='Adicionar' onclick='adicionar();'>
						<input type='button' id='btnrmv' class='btn btn-danger' value='Remover' onclick='remover();'>
					</div>
					<div class="col-md-3">
						<select name='dia' id='dia'>
								<option value='1'>Seg</option>
								<option value='2'>Ter</option>
								<option value='3'>Qua</option>
								<option value='4'>Qui</option>
								<option value='5'>Sex</option>
								<option value='6'>Sab</option>	
						</select>
					</div>
					<div class="col-md-3">
							<select name='hora' id='hora'>
									
							</select>
					</div>
				</div>
			</form><br>
			<div id='warning'></div>
			<table class="table table-bordered" id='table_turma''>
				
			</table>
		</div>
		<div class="col-md-6">
			<h3>
				<div id='nomeprof'></div>
			</h3>
			<p><div id='dadosprof'></div></p>
			<table class="table" id="table_professor">
			
			</table>
		</div>
	</div>
</div>

    <script src="horario_js/jquery.min.js"></script>
    <script src="horario_js/bootstrap.min.js"></script>
    <script src="horario_js/scripts.js"></script>
  </body>

  <script>
    
	function sleep(seconds){
    var waitUntil = new Date().getTime() + seconds*1000;
    while(new Date().getTime() < waitUntil) true;
	}

	  $(document).ready(function(){
        $("#btnadd").attr("disabled", "disabled");
		$("#btnrmv").attr("disabled", "disabled");

		$("#curso").change(function(){
			var curso = $(this).val();
			$("#table_turma").empty();
			$("#nometurma").empty();
			$("#nomeprof").empty();
			$("#dadosprof").empty();
			$("#table_professor").empty();
			$("#btnadd").attr("disabled", "disabled");
			$("#btnrmv").attr("disabled", "disabled");
			$("#btnadd").attr("disabled", "disabled");
			$('#warning').empty();
		$("#btnrmv").attr("disabled", "disabled");
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
			var montante = $(this).val();
			$("#table_turma").empty();
			$("#nometurma").empty();
			$("#nomeprof").empty();
			$("#dadosprof").empty();
			$("#table_professor").empty();
			$("#btnadd").attr("disabled", "disabled");
			$("#btnrmv").attr("disabled", "disabled");
			$('#warning').empty();
			$.ajax({
				url: 'horario_getdisc.php',
				type: 'post',
				data: {idmont:montante},
				dataType: 'json',
				success:function(response){

					var len = response.length;

					$("#disciplina").empty();
					for( var i = 0; i<len; i++){
						var id = response[i]['id'];
						var nome = response[i]['nome'];
						
						$("#disciplina").append("<option value='"+id+"'>"+nome+"</option>");

					}
				}
			});
	
			$.ajax({
				url: 'horario_gethoras.php',
				type: 'post',
				data: {idmont:montante},
				dataType: 'json',
				success:function(response){

					var len = response.length;

					$("#hora").empty();
					for( var i = 0; i<len; i++){
						
						var id = response[i]['id'];
						var nome = response[i]['nome'];
						
						$("#hora").append("<option value='"+id+"'>"+nome+"</option>");

					}
				}
			});

			$.ajax(
				{
					type: "get",
					url: 'horario_preencheturma.php',
					data: {idmont:montante},
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					cache: false,
					success: function (data) {
						
					var trHTML = '<tr><th>#</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th></tr>';
							
					$.each(data.Horarios, function (i, item) {
						
						trHTML += '<tr><td>' + data.Horarios[i] + '</td><td>' + data.Seg[i] + '</td><td>' + data.Ter[i] + '</td><td>' + data.Qua[i] + '</td><td>' + data.Qui[i] + '</td><td>' + data.Sex[i] + '</td></tr>';
					});
					$("#table_turma").empty();
					$('#table_turma').append(trHTML);
					$("#nometurma").empty();
					$("#nometurma").append(data.Curso);
					},
					
					error: function (msg) {
						$("#table_turma").empty();
						$("#nometurma").empty();
						alert("Sem horario para esta turma ainda");
						//alert(msg.responseText);
					}
				});

			});
		$("#disciplina").change(function(){
			var turma = $(this).val();
			$('#warning').empty();
			$.ajax(
				{
					type: "get",
					url: 'horario_preencheprof.php',
					data: {idturma:turma},
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					cache: false,
					success: function (data) {
						
					var trHTML = '<tr><th>#</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sab</th></tr>';
							
					$.each(data.Horarios, function (i, item) {
						
						trHTML += '<tr><td>' + data.Horarios[i] + '</td><td>' + data.Seg[i] + '</td><td>' + data.Ter[i] + '</td><td>' + data.Qua[i] + '</td><td>' + data.Qui[i] + '</td><td>' + data.Sex[i] + '</td></tr>';
						
					});
					$("#nomeprof").empty();
					$("#nomeprof").append(data.Nome);

					$("#dadosprof").empty();
					$("#dadosprof").append("<img src='horario_fotos/"+data.Matricula+".jpg' class='img-responsive img-circle' width='50'><a href='mailto:"+data.Email+"'>"+data.Email+"</a> - <a rel='nofollow' class='btn-success' href='https://api.whatsapp.com/send?phone=5531"+data.Tel+"&amp;text=Olá, tudo bem?' target='_blank'>"+data.Tel+"</a>");
					
					//alert(data.Nome);
					$("#table_professor").empty();
					$('#table_professor').append(trHTML);
					
					$("#btnadd").removeAttr("disabled");
					$("#btnrmv").removeAttr("disabled");

					},
					
					error: function (msg) {
						
						//alert("Sem professor cadastrado para esse montante");
						alert(msg.responseText);
					}
				});
		});
		

	});
	function adicionar()
		{
			var curso = $("#curso").val();
			var montante = $("#montante").val();
			var turma = $("#disciplina").val();
			var dia = $("#dia").val();
			var hora = $("#hora").val();
			//alert (curso+" "+montante+" "+turma+" "+dia+" "+hora);
			$.ajax(
				{
					type: "get",
					url: 'horario_adiciona.php',
					data: {idturma:turma, mdia:dia, mhora:hora, idmont:montante, direcao:<?php echo $direcao;?> },
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					cache: false,
					success: function (data) {
						var len = data.length;
						//alert(data[0].nome);
						$('#warning').empty();
						for( var i = 0; i<len; i++){
							var id = data[i]['id'];
							var nome = data[i]['nome'];
							
							$('#warning').append('<p><font color=red>'+id+' - '+nome+'</font></p>');

						}
						// =====================================
						// REMONTA PREENCHE TURMA
						// =====================================
						$.ajax(
						{
							type: "get",
							url: 'horario_preencheturma.php',
							data: {idmont:montante},
							contentType: "application/json; charset=utf-8",
							dataType: "json",
							cache: false,
							success: function (data) {
								
							var trHTML = '<tr><th>#</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th></tr>';
									
							$.each(data.Horarios, function (i, item) {
								
								trHTML += '<tr><td>' + data.Horarios[i] + '</td><td>' + data.Seg[i] + '</td><td>' + data.Ter[i] + '</td><td>' + data.Qua[i] + '</td><td>' + data.Qui[i] + '</td><td>' + data.Sex[i] + '</td></tr>';
							});
							$("#table_turma").empty();
							$('#table_turma').append(trHTML);
							$("#nometurma").empty();
							$("#nometurma").append(data.Curso);
							},
							
							error: function (msg) {
								$("#table_turma").empty();
								$("#nometurma").empty();
								alert("Sem horário para esta turma ainda");
								//alert(msg.responseText);
							}
						});
						// =====================================
						// REMONTA PREENCHE PROF
						// =====================================
						$.ajax(
						{
							type: "get",
							url: 'horario_preencheprof.php',
							data: {idturma:turma},
							contentType: "application/json; charset=utf-8",
							dataType: "json",
							cache: false,
							success: function (data) {
								
							var trHTML = '<tr><th>#</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sab</th></tr>';
									
							$.each(data.Horarios, function (i, item) {
								
								trHTML += '<tr><td>' + data.Horarios[i] + '</td><td>' + data.Seg[i] + '</td><td>' + data.Ter[i] + '</td><td>' + data.Qua[i] + '</td><td>' + data.Qui[i] + '</td><td>' + data.Sex[i] + '</td></tr>';
								
							});
							$("#nomeprof").empty();
							$("#nomeprof").append(data.Nome);

							$("#dadosprof").empty();
							$("#dadosprof").append("<a href='mailto:"+data.Email+"'>"+data.Email+"</a> - <a rel='nofollow' class='btn-success' href='https://api.whatsapp.com/send?phone=5531"+data.Tel+"&amp;text=Olá, tudo bem?' target='_blank'>"+data.Tel+"</a>");
							
							//alert(data.Nome);
							$("#table_professor").empty();
							$('#table_professor').append(trHTML);
							
							$("#btnadd").removeAttr("disabled");
							$("#btnrmv").removeAttr("disabled");

							},
							
							error: function (msg) {
								$("#table_professor").empty();
								
								//alert("Sem professor cadastrado para esse montante");
								alert(msg.responseText);
							}
						});
					}
			});

		}



		function remover()
		{
			var curso = $("#curso").val();
			var montante = $("#montante").val();
			var turma = $("#disciplina").val();
			var dia = $("#dia").val();
			var hora = $("#hora").val();
			//alert (curso+" "+montante+" "+turma+" "+dia+" "+hora);
			$.ajax(
				{
					type: "get",
					url: 'horario_remover.php',
					data: {idturma:turma, mdia:dia, mhora:hora, idmont:montante, direcao:<?php echo $direcao;?> },
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					cache: false,
					success: function (data) {
						var len = data.length;
						//alert(data[0].nome);
						$('#warning').empty();
						for( var i = 0; i<len; i++){
							var id = data[i]['id'];
							var nome = data[i]['nome'];
							
							$('#warning').append('<p><font color=red>'+id+' - '+nome+'</font></p>');

						}
						// =====================================
						// REMONTA PREENCHE TURMA
						// =====================================
						$.ajax(
						{
							type: "get",
							url: 'horario_preencheturma.php',
							data: {idmont:montante},
							contentType: "application/json; charset=utf-8",
							dataType: "json",
							cache: false,
							success: function (data) {
								
							var trHTML = '<tr><th>#</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th></tr>';
									
							$.each(data.Horarios, function (i, item) {
								
								trHTML += '<tr><td>' + data.Horarios[i] + '</td><td>' + data.Seg[i] + '</td><td>' + data.Ter[i] + '</td><td>' + data.Qua[i] + '</td><td>' + data.Qui[i] + '</td><td>' + data.Sex[i] + '</td></tr>';
							});
							$("#table_turma").empty();
							$('#table_turma').append(trHTML);
							$("#nometurma").empty();
							$("#nometurma").append(data.Curso);
							},
							
							error: function (msg) {
								$("#table_turma").empty();
								$("#nometurma").empty();
								alert("Sem horário para esta turma ainda");
								//alert(msg.responseText);
							}
						});
						// =====================================
						// REMONTA PREENCHE PROF
						// =====================================
						$.ajax(
						{
							type: "get",
							url: 'horario_preencheprof.php',
							data: {idturma:turma},
							contentType: "application/json; charset=utf-8",
							dataType: "json",
							cache: false,
							success: function (data) {
								
							var trHTML = '<tr><th>#</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sab</th></tr>';
									
							$.each(data.Horarios, function (i, item) {
								
								trHTML += '<tr><td>' + data.Horarios[i] + '</td><td>' + data.Seg[i] + '</td><td>' + data.Ter[i] + '</td><td>' + data.Qua[i] + '</td><td>' + data.Qui[i] + '</td><td>' + data.Sex[i] + '</td></tr>';
								
							});
							$("#nomeprof").empty();
							$("#nomeprof").append(data.Nome);

							$("#dadosprof").empty();
							$("#dadosprof").append("<a href='mailto:"+data.Email+"'>"+data.Email+"</a> - <a rel='nofollow' class='btn-success' href='https://api.whatsapp.com/send?phone=5531"+data.Tel+"&amp;text=Olá, tudo bem?' target='_blank'>"+data.Tel+"</a>");
							
							//alert(data.Nome);
							$("#table_professor").empty();
							$('#table_professor').append(trHTML);
							
							$("#btnadd").removeAttr("disabled");
							$("#btnrmv").removeAttr("disabled");

							},
							
							error: function (msg) {
								$("#table_professor").empty();
								//alert("Sem professor cadastrado para esse montante");
								alert(msg.responseText);
							}
						});
					}
			});

	

			


		}
</script>

</html>