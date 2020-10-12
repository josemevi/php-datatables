<?php 
    
    require('./config/db_connect.php');
    //distinguish request
    if(!isset($_GET['id'])){
        //Table connection and data
        $draw = $_POST['draw'] ?? 0;
        $row = $_POST['start'] ?? 0;
        $rowperpage = $_POST['length'] ?? 10; // Rows display per page
        $columnIndex = $_POST['order'][0]['column'] ?? null; // Column index    
        $columnName = $_POST['columns'][$columnIndex]['data'] ??'id'; // Column name
        //To avoid error when sorting by tipo cliente
        if(strcmp($columnName, 'tnombre' ) == 0 ){
            $columnSort = "tipo_clientes.";
        }else {
            $columnSort = "clientes.";
        }
        $columnSortOrder = $_POST['order'][0]['dir'] ?? 'asc'; // asc or desc
        $searchV = $_POST['search']['value'] ?? null;
        $searchValue = mysqli_real_escape_string($con,$searchV); // Search value
        $searchQuery = "";


        if($searchValue != ''){
        $searchQuery = "clientes.nombre like '%".$searchValue."%' or 
                clientes.apellido like '%".$searchValue."%' or 
                clientes.direccion like'%".$searchValue."%' ";
        }        

        if(!empty($searchQuery)){
            ## With filter execution
            $sel = mysqli_query($con,"SELECT count(*) AS allcount FROM clientes WHERE ".$searchQuery);            
            $records = mysqli_fetch_assoc($sel);
            $totalRecordwithFilter = $records['allcount'];
            $query = "SELECT clientes.id, clientes.nombre, clientes.apellido, clientes.direccion, tipo_clientes.tnombre
            FROM clientes INNER JOIN tipo_clientes ON clientes.id_tcliente = tipo_clientes.id WHERE ".$searchQuery." order by ".$columnSort.$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
        } else {
            ##  without filter execution
            $sel = mysqli_query($con,"SELECT count(*) AS allcount FROM clientes");
            $records = mysqli_fetch_assoc($sel);
            $totalRecords = $records['allcount'];
            ## to avoid NaN error
            $totalRecordwithFilter = $records['allcount'];
            $query = "SELECT clientes.id, clientes.nombre, clientes.apellido, clientes.direccion, tipo_clientes.tnombre
            FROM clientes INNER JOIN tipo_clientes ON clientes.id_tcliente = tipo_clientes.id order by ".$columnSort.$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
            
        }
        $totalRecords = mysqli_query($con,$query);
        $data = array();
        while ($row = mysqli_fetch_assoc($totalRecords)) {       
            $data[] = array( 
                "id"=>$row['id'],
                "nombre"=>$row['nombre'],
                "apellido"=>$row['apellido'],
                "direccion"=>$row['direccion'],
                "tnombre"=>$row['tnombre']
            );
        }

        ## Response
        $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $records,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
        );
        //remove the result from memory
        mysqli_free_result($totalRecords);
        //close the connection
        mysqli_close($con);

        echo json_encode($response);
           
    //end table connection

    //get client info
    //NOTE: this's a bad practice since we're using the same php archive to storage
    //two differents request; since is a requirement from the test i will do it anyways
    }else {
        $id = mysqli_real_escape_string($con,$_GET['id']);
        $sql = "SELECT * FROM clientes WHERE id=$id";
        $result = mysqli_query($con, $sql);
        $data = array();
        $row = mysqli_fetch_assoc($result);
        //remove the result from memory
        mysqli_free_result($result);
        //close the connection
        mysqli_close($con);
        http_response_code(200);
        echo json_encode($row);
       
    }

?>