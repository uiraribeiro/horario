<?php

$BDURL   = "tecnologiasweb.myscriptcase.com";
$SITE    = "www.universobh.com.br";
$BANCO   = "tecnolo1_univhoras";
$BDUSER  = "tecnolo1_master";
$BDPASS  = "lapsur71!";
$global_serie = 3;


$banco = array($BDURL,$BDUSER,$BDPASS,$BANCO);

function conectadb($banco) {

    $conntemp=mysqli_connect($banco[0],$banco[1],$banco[2],$banco[3]);

    if (!$conntemp) {
      $msg = "Error: Unable to connect to MySQL." . PHP_EOL;
      $msg .= "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
      $msg .= "Debugging error: " . mysqli_connect_error() . PHP_EOL;
      exit($msg);
      return false;
    }

    mysqli_query($conntemp,"SET NAMES 'utf8'");
    mysqli_query($conntemp,'SET character_set_connection=utf8');
    mysqli_query($conntemp,'SET character_set_client=utf8');
    mysqli_query($conntemp,'SET character_set_results=utf8');

    return $conntemp;
}





function getOptions($conexao,$labelvazio,$default,$sql) {


 $aux = "<option value=''>Selecionar $labelvazio</option>";
 $rs456 = mysqli_query($conexao,$sql);

 if (!$rs456 ) {
        $aux .= printf("Error: %s\n", mysqli_errno($conexao));
        $aux .= "<br> SQL: $sql";

 }


 while($values = mysqli_fetch_array($rs456,MYSQLI_NUM))   {
        $aux .= " entrei ";
        if ($values[0] == $default) {
          $aux .= sprintf("<option value='%s' selected>%s</option>",$values[0],$values[1]);
        } else {
          $aux .= sprintf("<option value='%s'>%s</option>",$values[0],$values[1]);
        }

 }

 return $aux;

}



function getArraySelect($conexao,$sql) {

$rs456 = mysqli_query($conexao,$sql);

$values = array();

while($row1 = mysqli_fetch_array($rs456,MYSQLI_NUM)) {

$values[] = array($row1[0],$row1[1]);

}

return $values;

}

function label($fld, $label) {

$aux = "";

if (is_null($label))

$label = $fld;

$idlab = "lbl".$fld;

$aux .= "<label id='$idlab' for=$fld >$label</label>";

 

return $aux;

}

function duploselectbox($form,$fld, $label, $opcoes,$opcoesdestino, $len ,$qtditens = 5, $obrigatorio=false, $disable = false ) {

 

if ($obrigatorio)

$required = "required";

else {

$required = "";

}



if ($disable)

$disable = "disabled";

else {

$disable = "";

}



$fld_origem = $fld . "_origem";

$fld_destino = $fld . "_destino";

 

 

$aux = "<div class='col-md-{$len}'>";
$aux = "";

//$aux .= label($fld_destino, $label);

$aux .= "<table><tr><td>";

$aux .= "<select $disable class='form-control' id='$fld_origem' name='$fld_origem' size='$qtditens'>";

foreach ($opcoes as $key => $values) {

$aux .= sprintf("<option value='%s'>%s</option>",$values[0],$values[1]);

}

$aux .= "</select></td><td>";



$aux .= "<button type=\"button\" class=\"btn btn-rounded btn-outline-secondary\" onclick=\"transferetodos(document.forms['$form'].elements['$fld_origem'],document.forms['$form'].elements['$fld_destino']);\"> <i class=\"mdi mdi-skip-forward\"></i> </button><br>";



$aux .= "<button type=\"button\" class=\"btn btn-rounded btn-outline-secondary\" onclick=\"transfere(document.forms['$form'].elements['$fld_origem'],document.forms['$form'].elements['$fld_destino']);\"> <i class=\"mdi mdi-arrow-right\"></i> </button><br>";


$aux .= "<button type=\"button\" class=\"btn btn-rounded btn-outline-secondary\" onclick=\"transfere(document.forms['$form'].elements['$fld_destino'],document.forms['$form'].elements['$fld_origem']);\"> <i class=\"mdi mdi-arrow-left\"></i> </button><br>";



$aux .= "<button type=\"button\" class=\"btn btn-rounded btn-outline-secondary\" onclick=\"transferetodos(document.forms['$form'].elements['$fld_destino'],document.forms['$form'].elements['$fld_origem']);\"> <i class=\"mdi mdi-skip-backward\"></i> </button><br>";

$aux .= "</td><td>";



$aux .= "<select $disable class='form-control' id='$fld_destino' name='$fld_destino' size='$qtditens' $required  data-subtipo='duplosel'  >";

foreach ($opcoesdestino as $key => $values) {

$aux .= sprintf("<option value='%s'>%s</option>",$values[0],$values[1]);

}

$aux .= "</select></td></tr></table>";

    //$aux .= "</div>";
    $aux .= "";

return $aux;





}


?>
