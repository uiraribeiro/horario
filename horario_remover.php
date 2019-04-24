<?php


include_once "config.php";
$conntemp = conectadb($banco);

$idturma = $_GET['idturma'];   
$idmont = $_GET['idmont'];
$dia = $_GET['mdia'];
$hora = $_GET['mhora'];
$direcao = $_GET["direcao"];
$mont_arr = array();
$serie_nova = 1;

$flag=0;

$sql = "select idprof, iddisc from turma where idturma = $idturma";
$rstemp_query=mysqli_query($conntemp,$sql);
$rstemp=mysqli_fetch_array($rstemp_query);
$codprof = $rstemp["idprof"];
$disc = $rstemp["iddisc"];

$sql = "select nome_disc, aulas_pagas from disciplina where iddisc = '$disc'";
$rstemp_query=mysqli_query($conntemp,$sql);
$rstemp=mysqli_fetch_array($rstemp_query);
$disc_nome = $rstemp["nome_disc"];
$pagas = $rstemp["aulas_pagas"];

$sql = "select serie, turno from montante where idmont = $idmont";
$rstemp_query=mysqli_query($conntemp,$sql);
$rstemp=mysqli_fetch_array($rstemp_query);
$serie = $rstemp["serie"];
$turno = $rstemp["turno"];

if ($serie <= $serie_nova)
{
    if ($turno=="M") { $nova_hora = "and t3.hora in (3,4,5)"; }
    if ($turno=="N") { $nova_hora = "and t3.hora in (14,15,16)"; }
}
else
{
    $nova_hora = "and t3.hora = $hora";
}

// ======================================================================
//  CHECA JANELA
// ========================================================================
$sql = "select hora  FROM turma t1 , mont_turma t2, horario t3 
WHERE t1.idturma = t2.idturma and t1.idturma = t3.idturma
and t1.idprof = $codprof
and t3.dia = $dia order by t3.hora";
$rstemp_query=mysqli_query($conntemp,$sql);
$rstemp=mysqli_fetch_array($rstemp_query);
//echo $sql."<br>";

$string_dia = "00000000000000000";
while(!($rstemp==0))
{
    
    $string_dia = substr_replace($string_dia,"1",$rstemp["hora"]-1,1);
    //echo $rstemp["hora"];
    $rstemp=mysqli_fetch_array($rstemp_query);	
    
}
if ($serie <= $serie_nova)
{
    if ($turno=="M") 
        { 
            $string_dia = substr_replace($string_dia,"1",3,1);
            $string_dia = substr_replace($string_dia,"1",4,1);
            $string_dia = substr_replace($string_dia,"1",5,1);
        }
    if ($turno=="N") 
    { 
        $string_dia = substr_replace($string_dia,"1",14,1);
        $string_dia = substr_replace($string_dia,"1",15,1);
        $string_dia = substr_replace($string_dia,"1",16,1);
    }
}
else
{
    $string_dia = substr_replace($string_dia,"1",$hora-1,1);
}
//echo "<br>!".$string_dia."!<br>";
if (strstr($string_dia,"101")==TRUE)
{
    $flag++;
    $mont_arr[] = array("id" => "006", "nome" => "Janela para o prof");
    //echo "Janela: ".$rstemp["numero"]."<br>";
}

// ======================================================================
//  CHECA SE É FUSAO
// ========================================================================

$sql = "select count(*) numero from mont_turma where idturma = $idturma";
$rstemp_query=mysqli_query($conntemp,$sql);
$rstemp=mysqli_fetch_array($rstemp_query);
$codprof = $rstemp["idprof"];
$disc = $rstemp["iddisc"];
if ($rstemp["numero"]>1)
{
    $mont_arr[] = array("id" => "007", "nome" => "Disciplina é fusão");
    //echo "Disciplina é fusão: ".$rstemp["numero"]."<br>";
    if ($direcao==0)
    {    
        $flag++;
    }
}
// ======================================================================
//  SALVA SE FLAG=0
// ========================================================================
if ($flag==0)
{
    if ($serie <= $serie_nova)
    {
        if ($turno=="M") 
            { 
                $sql = "delete from horario where idturma = $idturma and  hora = 3 and  dia = $dia";
                $rstemp_query=mysqli_query($conntemp,$sql);
                $sql = "delete from horario where idturma = $idturma and  hora = 4 and  dia = $dia";
                $rstemp_query=mysqli_query($conntemp,$sql);
                $sql = "delete from horario where idturma = $idturma and  hora = 5 and  dia = $dia";
                $rstemp_query=mysqli_query($conntemp,$sql);
            }
        if ($turno=="N") 
        { 
            $sql = "delete from horario where idturma = $idturma and  hora = 14 and  dia = $dia";
            $rstemp_query=mysqli_query($conntemp,$sql);
            $sql = "delete from horario where idturma = $idturma and  hora = 15 and  dia = $dia";
            $rstemp_query=mysqli_query($conntemp,$sql);
            $sql = "delete from horario where idturma = $idturma and  hora = 16 and  dia = $dia";
            $rstemp_query=mysqli_query($conntemp,$sql);
        }
    }
    else
    {
        $sql = "delete from horario where idturma = $idturma and  hora = $hora and  dia = $dia";
        $rstemp_query=mysqli_query($conntemp,$sql);
    }

//echo "Cadastro feito com sucesso";

}
echo json_encode($mont_arr);
//echo $sql;

/*
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
if ($serie<2)
{
    if ($turno=='M') {  echo '"Horarios":["07:40","08:30","09:20","10:10","11:15"]}'; }
    if ($turno=='N') {  echo '"Horarios":["18:25","19:15","20:05","21:10"]}'; }
}
else
{
    if ($turno=='M') {  echo '"Horarios":["07:30","08:20","09:10","10:15","11:05","11:55"]}'; }
    if ($turno=='N') {  echo '"Horarios":["18:15","19:05","19:55","21:00","21:50"]}'; }
}
*/
?>