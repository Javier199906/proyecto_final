$(document).ready(function() {

    $("#producto").select2({
        placeholder: "Teclee el nombre del producto",
        allowClear: false,
        language: { 
          noResults: function() {
            return "No hay resultados";
          },
          searching: function() {
            return "Buscando..";
          }
        }
    });

    $("#cliente").select2({
        placeholder: "Teclee el nombre del producto",
        allowClear: false,
        language: { 
          noResults: function() {
            return "No hay resultados";
          },
          searching: function() {
            return "Buscando..";
          }
        }
    });

    function Total(){
        opcion = 7;
        $.ajax({
          url: "../crud/crud-ventas.php",
          type: "POST",
          datatype:"json",
          data:  {opcion:opcion},
          success: function(data) {
            $('#total').val(data);
          }
        });
    }

    var id, opcion;
    opcion = 4;
    
    tabla = $('#tabla').DataTable({
        "ajax":{
            "url": "../crud/crud-ventas.php",
            "method": 'POST', //Usamos el metodo POST
            "data":{opcion:opcion}, //Enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        "columns":[
            {"data": "id"},
            {"data": "id_producto"},
            {"data": "producto"},
            {"data": "descripcion"},
            {"data": "precio_unitario"},
            {"data": "cantidad"},
            {"data": "importe"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-warning btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
        ]
    });

    Total();

    $("#producto").change(function() {
        opcion = 8;
        producto = parseInt($('#producto').val());

        $.ajax({
          url: "../crud/crud-ventas.php",
          type: "POST",
          datatype:"json",
          data:  {producto:producto, opcion:opcion},
          success: function(data) {
              $("#precio-venta").val(data);
          }
        });
    });

    $("#efectivo").keyup(function() {
        if(!$('#efectivo').val() == ""){
            efectivo = parseInt($('#efectivo').val());
            total = parseInt($('#total').val());
            if(!(efectivo < total)){
                cambio = efectivo - total;
                $('#cambio').val(cambio);
            }else{
                $('#cambio').val("");   
            }
        }else{
            $('#cambio').val(""); 
        }
    });
    
    var fila; //Captura la fila, para editar o eliminar
    
    //Submit para el Alta y Actualización
    $('#form').submit(function(e){
        if($('#btnAgregar').length > 0){
            opcion = 1;//Agregar
        } else{
            opcion = 2;//Modificar
        }

        e.preventDefault(); //Evita el comportambiento normal del submit, es decir, recarga total de la página
        producto = parseInt($('#producto').val());

        if(producto == 0){
            alert('Eliga un producto');
            $("#producto").focus();
            return false;
        }
        
        if($('#precio-venta').val() == ""){
            alert('Inserte el Precio de Venta');
            $("#precio-venta").focus();
            return false;
        }else{
            precio_unitario = parseInt($('#precio-venta').val());
            
            __opcion = opcion;
            opcion = 10;
            
            precio_compra = true;
            
            $.ajax({
              url: "../crud/crud-ventas.php",
              type: "POST",
              datatype:"json",
              data:  {producto:producto, opcion:opcion},
              async: false,
              success: function(data) {
                  if(precio_unitario <= data){
                    alert("Existe un problema de precios\nConsulte al administrador para solucionar el problema");
                    precio_compra = false;
                  }
              }
            });
        }

        if(precio_compra){
            opcion = __opcion;

            if($('#cantidad').val() == ""){
                alert('Inserte la Cantidad');
                $("#cantidad").focus();
                return false;
            }else{
                cantidad = parseInt($('#cantidad').val());
                if(cantidad <= 0){
                    alert('Inserte una Cantidad Valida');
                    $("#cantidad").focus();
                    return false;
                }
            }

            _opcion = opcion;
            opcion = 9;

            stock = true;

            $.ajax({
            url: "../crud/crud-ventas.php",
            type: "POST",
            datatype:"json",
            data:  {producto:producto, opcion:opcion},
            async: false,
            success: function(data) {
                if(data < cantidad){
                    alert("Cantidad no disponible\nStock: " + data);
                    $("#cantidad").focus();
                    stock = false;
                }
            }
            }); 

            if(stock){
                opcion = _opcion;
        
                $.ajax({
                url: "../crud/crud-ventas.php",
                type: "POST",
                datatype:"json",
                data:  {id:id, producto:producto, precio_unitario:precio_unitario, cantidad:cantidad, opcion:opcion},
                success: function(data) {
                    tabla.ajax.reload(null, false);
                    
                    if(opcion == 2){
                        $("#btnModificar").attr("id", "btnAgregar");
                        $("#btnAgregar").attr("class", "btn btn-primary");
                        $("#btnAgregar").html("Agregar");
                    }
                    
                    Total();
            
                    $("#producto").select2("val", "0");
                    $("#precio-venta").val("");
                    $("#cantidad").val("");
                }
                });
            }
        }
    });
    
     
    
    //Para limpiar los campos
    $("#btnLimpiar").click(function(){
        $("#btnModificar").attr("id", "btnAgregar");
        $("#btnAgregar").html("Agregar");
        $("#btnAgregar").attr("class", "btn btn-primary");

        $("#producto").select2("val", "0");
        $("#precio-venta").val("");
        $("#cantidad").val("");
    });
    
    //Editar
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text()); //Capturo el ID
        producto = fila.find('td:eq(1)').text(); //Capturo el ID
        precio_unitario = fila.find('td:eq(4)').text();
        cantidad = fila.find('td:eq(5)').text();

        $("#btnAgregar").attr("id", "btnModificar");
        $("#btnModificar").html("Modificar");
        $("#btnModificar").attr("class", "btn btn-warning");

        $("#producto").select2("val", producto);
        $("#precio-venta").val(precio_unitario);
        $("#cantidad").val(cantidad);
    });
    
    //Borrar
    $(document).on("click", ".btnBorrar", function(){
        fila = $(this);
        id = parseInt($(this).closest('tr').find('td:eq(0)').text());
        opcion = 3; //Eliminar
        var respuesta = confirm("¿Está seguro de borrar el registro?");
        if (respuesta) {
            $.ajax({
              url: "../crud/crud-ventas.php",
              type: "POST",
              datatype:"json",
              data:  {opcion:opcion, id:id},
              success: function() {
                  tabla.row(fila.parents('tr')).remove().draw();
                  Total();
               }
            });
        }
    });

    $('#form2').submit(function(e){    
        e.preventDefault(); //Evita el comportambiento normal del submit, es decir, recarga total de la página
        opcion = 6;
        cliente = parseInt($('#cliente').val());
        total = parseInt($('#total').val())

        if(cliente == 0){
            alert('Eliga un cliente');
            $("#cliente").focus();
            return false;
        }

        if($('#efectivo').val() == ""){
            alert('Inserte el Efectivo');
            $("#efectivo").focus();
            return false;
        }else{
            efectivo = parseInt($('#efectivo').val());
            if(efectivo < total){
                alert('Pago Insuficiente');
                $("#efectivo").focus();
                return false;
            }
        }
    
        $.ajax({
          url: "../crud/crud-ventas.php",
          type: "POST",
          datatype:"json",
          data:  {cliente:cliente, total:total, opcion:opcion},
          success: function(data) {
            tabla.ajax.reload(null, false);

            $("#producto").select2("val", "0");
            
            $("#precio-venta").val("");
            $("#cantidad").val("");

            $("#cliente").select2("val", "0");
            $("#total").val(0);
            $("#efectivo").val("");
            $("#cambio").val("");

            window.open("../crud/factura.php");
           }
        });
    });

     $("#btnCancelar").click(function(){
        if(tabla.rows().count() > 0){
            var respuesta = confirm("¿Está seguro de cancelar la venta?");
            if (respuesta) {
                opcion = 5;

                $.ajax({
                  url: "../crud/crud-ventas.php",
                  type: "POST",
                  datatype:"json",
                  data:  {opcion:opcion},
                  success: function() {
                    tabla.ajax.reload(null, true);

                    $("#producto").select2("val", "0");
                    $("#precio-venta").val("");
                    $("#cantidad").val("");

                    $("#cliente").select2("val", "0");
                    $('#total').val(0);
                    $("#efectivo").val("");
                    $("#cambio").val("")  ; 
                }
                });
            }
        }
    });
    
});