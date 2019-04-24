<?php


include_once "config.php";
$conntemp = conectadb($banco);

$direcao = 1;
//echo $_POST['prof_geral'];




if (!isset($_GET['curso']))
{
	$curso = '201';
}
else
{
	$curso = $_GET['curso'];
}

if (isset($_POST['prof_geral']))
{
	foreach ($_POST['prof_geral'] as $selectedOption)
	{
		$sql="insert into prof_curso (idprof,curso) values ($selectedOption,$curso)";
		$rstemp_query=mysqli_query($conntemp,$sql);
	}
}	
if (isset($_POST['prof_curso']))
{
	foreach ($_POST['prof_curso'] as $selectedOption)
	{
		$sql="delete from prof_curso where idprof =  $selectedOption  and curso = $curso";
		//echo $sql."<br>";
		$rstemp_query=mysqli_query($conntemp,$sql);
	}
}	
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
			<form action='horario_prof.php' method='post' id='fmontante'>
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
						//echo $sql;
						$rstemp_query=mysqli_query($conntemp,$sql);
						$rstemp=mysqli_fetch_array($rstemp_query);
						while(!($rstemp==0))
						{
							$comp = '';
							if ($rstemp["idcurso"]==$curso) { $comp = ' selected';}
							echo "<option value='".$rstemp["idcurso"]."' $comp>".$rstemp["nome"]."</option>";
							$rstemp=mysqli_fetch_array($rstemp_query);	
						}
						
					?>
					</select></label>
					
				</div>
				
				
			
			
				<div class="row">
					<div class="col-md-5">
							<?php
								$sql = "select idprof, nome from professor where idprof not in (select idprof from prof_curso where curso = $curso) order by nome";
								$rstemp_query=mysqli_query($conntemp,$sql);
								$rstemp=mysqli_fetch_array($rstemp_query);

								echo "<label>Lista Geral<br><select name='prof_geral[]' id='prof_geral' multiple size=30>";
								while(!($rstemp==0))
								{
									echo "<option value='".$rstemp["idprof"]."'>".$rstemp["nome"]."</option>";
									$rstemp=mysqli_fetch_array($rstemp_query);	
								}
								echo "</select></label>"
								//var_dump($mont);
							?>
					</div>
					<div class="col-md-2"><br><br><br>
							<input type='submit' class='btn btn-primary' value='Adicionar'><br><br>
							<input type='submit' class='btn btn-primary' value='Remover'><br>
					</div>
					<div class="col-md-5">
					<?php
								$sql = "select t1.idprof, nome from professor t1 join prof_curso t2 on t1.idprof = t2.idprof where t2.curso = $curso order by nome";
								$rstemp_query=mysqli_query($conntemp,$sql);
								$rstemp=mysqli_fetch_array($rstemp_query);
								//echo $sql;
								echo "<label>Professores do Curso<br><select name='prof_curso[]' id='prof_curso' multiple size=30>";
								while(!($rstemp==0))
								{
									echo "<option value='".$rstemp["idprof"]."'>".$rstemp["nome"]."</option>";
									$rstemp=mysqli_fetch_array($rstemp_query);	
								}
								echo "</select></label>"
								//var_dump($mont);
							?>
					</div>
				
		</div>
		
	</div>
</div>
</form><br>
    <script src="horario_js/jquery.min.js"></script>
    <script src="horario_js/bootstrap.min.js"></script>
    <script src="horario_js/scripts.js"></script>
  </body>

  <script>
    function preenche(id)
	{
		$.ajax({
				url: 'horario_gravamont.php',
				type: 'post',
				data: {mid:id,curso:<?php echo $curso;?>},
				dataType: 'json',
				success:function(response){

					
				}
			});
	}
	

	  $(document).ready(function(){
       
		$("#curso").change(function(){
			
			//document.forms['fmontante'].submit();
			this.form.submit();
			 
		});

	

		});
</script>

</html>