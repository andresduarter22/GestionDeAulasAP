<?php

class csv
{

  public function import($file){
    $file = fopen($file, 'r');
    $cont=1;
    while ($row = fgetcsv($file)) {
    
      if($cont>1){
        $numero = count($row);
        for ($c=0; $c < $numero; $c++) {
        echo $row[$c] . "<br />\n";
          CrearCaracter($row[$c]);
        }
      }
      $cont++;
    }
  }

  public function CrearCaracter($cadena){
    $_Materia;
    $_FechaInicio;
    $_FechaFinal;
    $_Horario;
    $_Aula;
    $_Docente;
    $_largo=strlen($cadena);
    echo "$_largo";

  }

}





  ?>
