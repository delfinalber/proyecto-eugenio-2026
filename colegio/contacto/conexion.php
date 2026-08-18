<?php

//Conexion por procedimientos

        $link = mysqli_connect("localhost","root","","eugenio_pagina_web");

        if(!$link){
           die ("Conexión fallida: " . mysqli_connect_error());
            echo "Acceso denegado :-(";
        }
?>