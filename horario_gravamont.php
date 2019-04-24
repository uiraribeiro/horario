<?php


include_once "config.php";
$conntemp = conectadb($banco);

$id = $_POST['mid'];   // department id
$curso = $_POST['curso'];
$novo = explode("/",$id);


$sql = "select count(*) numero from montante where idmont = ".$novo[3];
$rstemp_query=mysqli_query($conntemp,$sql);
$rstemp=mysqli_fetch_array($rstemp_query);
$numero = $rstemp["numero"];

if ($numero=="1")
{
    $sql = "delete from montante where idmont = ".$novo[3];
}
if ($numero=="0")
{
    $sql = "insert into  montante (idcurso, serie,numero,turno) values (";
    $sql.=$curso.",";
    $sql.=$novo[1].",";
    $sql.=$novo[2].",";
    $sql.="'".$novo[0]."')";
    
}
$rstemp_query=mysqli_query($conntemp,$sql);

echo $sql;

?>