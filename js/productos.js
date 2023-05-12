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
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="far fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                }
            },
            {
                extend: 'print',
                text: '<i class="far fa-file-print"></i>',
                titleAttr: 'Imprimir',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                }
            }
        ],
        "ajax":{
            "url": "../crud/crud-productos.php",
            "method": 'POST', //Usamos el metodo POST
            "data":{opcion:opcion}, //Enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        "columns":[
            {"data": "id"},
            {"data": "codigo"},
            {"data": "nombre"},
            {"data": "descripcion"},
            {"data": "unidad_medida"},
            {"data": "categoria"},
            {"data": "precio_compra"},
            {"data": "precio_venta"},
            {"data": "stock"},
            {"data": "estado"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-warning btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
        ]
    });
    
    var fila; //Captura la fila, para editar o eliminar
    
    //Submit para el Alta y Actualización
    $('#form').submit(function(e){    
        e.preventDefault(); //Evita el comportambiento normal del submit, es decir, recarga total de la página
        nombre = $.trim($('#nombre').val());
        descripcion = $.trim($('#descripcion').val());
        unidad_medida = $.trim($('#unidad-medida').val());
        categoria = $.trim($('#categoria').val());
        
        estado = 1;
    
        if(nombre == ""){
            alert('Inserte el Nombre');
            $("#nombre").focus();
            return false;
        }

        if(descripcion == ""){
            alert('Inserte la Descripcion');
            $("#descripcion").focus();
            return false;
        }

        if(unidad_medida == 0){
            alert('Eliga una Unidad de Medida');
            $("#unidad-medida").focus();
            return false;
        }

        if(categoria == 0){
            alert('Eliga una Categoria');
            $("#categoria").focus();
            return false;
        }

        if($('#precio-compra').val() == ""){
            alert('Inserte el Precio de Compra');
            $("#precio-compra").focus();
            return false;
        }else{
            precio_compra = parseInt($('#precio-compra').val());
            if(precio_compra < 0){
                alert('Inserte un Precio de Compra Valido');
                $("#precio-compra").focus();
                return false;
            }
        }

        if($('#precio-venta').val() == ""){
            alert('Inserte el Precio de Venta');
            $("#precio-venta").focus();
            return false;
        }else{
            precio_venta = parseInt($('#precio-venta').val());
            if(precio_venta <= precio_compra){
                alert('El Precio de Venta DEBE SER MAYOR que el Precio de Compra');
                $("#precio-venta").focus();
                return false;
            }
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
          url: "../crud/crud-productos.php",
          type: "POST",
          datatype:"json",
          data:  {id:id, nombre:nombre, descripcion:descripcion, unidad_medida:unidad_medida, categoria:categoria, precio_compra:precio_compra, precio_venta:precio_venta, estado:estado, opcion:opcion},
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
        $(".modal-title").text("Registrar Producto");
        $('#modal').modal('show');
    });
    
    //Editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text()); //Capturo el ID
        nombre = fila.find('td:eq(2)').text();
        descripcion = fila.find('td:eq(3)').text();

        $("#nombre").val(nombre);
        $("#descripcion").val(descripcion);

        nombre_foranea = fila.find('td:eq(4)').text();
        tabla_foranea = "unidadesmedida";
    
        opcion = 5;
        
        $.ajax({
          url: "../crud/crud-productos.php",
          type: "POST",
          datatype:"json",
          data:  {opcion:opcion, tabla_foranea:tabla_foranea, nombre_foranea:nombre_foranea},
          success: function(data) {
              $('#unidad-medida').val(data);
          }
        });
        
        nombre_foranea = fila.find('td:eq(5)').text();
        tabla_foranea = "categorias";
    
        opcion = 5;
        
        $.ajax({
          url: "../crud/crud-productos.php",
          type: "POST",
          datatype:"json",
          data:  {opcion:opcion, tabla_foranea:tabla_foranea, nombre_foranea:nombre_foranea},
          success: function(data) {
              $('#categoria').val(data);
          }
        });
        
        precio_compra = fila.find('td:eq(6)').text();
        precio_venta = fila.find('td:eq(7)').text();
        stock = fila.find('td:eq(8)').text();

        $("#precio-compra").val(precio_compra);
        $("#precio-venta").val(precio_venta);
        $("#stock").val(stock);
        
        
        estado = fila.find('td:eq(9)').text();
        $("#input-estado").val(estado);
        
        $("#input-estado").removeAttr("hidden");
        $("#label-estado").removeAttr("hidden");
    
        opcion = 2;//Modificar
    
        $(".modal-header").css("background-color", "yellow");
        $(".modal-header").css("color", "black" );
        $(".modal-title").text("Editar Producto");
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
              url: "../crud/crud-productos.php",
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