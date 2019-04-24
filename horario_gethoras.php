<?php
include_once "config.php";
$conntemp = conectadb($banco);

$montante = $_POST['idmont'];   // department id

$sql = "SELECT idmont, serie, numero, turno from montante WHERE idmont=".$montante;
//echo $sql;

$result = mysqli_query($conntemp,$sql);

$mont_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $turno = $row['turno'];
    $serie = $row['serie'];
    
}
//echo '{';
if ($serie< $global_serie)
{
    if ($turno=='M') 
    {  
       // $mont_arr[] = array("id" => 1, "nome" => "07:40");
       // $mont_arr[] = array("id" => 2, "nome" => "08:30");
        $mont_arr[] = array("id" => 3, "nome" => "09:20");
       // $mont_arr[] = array("id" => 4, "nome" => "10:10");
       // $mont_arr[] = array("id" => 5, "nome" => "11:15");
    }
    if ($turno=='N') 
    {  
       // $mont_arr[] = array("id" => 13, "nome" => "18:25");
        $mont_arr[] = array("id" => 14, "nome" => "19:15");
       // $mont_arr[] = array("id" => 15, "nome" => "20:05");
       // $mont_arr[] = array("id" => 16, "nome" => "21:10");
    }
}
else
{
    if ($turno=='M') 
    {  
        $mont_arr[] = array("id" => 1, "nome" => "07:30");
        $mont_arr[] = array("id" => 2, "nome" => "08:20");
        $mont_arr[] = array("id" => 3, "nome" => "09:10");
        $mont_arr[] = array("id" => 4, "nome" => "10:15");
        $mont_arr[] = array("id" => 5, "nome" => "11:05");
        $mont_arr[] = array("id" => 6, "nome" => "11:55");
    }
    if ($turno=='N') 
    {  
        $mont_arr[] = array("id" => 13, "nome" => "18:15");
        $mont_arr[] = array("id" => 14, "nome" => "19:05");
        $mont_arr[] = array("id" => 15, "nome" => "19:55");
        $mont_arr[] = array("id" => 16, "nome" => "21:00");
        $mont_arr[] = array("id" => 17, "nome" => "21:50");
    }
}
echo json_encode($mont_arr);
?>