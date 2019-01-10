<?php
  class controlalumnos {
    
    
    
    
    function __construct(){
      global $db;
      $this->dbconn = new mysqli($db["dbhost"], $db["dbuser"], $db["dbpass"], $db["dbname"]);
    }
    
    
    
    
    function check_db(){
      if($this->dbconn->connect_error) {
        die("Connection failed: " . $this->dbconn->connect_error);
      }
    }
    
    
    
    
    function installdb(){
      $tabla_alumnos = "CREATE TABLE alumnos (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(30) NOT NULL
      )";
      if ($this->dbconn->query($tabla_alumnos) === TRUE) {
        echo "Tabla Alumnos Creada <br>";
      } else {
        echo "Error creando la tabla alumnos: " . $this->dbconn->error . " <br>";
      }
      
      $tabla_clases = "CREATE TABLE clases (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      clase VARCHAR(30) NOT NULL
      )";
      if ($this->dbconn->query($tabla_clases) === TRUE) {
        echo "Tabla Clases Creada <br>";
      } else {
        echo "Error creando la tabla clases: " . $this->dbconn->error . " <br>";
      }
      
      $tabla_notas = "CREATE TABLE notas (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      id_alumno int(6) NOT NULL,
      id_clase int(6) NOT NULL,
      nota int(6)
      )";
      if ($this->dbconn->query($tabla_notas) === TRUE) {
        echo "Tabla Notas Creada <br>";
      } else {
        echo "Error creando la tabla notas: " . $this->dbconn->error . " <br>";
      }
    }
    
    
    
    
    function create_alumno($name){
      $sql = "INSERT INTO alumnos (name)
      VALUES ('$name')";

      if ($this->dbconn->query($sql) === TRUE) {
          return 1;
      } else {
          return 0;
      }
    }
    
    
    
    
    function create_clase($name){
      $sql = "INSERT INTO clases (clase)
      VALUES ('$name')";

      if ($this->dbconn->query($sql) === TRUE) {
          return 1;
      } else {
          return 0;
      }
    }
    
    
    
    
    function return_alumnos(){
      $sql = "SELECT * FROM alumnos";
      $result = $this->dbconn->query($sql);

      if ($result->num_rows > 0) {
          // 
            ?>
              <select name="alumno">
                <?php
                  while($row = $result->fetch_assoc()) {
                    ?>
                      <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>         
                    <?php
                  }
                ?>
              </select>
            <?php
      } else {
          echo "N/A";
      }
    }
    
    
    
    
    function return_clases(){
      $sql = "SELECT * FROM clases";
      $result = $this->dbconn->query($sql);

      if ($result->num_rows > 0) {
          // 
            ?>
              <select name="clase">
                <?php
                  while($row = $result->fetch_assoc()) {
                    ?>
                      <option value="<?= $row["id"] ?>"><?= $row["clase"] ?></option>         
                    <?php
                  }
                ?>
              </select>
            <?php
      } else {
          echo "N/A";
      }
    }
    
    
    
    
    function assign_clase($alumno, $clase){
      $sql = "INSERT INTO notas (id_alumno, id_clase)
      VALUES ('$alumno', '$clase')";

      if ($this->dbconn->query($sql) === TRUE) {
          return 1;
      } else {
          return 0;
      }
    }
    
    
    
    
    function get_nombre_alumno($id_alumno){
      $sql = "SELECT * FROM alumnos WHERE id = '$id_alumno'";
      $result = $this->dbconn->query($sql);

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            return $row["name"];         
            
          }
      } else {
          echo "N/A";
      }
    }
    
    
    
    
    function get_nombre_clase($id_clase){
      $sql = "SELECT * FROM clases WHERE id = '$id_clase'";
      $result = $this->dbconn->query($sql);

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            return $row["clase"];         
            
          }
      } else {
          echo "N/A";
      }
    }
    
    
    
    
    function return_alumnos_de_clase($idclase){
      $sql = "SELECT * FROM notas WHERE id_clase = '$idclase'";
      $result = $this->dbconn->query($sql);

      if ($result->num_rows > 0) {
          // 
            ?>
              <select name="alumno">
                <?php
                  while($row = $result->fetch_assoc()) {
                    ?>
                      <option value="<?= $row["id_alumno"] ?>"><?= $this->get_nombre_alumno($row["id_alumno"]) ?></option>         
                    <?php
                  }
                ?>
              </select>
            <?php
      } else {
          echo "N/A";
      }
    }
    
    
    
    
    function create_nota($alumno, $clase, $nota){
      $sql = "UPDATE notas SET nota='$nota' WHERE id_clase=$clase && id_alumno=$alumno";

      if ($this->dbconn->query($sql) === TRUE) {
          return 1;
      } else {
          return 0;
      }
    }
    
    
    
    
    function view_notas(){
      
      $sql = "SELECT * FROM notas ORDER BY id_alumno";
      $result = $this->dbconn->query($sql);

      if ($result->num_rows > 0) {
        $currentName = "";
        while($row = $result->fetch_assoc()) {
          ?>
            
            <?php
              //$SameName = 0;
              if($currentName != $this->get_nombre_alumno($row["id_alumno"])){
                ?> <p><b><?= $this->get_nombre_alumno($row["id_alumno"]) ?></b></p> <?php 
              }              
              $currentName = $this->get_nombre_alumno($row["id_alumno"]);
            ?>
            <ul>
              <li><?= $this->get_nombre_clase($row["id_clase"]) ?>: <?= $row["nota"] ?></li>
            </ul>
          <?php
        }
      } else {
          echo "N/A";
      }
      
    }
    
    
    
  }
?>
