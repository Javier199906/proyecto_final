$(document).ready(function() {
    var id, opcion;
    opcion = 4;
    
    tabla = $('#tabla').DataTable({
        "ajax":{
            "url": "../crud/crud-sucursales.php",
            "method": 'POST', //Usamos el metodo POST
            "data":{opcion:opcion}, //Enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        "columns":[
            {"data": "id"},
            {"data": "nombre"},
            {"data": "direccion"},
            {"data": "ciudad"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-warning btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
        ]
    });
    
    var fila; //Captura la fila, para editar o eliminar
    
    //Submit para el Alta y Actualización
    $('#form').submit(function(e){    
        e.preventDefault(); //Evita el comportambiento normal del submit, es decir, recarga total de la página
        nombre = $.trim($('#nombre').val());
        direccion = $.trim($('#direccion').val());
        ciudad = parseInt($("#ciudad").val());
    
        if(nombre == ""){
            alert('Inserte el Nombre');
            $("#nombre").focus();
            return false;
        }
    
        if(direccion == ""){
            alert('Inserte la Direccion');
            $("#direccion").focus();
            return false;
        }
    
        if(ciudad == 0){
            alert('Eliga una ciudad');
            $("#ciudad").focus();
            return false;
        }
    
        $.ajax({
          url: "../crud/crud-sucursales.php",
          type: "POST",
          datatype:"json",
          data:  {id:id, nombre:nombre, direccion:direccion, ciudad:ciudad, opcion:opcion},
          success: function(data) {
            tabla.ajax.reload(null, false);
           }
        });

        $('#modal').modal('hide');
    });
    
     
    
    //Para limpiar los campos antes de dar de Alta una Persona
    $("#btnNuevo").click(function(){
        opcion = 1; //Alta
        id=null;
        
        $("#form").trigger("reset");
        $(".modal-header").css( "background-color", "blue");
        $(".modal-header").css( "color", "white" );
        $(".modal-title").text("Registrar Sucursal");
        $('#modal').modal('show');
    });
    
    //Editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text()); //Capturo el ID
        nombre = fila.find('td:eq(1)').text();
        direccion = fila.find('td:eq(2)').text();
        nombre_foranea = fila.find('td:eq(3)').text();

        tabla_foranea = "ciudades";

        $("#nombre").val(nombre);
        $("#direccion").val(direccion);
    
        opcion = 5;
        
        $.ajax({
            url: "../crud/crud-sucursales.php",
            type: "POST",
            datatype:"json",
            data:  {opcion:opcion, tabla_foranea:tabla_foranea, nombre_foranea:nombre_foranea},
            success: function(data) {
                $('#ciudad').val(data);
             }
        });
    
        opcion = 2;//Modificar
    
        $(".modal-header").css("background-color", "yellow");
        $(".modal-header").css("color", "black" );
        $(".modal-title").text("Editar Sucursal");
        $('#modal').modal('show');
    });
    
    //Borrar
    $(document).on("click", ".btnBorrar", function(){
        fila = $(this);
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
        opcion = 3; //Eliminar
        var respuesta = confirm("¿Está seguro de borrar el registro?");
        if (respuesta) {
            $.ajax({
              url: "../crud/crud-sucursales.php",
              type: "POST",
              datatype:"json",
              data:  {opcion:opcion, id:id},
              success: function() {
                  tabla.row(fila.parents('tr')).remove().draw();
               }
            });
        }
     });
    
});