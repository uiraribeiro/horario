<?php

include_once "config.php";
$conntemp = conectadb($banco);

$montante = $_POST['montante'];   // department id


// pega campos do montante
$sql = "SELECT m.idcurso,nome,turno,serie,numero,CONCAT(serie,' Periodo ',nome,' ',turno,numero) AS titulo
FROM montante m INNER JOIN curso c ON (m.idcurso = c.idcurso)
WHERE idmont = $montante";
$result = mysqli_query($conntemp,$sql);
$mont = mysqli_fetch_array($result);
$curso = $mont['idcurso'];
$serie = $mont['serie'];
$turno = $mont['turno'];
// pega disciplinas do curriculo do curso e serie do montante
$sql = "SELECT t1.iddisc, t1.serie, t2.nome_disc 
FROM curriculo t1 LEFT JOIN disciplina t2 ON t1.iddisc = t2.iddisc 
WHERE curso = '$curso' AND t1.serie = $serie ORDER BY t1.serie, t1.iddisc";

$result2 = mysqli_query($conntemp,$sql);


$aux = "<div class=\"card\">
       <div class=\"card-header\">";
$aux .= $mont['titulo'] ;
$aux .= "</div>";
$aux .= "<div class=\"card-body\">";
$aux .= "<table class=\"table table-bordered\" id='table_turma'>";
$aux .= "<thead>";
$aux .= "<tr><th>Código</th><th>Disciplina</th><th>Turma</th><th>Professor</th><th>Sala</th><th>Alterar</th><th>Criar</th></tr>";
$aux .= "</thead>";
$aux .= "<tbody>";

while( $row = mysqli_fetch_array($result2) ){
    $iddisc = $row['iddisc'];
    $nomedisc = $row['nome_disc'];
    $textobotao = "Criar Turma $iddisc";
    // monta 1 linha com disciplina do curriculo
    $aux .= "<tr>";
    $aux .= "<td>$iddisc</td>";
    $aux .= "<td>$nomedisc</td>";
    $aux .= "<td></td>";    
    $aux .= "<td></td>";    
    $aux .= "<td></td>";   
    $aux .= "<td></td>";   
    $aux .= "<td><button type=\"button\" class=\"btn btn-primary\" data-prof='0' data-turma = \"0\"  data-disc = \"$iddisc\"  data-curso = \"$curso\" data-toggle=\"modal\" data-target=\"#exampleModal\"  >$textobotao</button></td>";    
    $aux .= "</tr>";


    $sql = "SELECT mt.idturma,turma,t.idprof,nome,CONCAT(bloco,'/',s.sala) AS sala,idsala
    FROM mont_turma mt INNER JOIN montante m ON (mt.idmont = m.idmont)
    INNER JOIN turma t ON (mt.idturma = t.idturma ) LEFT JOIN professor p ON (t.idprof = p.idprof) 
    LEFT JOIN sala s ON (t.sala = s.idsala)
    WHERE mt.idmont = $montante AND iddisc = '$iddisc'";

    $result3 = mysqli_query($conntemp,$sql);
    while( $turma = mysqli_fetch_array($result3) ){
       
        $aux .= "<tr>";
        $aux .= "<td></td>";
        $aux .= "<td></td>";
        $aux .= "<td><center>".$turma['turma']."</center></td>";    
        $aux .= "<td>".$turma['nome']."</td>"; 
        $aux .= "<td>".$turma['sala']."</td>"; 
        $aux .= "<td><button type=\"button\" class=\"btn btn-primary\" data-sala='".$turma['idsala']."' data-prof='".$turma['idprof']."'  data-turma = '".$turma['idturma'] ."' data-disc = \"$iddisc\" data-curso = \"$curso\" data-toggle=\"modal\" data-target=\"#exampleModal\" >Altera Prof</button></td>";  
        $aux .= "<td></td>";  
        $aux .= "</tr>";

    }    


}
$aux .= "</tbody>";
$aux .= "</table>";
$aux .= "</div>"; // fim card body
$aux .= "</div>";

$aux .= "
<div class=\"modal merda\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
<div class=\"modal-dialog\" role=\"document\">
  <div class=\"modal-content\">
    <div class=\"modal-header\">
      <h5 class=\"modal-title\" id=\"exampleModalLabel\"></h5>
      <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
      </button>
    </div>
    <div class='modal-body'>
                  <input type='hidden' id='idcur' name='idcur'>
                  <input type='hidden' id='idtur' name='idtur'>
                  <input type='hidden' id='iddis' name='iddis'>
                 
                  <label>Professor </label>
                  <select name='proid' id='proid' class=\"form-control\" required >";
                  $aux .= "<option value='0'> -- Selecione o Professor -- </option>";
                  $sql = "SELECT pc.idprof,nome 
                          FROM prof_curso pc INNER JOIN professor p ON (pc.idprof = p.idprof AND curso = '$curso')
                          ORDER BY nome";
                    $rstemp_query=mysqli_query($conntemp,$sql);
                    $rstemp=mysqli_fetch_array($rstemp_query);
                    while(!($rstemp==0))
                    {
                          $aux .= "<option value='".$rstemp["idprof"]."'>".$rstemp["nome"]."</option>";
                          $rstemp=mysqli_fetch_array($rstemp_query);	
                    }
                    $aux .= "</select>";

                    $aux .= "<label>Sala </label>
                    <select name='idsala' id='idsala' class=\"form-control\" >";
                    $aux .= "<option value=''> -- Selecione a Sala -- </option>";
                    $sql = "SELECT idsala,CONCAT(bloco,'/',sala) AS nome
                            FROM sala ";
                    $rstemp_query=mysqli_query($conntemp,$sql);
                    $rstemp=mysqli_fetch_array($rstemp_query);
                    while(!($rstemp==0))
                    {
                            $aux .= "<option value='".$rstemp["idsala"]."'>".$rstemp["nome"]."</option>";
                            $rstemp=mysqli_fetch_array($rstemp_query);	
                    }
                    $aux .= "</select>";


      $aux .= "
      </form>
    </div>
    <div class='modal-footer'>

      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
      <button type='button' class='btn btn-primary' onclick=\"salvar('$turno','$montante');\">Salvar </button>

    </div>
  </div>
</div>
</div>";

// returno jax html
echo $aux;

?>