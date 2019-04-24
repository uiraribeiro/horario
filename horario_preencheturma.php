<?php

include_once "config.php";
$conntemp = conectadb($banco);

$montante = $_GET['idmont'];   // department id


$sql = "select t1.idturma, t1.iddisc, t1.idprof, t1.turma, t2.nome, t3.nome_disc , t5.idhorario, t5.dia, t5.hora, t6.turno, t6.serie, t6.idcurso 
FROM turma t1, professor t2, disciplina t3, mont_turma t4, horario t5, montante t6
WHERE 
t1.iddisc = t3.iddisc 
and t1.idprof = t2.idprof 
and t1.idturma = t4.idturma 
and t1.idturma = t5.idturma
and t4.idmont = t6.idmont
and t4.idmont = $montante";
//echo $sql;

$result = mysqli_query($conntemp,$sql);

$mont_arr = array();

for ($dia = 1;$dia<7;$dia++)
{
    for ($hora = 1;$hora<18;$hora++)
    {
        $horario[$dia][$hora] = "&nbsp;"; 
    }
}

while( $row = mysqli_fetch_array($result) ){
    $idmont = $row['idturma'];
    $turno = $row['turno'];
    $serie = $row['serie'];
    $nome = $row['iddisc'].$row['turma']." - ".$row['nome_disc']." - ".$row['nome'];

    $horario[$row['dia']][$row['hora']] = $row['iddisc']." ".$row['turno'].$row['turma'];
    $desc = $row['idcurso'].' '.$row['serie'].$row['turno'].$row['turma'];
}

// encoding array to json format
//echo json_encode($mont_arr);
if ($turno=='M') { $inicio = 1;}
if ($turno=='N') { $inicio = 13;}


echo '{';
echo '"Seg":["'.$horario[1][$inicio].'","'.$horario[1][$inicio+1].'","'.$horario[1][$inicio+2].'","'.$horario[1][$inicio+3].'","'.$horario[1][$inicio+4].'"],';
echo '"Ter":["'.$horario[2][$inicio].'","'.$horario[2][$inicio+1].'","'.$horario[2][$inicio+2].'","'.$horario[2][$inicio+3].'","'.$horario[2][$inicio+4].'"],';
echo '"Qua":["'.$horario[3][$inicio].'","'.$horario[3][$inicio+1].'","'.$horario[3][$inicio+2].'","'.$horario[3][$inicio+3].'","'.$horario[3][$inicio+4].'"],';
echo '"Qui":["'.$horario[4][$inicio].'","'.$horario[4][$inicio+1].'","'.$horario[4][$inicio+2].'","'.$horario[4][$inicio+3].'","'.$horario[4][$inicio+4].'"],';
echo '"Sex":["'.$horario[5][$inicio].'","'.$horario[5][$inicio+1].'","'.$horario[5][$inicio+2].'","'.$horario[5][$inicio+3].'","'.$horario[5][$inicio+4].'"],';

echo '"Curso":["'.$desc.'"],';
if ($serie< $global_serie)
{
    if ($turno=='M') {  echo '"Horarios":["07:40","08:30","09:20","10:10","11:15"]}'; }
    if ($turno=='N') {  echo '"Horarios":["18:25","19:15","20:05","21:10"]  }'; }
}
else
{
    if ($turno=='M') {  echo '"Horarios":["07:30","08:20","09:10","10:15","11:05","11:55"]}'; }
    if ($turno=='N') {  echo '"Horarios":["18:15","19:05","19:55","21:00","21:50"]}'; }
}
?>