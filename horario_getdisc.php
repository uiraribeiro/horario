<?php

include_once "config.php";
$conntemp = conectadb($banco);

$montante = $_POST['idmont'];   // department id

$sql = "select t1.idturma, t1.iddisc, t1.idprof, t1.turma, t2.nome, t3.nome_disc, t1.turno FROM
turma t1, professor t2, disciplina t3, mont_turma t4
WHERE
t1.iddisc = t3.iddisc
and t1.idprof = t2.idprof
and t1.idturma = t4.idturma
and t4.idmont = $montante";
//echo $sql;

$result = mysqli_query($conntemp,$sql);

$mont_arr = array();
$mont_arr[] = array("id" => 0, "nome" => " -- Selecione a Disciplina -- ");
while( $row = mysqli_fetch_array($result) ){
    $idmont = $row['idturma'];
    $nome = $row['iddisc']."[".$row['turno'].$row['turma']."] - ".$row['nome_disc']." - ".$row['nome'];

    $mont_arr[] = array("id" => $idmont, "nome" => $nome);
}

// encoding array to json format
echo json_encode($mont_arr);

?>