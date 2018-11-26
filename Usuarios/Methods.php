<?php

/**
 * Clase para editar y borrar
 */
class ClassName
{

  function __construct(argument)
  {
  }


  function update(){
    $db= new Database();
    $dblink= $db->getConnection();
    $_categoriaUsuario= $_POST['Categoria'];
    $_nombre= $_POST['nombre'];
    $_interno= $_POST['numInt'];
    $_Email= $_POST['correo'];
    $_aulas= $_POST['aula'];
    $_categorias= $_POST['categoria'];

  $sql = " UPDATE usuarios SET nombre = '$_nombre', num_interno ='$_interno', E_Mail= '$_Email', Rol='$_categoriaUsuario' WHERE id_Usuario=$_idDeUsuario;";
  echo "$sql";
  if ($dblink->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $dblink->error;
  }
}


}



?>
