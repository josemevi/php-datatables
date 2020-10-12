<?php 
    require('./config/db_connect.php');

    //arrays declaration
    $jsondata = array();
    $error = array();

     //avoid null error
    $nombre = $_POST['nombre'] ?? null;
    $apellido = $_POST['apellido'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $tcliente = $_POST['tcliente'] ?? null;
    //validating and sanitizing fields
    if(!empty($nombre)){
        $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    }else {
        $error["nombre"] = "Nombre vacio";
    }

    if(!empty($apellido)){
        $apellido = mysqli_real_escape_string($con, $_POST['apellido']);
    }else {
        $error["apellido"] = "Apellido vacio";
    }

    if(!empty($direccion)){
        $direccion = mysqli_real_escape_string($con, $_POST['direccion']);
    }else {
        $error["direccion"] = "Direccion vacia";
    }

    if(!empty($tcliente)){
        $tcliente = mysqli_real_escape_string($con, $_POST['tcliente']);
    }else {
        $error["tcliente"] = "Tipò de cliente vacio. como?";
    }

    //sending back error details and setting the error code
    if(count($error) > 0){
        http_response_code(400);
        $error["msg"] = "Empty fields detected";
        $error["status"] = 400;
        echo json_encode($error);
        exit();
    }

    //preparing sql
    $sql = "INSERT into clientes (Nombre, Apellido, Direccion, id_tcliente) VALUES('$nombre','$apellido','$direccion',$tcliente)";
    
    //executing and returning response
    if(mysqli_query($con, $sql)){
        mysqli_close($con);
        http_response_code(200);
        $jsondata["msg"] = "Entry successfully added";
        $jsondata["status"] = 200;
        echo json_encode($jsondata);
        exit();
    }else {        
        http_response_code(500);
        $error["query error"] = mysqli_error($con);
        $error["status"] = 500;
        echo json_encode($error);
        exit();
    }
?>