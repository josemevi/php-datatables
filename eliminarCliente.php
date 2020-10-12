<?php 
    require('./config/db_connect.php');

    //arrays declaration
    $jsondata = array();
    $error = array();

     //avoid null error
    $id = $_POST['id'] ?? null;
    
    //validating and sanitizing fields
    if(!empty($id)){
        $id = mysqli_real_escape_string($con, $_POST['id']);
    }else {
        $error["id"] = "ID Vacio";
    }

    //sending back error details and setting the error code
    if(count($error) > 0){
        http_response_code(400);
        $error["msg"] = "ID vacio";
        $error["status"] = 400;
        echo json_encode($error);
        exit();
    }

    //preparing sql
    $sql = "DELETE FROM clientes WHERE id=$id";
    
    //executing and returning response
    if(mysqli_query($con, $sql)){
        mysqli_close($con);
        http_response_code(200);
        $jsondata["msg"] = "Entry successfully deleted";
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