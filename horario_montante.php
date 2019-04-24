<?php
session_start();
if ($_SESSION["CONTROLE"] != "ABRACADABRA") {
   header ("Location: index.php");
}  

include_once "config.php";
$conntemp = conectadb($banco);

$direcao = 1;

if (!isset($_GET['curso']))
{
	$curso = '201';
}
else
{
	$curso = $_GET['curso'];
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
			<form action='horario_montante.php' mathod='post' id='fmontante'>
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
				
				
			</form><br>
			
			<table class="table table-bordered" id='table_turma'>
				<tr><th>Montante</th><th>1o</th><th>2o</th><th>3o</th><th>4o</th><th>5o</th><th>6o</th><th>7o</th><th>8o</th>
				<?php
				$repete = 8;
				switch ($curso)
				{
					case 206:
						echo "<th>9o</th><th>10o</th>";
						$repete = 10;
						break;
					case 110:
						echo "<th>9o</th><th>10o</th>";
						$repete = 10;
						break;
					case 310:
						echo "<th>9o</th><th>10o</th>";
						$repete = 10;
						break;
				}
				?>
				</tr>
				<?php
					$sql = "select idmont, idcurso, serie, numero, turno from montante where idcurso = $curso";
					$rstemp_query=mysqli_query($conntemp,$sql);
					$rstemp=mysqli_fetch_array($rstemp_query);
					while(!($rstemp==0))
					{
						$chave = $rstemp["turno"]."/".$rstemp["serie"]."/".$rstemp["numero"];
						$mont[$chave] = $rstemp["idmont"];
						$rstemp=mysqli_fetch_array($rstemp_query);	
					}
					//var_dump($mont);
				?>
				<tr><th>M1</th>
					<?php
					for ($i=1;$i<=$repete;$i++)
					{
						echo "<td>";
						$checked='';
						$key = "M/$i/1";
						//echo $key;
						if ($mont[$key]>0) 
						{ 
							$checked = ' checked';
						}
						else
						{
							$mont[$key]=0;
						}
						echo "<input type='checkbox' name='M/$i/1' value='M/$i/1' $checked onclick='preenche(\"M/$i/1/".$mont[$key]."\")'>";
						echo "</td>";
					}
					?>
				</tr>
				<tr><th>M2</th>
					<?php
					for ($i=1;$i<=$repete;$i++)
					{
						echo "<td>";
						$checked='';
						$key = "M/$i/2";
						//echo $key;
						if ($mont[$key]>0) 
						{ 
							$checked = ' checked';
						}
						else
						{
							$mont[$key]=0;
						}
						echo "<input type='checkbox' name='M/$i/2' value='M/$i/2' $checked onclick='preenche(\"M/$i/2/".$mont[$key]."\")'>";
						echo "</td>";
					}
					?>
				</tr>
				<tr><th>M3</th>
					<?php
					for ($i=1;$i<=$repete;$i++)
					{
						echo "<td>";
						$checked='';
						$key = "M/$i/3";
						//echo $key;
						if ($mont[$key]>0) 
						{ 
							$checked = ' checked';
						}
						else
						{
							$mont[$key]=0;
						}
						echo "<input type='checkbox' name='M/$i/3' value='M/$i/3' $checked onclick='preenche(\"M/$i/3/".$mont[$key]."\")'>";
						echo "</td>";
					}
					?>
				</tr>
				<tr><th>N1</th>
					<?php
					for ($i=1;$i<=$repete;$i++)
					{
						echo "<td>";
						$checked='';
						$key = "N/$i/1";
						//echo $key;
						if ($mont[$key]>0) 
						{ 
							$checked = ' checked';
						}
						else
						{
							$mont[$key]=0;
						}
						echo "<input type='checkbox' name='N/$i/1'  value='N/$i/1' $checked onclick='preenche(\"N/$i/1/".$mont[$key]."\")'>";
						echo "</td>";
					}
					?>
				</tr>
				<tr><th>N2</th>
					<?php
					for ($i=1;$i<=$repete;$i++)
					{
						echo "<td>";
						$checked='';
						$key = "N/$i/2";
						//echo $key;
						if ($mont[$key]>0) 
						{ 
							$checked = ' checked';
						}
						else
						{
							$mont[$key]=0;
						}
						echo "<input type='checkbox' name='N/$i/2'  value='N/$i/2' $checked onclick='preenche(\"N/$i/2/".$mont[$key]."\")'>";
						echo "</td>";
					}
					?>
				</tr>
				<tr><th>N3</th>
					<?php
					for ($i=1;$i<=$repete;$i++)
					{
						echo "<td>";
						$checked='';
						$key = "N/$i/3";
						//echo $key;
						if ($mont[$key]>0) 
						{ 
							$checked = ' checked';
						}
						else
						{
							$mont[$key]=0;
						}
						echo "<input type='checkbox' name='N/$i/3' value='N/$i/3' $checked onclick='preenche(\"N/$i/3/".$mont[$key]."\")'>";
						echo "</td>";
					}
					?>
				</tr>
			</table>
		</div>
		
	</div>
</div>

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