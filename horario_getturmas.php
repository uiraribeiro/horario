<?php

include_once "config.php";
$conntemp = conectadb($banco);

$curso = $_POST['idcurso'];   // department id

$sql = "SELECT t1.idcurso, idmont, serie, numero, turno, nome from montante t1 join curso t2 on (t1.idcurso = t2.idcurso) WHERE t1.idcurso=".$curso." order by turno,serie, numero";
//echo $sql;

$result = mysqli_query($conntemp,$sql);

$mont_arr = array();
$mont_arr[] = array("id" => 0, "nome" => " -- Selecione o Montante -- ");
while( $row = mysqli_fetch_array($result) ){
    $idmont = $row['idmont'];
    $nome = $row['serie']." Período ".$row['turno'].$row['numero'];
	//$mont_arr[] = array("curso" => $row['idcurso'], "nome" => $row['nome']);
    $mont_arr[] = array("id" => $idmont, "nome" => $nome);
}

// encoding array to json format
echo json_encode($mont_arr);

?>