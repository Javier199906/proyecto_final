$(document).ready(function() {
    var id, opcion;
    opcion = 4;
    
    tabla = $('#tabla').DataTable({
        dom: 'Bfrtilp',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="far fa-file-excel excel"></i>',
                titleAttr: 'Exportar a Excel',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="far fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'print',
                text: '<i class="far fa-file-print"></i>',
                titleAttr: 'Imprimir',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                }
            }
        ],
        "ajax":{
            "url": "../crud/crud-proveedores.php",
            "method": 'POST', //Usamos el metodo POST
            "data":{opcion:opcion}, //Enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        "columns":[
            {"data": "id"},
            {"data": "nombre"},
            {"data": "correo_electronico"},
            {"data": "telefono"},
            {"data": "direccion"},
            {"data": "ciudad"},
            {"data": "estado"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-warning btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
        ]
    });
    
    var fila; //Captura la fila, para editar o eliminar
    
    //Submit para el Alta y Actualización
    $('#form').submit(function(e){    
        e.preventDefault(); //Evita el comportambiento normal del submit, es decir, recarga total de la página
        nombre = $.trim($('#nombre').val());
        correo_electronico = $.trim($('#correo-electronico').val());
        telefono = $.trim($('#telefono').val());
        direccion = $.trim($('#direccion').val());
        ciudad = parseInt($("#ciudad").val());
        estado = 1;
    
        if(nombre == ""){
            alert('Inserte el Nombre');
            $("#nombre").focus();
            return false;
        }

        if(correo_electronico == "" || !correo_electronico.match(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/)){
            alert('Inserte el Correo');
            $("#correo-electronico").focus();
            return false;
        }
    
        if(telefono == "" || telefono.length != 10){
            alert('Inserte el Telefono');
            $("#telefono").focus();
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

        if(!$("#input-estado").attr("hidden")){

            if($('#input-estado').val() == ""){
                alert('Inserte el Estado');
                $("#input-estado").focus();
                return false;
            }else{
                estado = parseInt($('#input-estado').val());
                if(estado < 0 || estado > 1){
                    alert('Inserte un valor valido');
                    $("#input-estado").focus();
                    return false;
                }
            }
            
        }
    
        $.ajax({
          url: "../crud/crud-proveedores.php",
          type: "POST",
          datatype:"json",
          data:  {id:id, nombre:nombre, correo_electronico:correo_electronico, telefono:telefono, direccion:direccion, ciudad:ciudad, estado:estado, opcion:opcion},
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

        $("#input-estado").attr("hidden", "hidden");
        $("#label-estado").attr("hidden", "hidden");
        
        $("#form").trigger("reset");
        $(".modal-header").css( "background-color", "blue");
        $(".modal-header").css( "color", "white" );
        $(".modal-title").text("Registrar Proveedor");
        $('#modal').modal('show');
    });
    
    //Editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text()); //Capturo el ID
        nombre = fila.find('td:eq(1)').text();
        correo_electronico = fila.find('td:eq(2)').text();
        telefono = fila.find('td:eq(3)').text();
        direccion = fila.find('td:eq(4)').text();

        $("#nombre").val(nombre);
        $("#correo-electronico").val(correo_electronico);
        $("#telefono").val(telefono);
        $("#direccion").val(direccion);

        nombre_foranea = fila.find('td:eq(5)').text();
        tabla_foranea = "ciudades";
    
        opcion = 5;
        
        $.ajax({
          url: "../crud/crud-proveedores.php",
          type: "POST",
          datatype:"json",
          data:  {opcion:opcion, tabla_foranea:tabla_foranea, nombre_foranea:nombre_foranea},
          success: function(data) {
              $('#ciudad').val(data);
          }
        });

        estado = fila.find('td:eq(6)').text();
        $("#input-estado").val(estado);
        
        $("#input-estado").removeAttr("hidden");
        $("#label-estado").removeAttr("hidden");
    
        opcion = 2;//Modificar
    
        $(".modal-header").css("background-color", "yellow");
        $(".modal-header").css("color", "black" );
        $(".modal-title").text("Editar Proveedor");
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
              url: "../crud/crud-proveedores.php",
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