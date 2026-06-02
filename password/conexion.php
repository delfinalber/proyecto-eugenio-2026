
<?php

//Conexion por procedimientos

        $link = mysqli_connect("localhost","root","","eugenio_2026_comercio");

        if(!$link){
           die ("Conexión fallida: " . mysqli_connect_error());
            echo "Acceso denegado :-(";
        }
?>