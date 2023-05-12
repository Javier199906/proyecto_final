$(document).ready(function() {
    var id, opcion;

    function recarga(){
        $("#tabla-compras").dataTable().fnDestroy();
        opcion = 2;

        tabla_c = $('#tabla-compras').DataTable({
            dom: 'Bfrtilp',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="far fa-file-excel excel"></i>',
                    titleAttr: 'Exportar a Excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="far fa-file-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="far fa-file-print"></i>',
                    titleAttr: 'Imprimir',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                }
            ],
            "ajax":{
                "url": "../crud/crud-reportes-compras.php",
                "method": 'POST', //Usamos el metodo POST
                "data":{opcion:opcion, fecha_inicio:fecha_inicio, fecha_fin:fecha_fin}, //Enviamos opcion 2 para que haga un SELECT
                "dataSrc":""
            },
            "columns":[
                {"data": "id_compra"},
                {"data": "usuario"},
                {"data": "fecha"},
                {"data": "hora"},
                {"data": "proveedor"},
                {"data": "total"},
                {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnVerC'><i class='material-icons'>visibility</i></button><button class='btn btn-sm btn-danger btnBorrarC'><i class='material-icons'>delete</i></button></div></div>"}
            ]
        });
    }
    
    var fila; //Captura la fila, para editar o eliminar
    
    //Submit para el Alta y Actualización
    $('#form-compras').submit(function(e){    
        e.preventDefault(); //Evita el comportambiento normal del submit, es decir, recarga total de la página
        fecha_inicio = $.trim($('#fecha-inicio-c').val());
        fecha_fin = $.trim($('#fecha-fin-c').val());

        if(fecha_inicio == ""){
            alert('Inserte la Fecha de Inicio');
            $("#fecha-inicio-c").focus();
            return false;
        }

        if(fecha_fin == ""){
            alert('Inserte la Fecha de Fin');
            $("#fecha-fin-c").focus();
            return false;
        }
    
        recarga();
    });

    //Para limpiar
    $("#btnLimpiar-c").click(function(){
        $("#form-compras").trigger("reset");
        tabla_c.clear().draw();
        $("#tabla-compras").dataTable().fnDestroy();
    });
    
    
    //Ver
    $(document).on("click", ".btnVerC", function(){
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text()); //Capturo el ID
        opcion = 1;
        
        $.ajax({
          url: "../crud/crud-reportes-compras.php",
          type: "POST",
          datatype:"json",
          data:  {opcion:opcion, id:id},
          success: function(data) {
              $('#traertabla').html(data);
          }
        });

        $(".modal-header").css( "background-color", "blue");
        $(".modal-header").css( "color", "white" );
        $(".modal-title").text("Listado de la Compra");
        $('#modal').modal('show');
    });
    
    //Borrar
    $(document).on("click", ".btnBorrarC", function(){
        fila = $(this);
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
        opcion = 3; //Eliminar
        var respuesta = confirm("¿Está seguro de borrar la compra?");
        if (respuesta) {
            $.ajax({
              url: "../crud/crud-reportes-compras.php",
              type: "POST",
              datatype:"json",
              data:  {id:id, opcion:opcion},
              success: function() {
                  tabla_c.row(fila.parents('tr')).remove().draw();
               }
            });
        }
     });
    
});