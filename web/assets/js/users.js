$(document).ready(function () {
 
    var ias = jQuery.ias({
        container: '.box-users',
        item: '.user-item',
        pagination: '.pagination',
        next: '.pagination .next_link', 
        //loader: '<div class="publication"><img src="/web/assets/images/ajax-loader.gif"/></div>',
        triggerPageThreshold: 3
    });
    
   // ias.extension(new IASTriggerExtension({
    //    text: 'Ver más',
      //  offset: 2
    //}));
 
 
    ias.extension(new IASSpinnerExtension({
        src: dirURL+'/../assets/images/gato200.gif'
    }));
 
    ias.extension(new IASNoneLeftExtension({
        text: 'No hay más usuarios',
    }));
    
    ias.on('ready', function(event){
       followButtons(); 
    });
    ias.on('rendered', function(event){
       followButtons(); 
    });
 
});

function followButtons(){
    $(".btn-follow").unbind("click").click(function(){
        
        
        

        $(this).addClass("d-sm-none");//Ocultar boton de seguir,, con d-sm-none conseguimos que se oculte
        $(this).parent().find(".btn-unfollow").removeClass("d-sm-none"); //hacemos que aparezca el botón de dejar de seguir
        $.ajax({
           url: dirURL+'/follow', type: 'POST',
           data: {followed: $(this).attr("data-followed")},
           success: function(response){
               console.log(response);
           }
        });
     
    
    
    });
     $(".btn-unfollow").unbind("click").click(function () {


            Swal.fire({
                title: '¿Quieres dejar de seguir a este usuario?',
                showCancelButton: true,
                confirmButtonColor: '#78BCBA',
                cancelButtonColor: '#F58248',
                confirmButtonText: 'Sí!',
                cancelButtonText: 'Mejor no'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).addClass("d-sm-none");//Ocultar boton de dejar de seguir,, con d-sm-none conseguimos que se oculte
                    $(this).parent().find(".btn-follow").removeClass("d-sm-none"); //hacemos que aparezca el botón de seguir
                    $.ajax({
                        url: dirURL + '/unfollow', type: 'POST',
                        data: {followed: $(this).attr("data-followed")},
                        success: function (response) {
                            console.log(response);
                        }
                    });

                }
            })





        });
    
    
        
    
}
