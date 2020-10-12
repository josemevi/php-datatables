<?php 

    $con = mysqli_connect('localhost','admin','masterkey','proyectran');

    if(!$con){
        die('Connection error: ' . mysqli_connect_error()); 
    }

?>