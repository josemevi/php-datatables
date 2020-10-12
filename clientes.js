$(document).ready(function(){
    var rowData = null;   

    //Fill table        
    var table = $('#table').DataTable({         
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url':'clientes.db.php',
        },
        'columns': [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'apellido' },
            { data: 'direccion' },
            { data: 'tnombre' },
        ],
    });

    //row selection
    $('#table tbody').on( 'click', 'tr', function (){
        rowData = table.row( this ).data();        
        if ( $(this).hasClass('bg-primary') ) {
            $(this).removeClass('bg-primary');
        }
        else {
            table.$('tr.bg-primary').removeClass('bg-primary');
            $(this).addClass('bg-primary');
        }
    });

    //clean form
    $('#clean').click( function (){ 
        $('#nombre').val("");
        $('#apellido').val("");
        $('#direccion').val("");
        $('#tcliente').val(2)
    });

    //delete client
    $('#del').click( function (){
        if(rowData){
            var json = {
                id : rowData.id
            }
            console.log(json);
            $.ajax({
                data: json,
                type: "POST",
                url: "eliminarCliente.php"       
            })
            .done(function(data, textStatus, jqXHR){                
               if(JSON.parse(data).status == 200){
                    alert("Entry Deleted!")
                    window.location.href = "clientes.html";
               }                
            })
            .fail(function(data, textStatus, jqXHR){
                console.log(JSON.parse(data));
                alert("Error : "+JSON.parse(data).msg);
            })
        }else {
            alert("Debe seleccionar una fila")
        }
    });

    //Add Client
    $('#add').click(function (){
        if($('#nombre').val() && $('#apellido').val() && $('#direccion').val() && $('#tcliente').val()){
            let json = {
                nombre: $('#nombre').val(),
                apellido: $('#apellido').val(),
                direccion: $('#direccion').val(),
                tcliente: $('#tcliente').val()
            }
            $.ajax({
                data: json,
                type: "POST",
                url: "agregarCliente.php"       
            })
            .done(function(data, textStatus, jqXHR){
                console.log(data);
               if(JSON.parse(data).status == 200){
                    alert("Entry Added!")
                    window.location.href = "clientes.html";
               }                
            })
            .fail(function(data, textStatus, jqXHR){
                console.log(JSON.parse(data));
                alert("Error : "+JSON.parse(data).msg);
            })
        }else {
            alert("Debe rellenar todos los campos");
        }
    });

    //get client info
    //NOTE: this's really unnecessary since in "rowData" var we already have the
    //client info when we click a row, but since is a point added to the test i will do it
    //in the requested way
    $("#load").click(function (){
        if(rowData){
            var json = {
                id : rowData.id
            }
            $.ajax({
                data: json,
                type: "GET",
                url: "clientes.db.php"       
            })
            .done(function(data, textStatus, jqXHR){
                result = JSON.parse(data);
                $('#nombre').val(result.Nombre);
                $('#apellido').val(result.Apellido);
                $('#direccion').val(result.Direccion);
                $('#tcliente').val(result.id_tcliente);               
            })
            .fail(function(data, textStatus, jqXHR){
                alert("Error");
                // console.log(JSON.parse(data));
                // alert("Error : "+JSON.parse(data).msg);
            })
        }else {
            alert("Debe seleccionar una fila");
        }
    });

    $("#edit").click(function (){
        if(rowData){
            if($('#nombre').val() && $('#apellido').val() && $('#direccion').val() && $('#tcliente').val()){
                let json = {
                    id : rowData.id,
                    nombre: $('#nombre').val(),
                    apellido: $('#apellido').val(),
                    direccion: $('#direccion').val(),
                    tcliente: $('#tcliente').val()
                }
                $.ajax({
                    data: json,
                    type: "POST",
                    url: "editarCliente.php"       
                })
                .done(function(data, textStatus, jqXHR){
                    console.log(data);
                    if(JSON.parse(data).status == 200){
                            alert("Entry Edited!")
                            window.location.href = "clientes.html";
                    }                
                })
                .fail(function(data, textStatus, jqXHR){
                    console.log(data);
                    console.log(JSON.parse(data));
                    alert("Error : "+JSON.parse(data).msg);
                })
            }else {
                alert("Debe 'Cargar Datos' al seleccionar la fila y rellenar todos los campos");
            }
        }else {
            alert("Debe seleccionar una fila");
        }           
    });
})