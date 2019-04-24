<?php


include_once "config.php";
$conntemp = conectadb($banco);

$turma = $_GET['idturma'];   // department id

$sql = "select idprof from turma where idturma = $turma";

$rstemp_query=mysqli_query($conntemp,$sql);
$rstemp=mysqli_fetch_array($rstemp_query);
$codprof = $rstemp["idprof"];

$sql = "select nome,email,celular,matricula from professor where idprof = $codprof";

$rstemp_query=mysqli_query($conntemp,$sql);
$rstemp=mysqli_fetch_array($rstemp_query);
$nome = $rstemp['nome'];
$email = $rstemp['email'];
$tel = $rstemp['celular'];
$matricula = $rstemp['matricula'];

$sql = "select t1.idturma, t1.iddisc, t1.idprof, t1.turma, t2.nome, t3.nome_disc , t5.idhorario, t5.dia, t5.hora, t6.turno, t6.serie, t2.email, t2.celular, t2.matricula 
FROM turma t1, professor t2, disciplina t3, mont_turma t4, horario t5, montante t6
WHERE 
t1.iddisc = t3.iddisc 
and t1.idprof = t2.idprof 
and t1.idturma = t4.idturma 
and t1.idturma = t5.idturma
and t4.idmont = t6.idmont
and t1.idprof = $codprof";
//echo $sql;

$result = mysqli_query($conntemp,$sql);

$mont_arr = array();

for ($dia = 1;$dia<7;$dia++)
{
    for ($hora = 1;$hora<19;$hora++)
    {
        $horario[$dia][$hora] = "&nbsp;"; 
    }
}

while( $row = mysqli_fetch_array($result) ){
    $idmont = $row['idturma'];
    $turno = $row['turno'];
    $serie = $row['serie'];
 
    $horario[$row['dia']][$row['hora']] = $row['iddisc']." ".$row['turno'].$row['turma'];
}

// encoding array to json format
//echo json_encode($mont_arr);
//echo $serie;

echo '{';
echo '"Seg":["'.$horario[1][1].'","'.$horario[1][2].'","'.$horario[1][3].'","'.$horario[1][4].'","'.$horario[1][5].'","'.$horario[1][6].'","'.$horario[1][13].'","'.$horario[1][14].'","'.$horario[1][15].'","'.$horario[1][16].'","'.$horario[1][17].'"],';
echo '"Ter":["'.$horario[2][1].'","'.$horario[2][2].'","'.$horario[2][3].'","'.$horario[2][4].'","'.$horario[2][5].'","'.$horario[2][6].'","'.$horario[2][13].'","'.$horario[2][14].'","'.$horario[2][15].'","'.$horario[2][16].'","'.$horario[2][17].'"],';
echo '"Qua":["'.$horario[3][1].'","'.$horario[3][2].'","'.$horario[3][3].'","'.$horario[3][4].'","'.$horario[3][5].'","'.$horario[3][6].'","'.$horario[3][13].'","'.$horario[3][14].'","'.$horario[3][15].'","'.$horario[3][16].'","'.$horario[3][17].'"],';
echo '"Qui":["'.$horario[4][1].'","'.$horario[4][2].'","'.$horario[4][3].'","'.$horario[4][4].'","'.$horario[4][5].'","'.$horario[4][6].'","'.$horario[4][13].'","'.$horario[4][14].'","'.$horario[4][15].'","'.$horario[4][16].'","'.$horario[4][17].'"],';
echo '"Sex":["'.$horario[5][1].'","'.$horario[5][2].'","'.$horario[5][3].'","'.$horario[5][4].'","'.$horario[5][5].'","'.$horario[5][6].'","'.$horario[5][13].'","'.$horario[5][14].'","'.$horario[5][15].'","'.$horario[5][16].'","'.$horario[5][17].'"],';
echo '"Sab":["'.$horario[6][1].'","'.$horario[6][2].'","'.$horario[6][3].'","'.$horario[6][4].'","'.$horario[6][5].'","'.$horario[6][6].'"],';
if ($serie< $global_serie)
{
    echo '"Horarios":["07:40","08:30","09:20","10:10","11:15","11:55","18:15","19:15","20:05","21:10","21:50"]'; 
}
else
{
    echo '"Horarios":["07:30","08:20","09:10","10:15","11:05","11:55","18:15","19:05","19:55","21:00","21:50"]'; 
}
echo ',"Tel":["'.$tel.'"]';
echo ',"Email":["'.$email.'"]';
echo ',"Matricula":["'.$matricula.'"]';
echo ',"Nome":["'.$nome.'"]}';
?>