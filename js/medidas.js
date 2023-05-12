$(document).ready(function() {
var id, opcion;
opcion = 4;

tabla = $('#tabla').DataTable({
    "ajax":{
        "url": "../crud/crud-medidas.php",
        "method": 'POST', //Usamos el metodo POST
        "data":{opcion:opcion}, //Enviamos opcion 4 para que haga un SELECT
        "dataSrc":""
    },
    "columns":[
        {"data": "id"},
        {"data": "nombre"},
        {"data": "abreviatura"},
        {"data": "estado"},
        {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-warning btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
    ]
});

var fila; //Captura la fila, para editar o eliminar

//Submit para el Alta y Actualización
$('#form').submit(function(e){    
    e.preventDefault(); //Evita el comportambiento normal del submit, es decir, recarga total de la página
    nombre = $.trim($('#nombre').val());
    abreviatura = $.trim($('#abreviatura').val());
    estado = 1;

    if(nombre == ""){
        alert('Inserte el Nombre');
        $("#nombre").focus();
        return false;
    }

    if(abreviatura == ""){
        alert('Inserte la Abreviatura');
        $("#abreviatura").focus();
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
      url: "../crud/crud-medidas.php",
      type: "POST",
      datatype:"json",
      data:  {id:id, nombre:nombre, abreviatura:abreviatura, estado:estado, opcion:opcion},
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
    $(".modal-title").text("Registrar Medida");
    $('#modal').modal('show');
});

//Editar
$(document).on("click", ".btnEditar", function(){
    opcion = 2;//Modificar
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text()); //Capturo el ID
    nombre = fila.find('td:eq(1)').text();
    abreviatura = fila.find('td:eq(2)').text();
    estado = fila.find('td:eq(3)').text();
    
    $("#input-estado").removeAttr("hidden");
    $("#label-estado").removeAttr("hidden");
    
    $("#nombre").val(nombre);
    $("#abreviatura").val(abreviatura);
    $("#input-estado").val(estado);
    
    $(".modal-header").css("background-color", "yellow");
    $(".modal-header").css("color", "black" );
    $(".modal-title").text("Editar Medida");
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
          url: "../crud/crud-medidas.php",
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