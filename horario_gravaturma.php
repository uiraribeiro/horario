<?php
include_once "config.php";
$conntemp = conectadb($banco);

$iddisc = $_POST['iddis'];   // department id
$curso = $_POST['idcur'];
$turma = $_POST['idtur'];
$idprof = $_POST['idprof'];
$turno = $_POST['turno'];
$idsala = $_POST['idsala'];
$idmont = $_POST['idmont'];


if ($turma == "0") { // criar turma


$sql = "SELECT COUNT(*) + 1 AS qtd
FROM mont_turma mt INNER JOIN turma t ON (mt.idturma = t.idturma AND iddisc = '$iddisc')
WHERE idmont = $idmont";

$rstemp_query=mysqli_query($conntemp,$sql);
$rstemp=mysqli_fetch_array($rstemp_query);

    $tur = $rstemp['qtd'] ;

    $sql = "INSERT INTO turma 
    (iddisc, 
    idprof, 
    turma, 
    turno, 
    sala
    )
    VALUES
    ('$iddisc', 
    '$idprof', 
    '$tur', 
    '$turno', 
    '$idsala'
    );

    ";

    if (!mysqli_query($conntemp,$sql)) {
        $msgerro = mysqli_error($conntemp);
        fail($msgerro." Sql: $sql");
    }

    $id = mysqli_insert_id($conntemp);

    $sql = "INSERT INTO mont_turma (idmont,idturma) VALUES ('$idmont','$id')";
    if (!mysqli_query($conntemp,$sql)) {
        $msgerro = mysqli_error($conntemp);
        fail($msgerro." Sql: $sql");
    }
    else {
        success("Turma Criada com Sucesso","id:$id tur: $tur");
    }
} else { // altera professor

    $sql = "UPDATE turma SET idprof = '$idprof', sala = '$idsala'
    WHERE idturma = ".$turma;
    if (!mysqli_query($conntemp,$sql)) {
        $msgerro = mysqli_error($conntemp);
        fail($msgerro." Sql: $sql");
    } else {
        success("Turma Alterada",$sql);
    }
}





function fail($message)  {
    die(json_encode(array('status' => 'falha','message' => $message)));
 }
 
  function success($message,$debug)  {
    die(json_encode(array('status' => 'sucesso','message' => $message,'debug' => $debug)));
 }


?>