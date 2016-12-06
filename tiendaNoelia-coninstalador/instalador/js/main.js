$(document).ready(function(){
    var datos = {
        'db':{
            'dbuser':'',
            'dbpass':'',
            'host':'',
            'database':''
        },
        'admin':{
            'email':'',
            'login':'',
            'password':''
        }
    };
    
    
    $("#btn_crear").click(function(){
        $.each(datos, function(clave, bloque){
           $.each(bloque, function(id, valor){
             datos[clave][id] = $("#"+id).val();  
           });
        });
        $.ajax({
            async:true,
            type:'GET',
            url:"./php/crearDBConfig.php",
            data: datos,
            success:function(response){
                var resultado = JSON.parse(response);
                console.log(JSON.stringify(resultado, null, 2));
                $("#feedback").empty().hide().append('<div class="alert alert-'+resultado.feedback.tipo+'">'+resultado.feedback.mensaje+'</div>').fadeIn(500).delay(3000).fadeOut(500);
            },
            error: function(){}
        });
    });
});