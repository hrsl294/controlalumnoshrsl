<?php
  require_once("config.php");
  require_once("class.php");
  $contal = new controlalumnos();
  $contal->check_db();
?>

<ul>
  <li><a href="?a=newalumno">Nuevo Alumno</a></li>
  <li><a href="?a=newclase">Nueva Clase</a></li>
  <li><a href="?a=assignclase">Asignar Clase</a></li>
  <li><a href="?a=newnota">Ingresar Nota</a></li>
  <li><a href="./">Verificar Notas</a></li>
</ul>

<?php
  if(isset($_GET["a"])){
    if($_GET["a"] == "newalumno"){
      ?>
        <form action="?a=pnewalumno" method="post">
          <p>Nombre Alumno:</p>
          <input type="text" name="alumno"><br><br>
          <button type="submit">Guardar</button>
        </form>
      <?php
    }
    if($_GET["a"] == "pnewalumno"){
      if($contal->create_alumno($_POST["alumno"]) == true){
        echo "Alumno creado correctamente <br> <a href='?a=newalumno'>Volver</a>";
      }else{
        echo "Error al crear alumno <br> <a href='?a=newalumno'>Volver</a>";
      }
    }
    
    if($_GET["a"] == "newclase"){
      ?>
        <form action="?a=pnewclase" method="post">
          <p>Nombre Clase:</p>
          <input type="text" name="clase"><br><br>
          <button type="submit">Guardar</button>
        </form>
      <?php
    }
    if($_GET["a"] == "pnewclase"){
      if($contal->create_clase($_POST["clase"]) == true){
        echo "Clase creada correctamente <br> <a href='?a=newclase'>Volver</a>";
      }else{
        echo "Error al crear clase <br> <a href='?a=newclase'>Volver</a>";
      }
    }
    
    if($_GET["a"] == "assignclase"){
      ?>
        <form action="?a=passignclase" method="post">
          <p>Alumno:</p>
          <?php $contal->return_alumnos(); ?><br><br>
          <p>Clase:</p>
          <?php $contal->return_clases(); ?><br><br>
          <button type="submit">Guardar</button>
        </form>
      <?php
    }
    if($_GET["a"] == "passignclase"){
      if($contal->assign_clase($_POST["alumno"], $_POST["clase"]) == true){
        echo "Clase asignada correctamente <br> <a href='?a=assignclase'>Volver</a>";
      }else{
        echo "Error al asignar clase <br> <a href='?a=assignclase'>Volver</a>";
      }
    }
    
    if($_GET["a"] == "newnota"){
      if(isset($_GET["step"])){
        if($_GET["step"] == "2"){
          ?>
            <form action="?a=newnota&step=3" method="post">
              <input type="text" name="clase" value="<?= $_POST['clase'] ?>" style="display:none;">
              <p>Seleccione el alumno:</p>
              <?php $contal->return_alumnos_de_clase($_POST["clase"]); ?><br><br>
              <button type="submit">Siguiente</button>
            </form>
          <?php
        }
        if($_GET["step"] == "3"){
          ?>
            <form action="?a=pnewnota" method="post">
              <p>Nota para <?= $contal->get_nombre_alumno($_POST["alumno"]); ?> en la clase <?= $contal->get_nombre_clase($_POST["clase"]); ?>:</p>
              <input type="text" value="<?= $_POST["clase"] ?>" name="clase" style="display:none;">
              <input type="text" value="<?= $_POST["alumno"] ?>" name="alumno" style="display:none;">
              <input type="number" name="nota"><br><br>
              <button type="submit">Guardar</button>
            </form>
          <?php
        }
      }else{
        ?>
          <form action="?a=newnota&step=2" method="post">
            <p>Clase:</p>
            <?php $contal->return_clases(); ?><br><br>
            <button type="submit">Siguiente</button>
          </form>
        <?php
      }
    }
    if($_GET["a"] == "pnewnota"){
      if($contal->create_nota($_POST["alumno"], $_POST["clase"], $_POST["nota"]) == true){
        echo "Nota ingresada correctamente <br> <a href='?a=newnota'>Volver</a>";
      }else{
        echo "Error al ingresar nota <br> <a href='?a=newnota'>Volver</a>";
      }
    }
  }else{
    $contal->view_notas();
  }
?>
<br><br><br><br>GITHUB: <a href="https://github.com/hrsl294/controlalumnoshrsl">https://github.com/hrsl294/controlalumnoshrsl</a><br><br><br><br>
