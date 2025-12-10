<?php
include "../../Conexion/Conexion.php";

$tests = $conexion->getConnect("SELECT * FROM tests");
while($t = $tests->fetch_assoc()){
    echo "<a href='responder.php?id=".$t['id']."'>
            <div class='card p-3 m-2'>
                <h4>".$t['titulo']."</h4>
            </div>
          </a>";
}
?>