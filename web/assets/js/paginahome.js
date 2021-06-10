$(document).ready(function () {

    var ias = jQuery.ias({
        container: '#timeline',
        item: '.publication-item',
        pagination: '#timeline .pagination',
        next: '#timeline .pagination .next_link',
        //loader: '<div class="publication"><img src="/web/assets/images/ajax-loader.gif"/></div>',
        triggerPageThreshold: 5
    });




    ias.extension(new IASSpinnerExtension({
        src: dirURL + '/../assets/images/gato200.gif'
    }));

    ias.extension(new IASNoneLeftExtension({
        text: 'Ups!... Parece que esto era todo',

    }));

    ias.on('ready', function (event) {
        botones();
    });
    ias.on('rendered', function (event) {
        botones();
    });

});


function botones() {


    $(document).ready(function () {




        $(".btn-follow").unbind("click").click(function () {




            $(this).addClass("d-sm-none");//Ocultar boton de seguir,, con d-sm-none conseguimos que se oculte
            $(this).parent().find(".btn-unfollow").removeClass("d-sm-none"); //hacemos que aparezca el botón de dejar de seguir
            $.ajax({
                url: dirURL + '/follow', type: 'POST',
                data: {followed: $(this).attr("data-followed")},
                success: function (response) {
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




        $(".borrarpubli").unbind('click').click(function () {


            Swal.fire({
                title: '¿Quieres borrar el Thought?',
                text: "Borrarlo será irreversible y nadie podrá volver a verlo.",
                //icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#78BCBA',
                cancelButtonColor: '#F58248',
                confirmButtonText: 'Sí, ¡bórralo!',
                cancelButtonText: 'Voy a pensarlo mejor'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent().parent().addClass('d-sm-none');
                    $.ajax({
                        url: dirURL + '/thought/borrar/' + $(this).attr("data-id"),
                        type: 'GET',

                        success: function (response) {

                            console.log(response);
                            $(".estadisticas").load(" .estadisticas");

                        }
                    });

                }
            })



        });


        $(".btn-synergy").unbind('click').click(function () {


            var id = $(this).attr("data-id");
            var numberLike = parseInt($(this).attr("data-like")) + 1;
            $(this).attr("data-like", numberLike);
            $(this).parent().find('.btn-unsynergy').attr("data-like", numberLike);

            $(this).addClass("d-sm-none");
            $(this).parent().find('.btn-unsynergy').removeClass("d-sm-none");

            $.ajax({
                url: dirURL + '/synergy/' + $(this).attr("data-id"),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $(".estadisticas").load(" .estadisticas");
                    $("#conLik" + id).empty();
                    $("#conLik" + id).html(numberLike);

                }
            });

            Swal.fire({
                position: 'top',
                icon: 'success',
                title: 'Thought añadido a Synergies',
                showConfirmButton: false,
                timer: 1500
            })

        });

        $(".btn-unsynergy").unbind('click').click(function () {


            var id = $(this).attr("data-id");
            var numberLike = parseInt($(this).attr("data-like")) - 1;
            $(this).attr("data-like", numberLike);
            $(this).parent().find('.btn-synergy').attr("data-like", numberLike);

            $(this).addClass("d-sm-none");
            $(this).parent().find('.btn-synergy').removeClass("d-sm-none");
            $.ajax({
                url: dirURL + '/unsynergy/' + $(this).attr("data-id"),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $(".estadisticas").load(" .estadisticas");
                    $("#conLik" + id).empty();
                    $("#conLik" + id).html(numberLike);
                }
            });

            Swal.fire({
                position: 'top',
                icon: 'success',
                title: 'Thought eliminado de Synergies',
                showConfirmButton: false,
                timer: 1500
            })

        });
        $(".boton-thought").unbind('click').click(function () {
            $(".estadisticas").load(" .estadisticas");

        });
    });

}
/*Palabras censuradas*/
function check_val() {
    var bad_words = new Array(
            "gay de m",
            "travesti",
            "vox",
            "pp",
            "partido popular",
            "psoe",
            "partido socilista",
            "comunista",
            "fascista",
            "facha",
            "partido comuni",
            "partido socialcomuni",
            "marica",
            "maricón",
            "negro de mierda",
            "inmigrante sin pap",
            "puto moro",
            "puto inmigrante",
            "socialcomunista",
            "comunismo",
            "nazismo",
            "franquismo",
            "stalinismo",
            "tortillera",
            "muérete",
            "te maten");
    var check_text = document.getElementById("backendbundle_user_text").value;
    var error = 0;
    for (var i = 0; i < bad_words.length; i++)
    {
        var val = bad_words[i];
        if ((check_text.toLowerCase()).indexOf(val.toString()) > -1)
        {

            error = error + 1;
        }
    }

    if (error > 0)
    {
        $(".boton-thought").addClass("d-sm-none");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Se han detectado palabras que van en contra de la política de Frontier, te invitamos a revisar las políticas de uso de la plataforma:',
            footer: '<a href="">Míralos aquí</a>'
        })
    } else
    {
        $(".boton-thought").removeClass("d-sm-none");

    }
}
/*Contador de caracteres*/
function contarcaracteres() {

    var total = 250;

    setTimeout(function () {
        var valor = document.getElementById('backendbundle_user_text');
        var respuesta = document.getElementById('caracteres');
        var cantidad = valor.value.length;

        if (cantidad > total) {
            $(".boton-thought").addClass("disabled");

            document.getElementById('caracteres').innerHTML = (total - cantidad) + '/250';
            respuesta.style.color = "red";

        } else {
            $(".boton-thought").removeClass("disabled");

            document.getElementById('caracteres').innerHTML = cantidad + '/250';

            respuesta.style.color = "black";
        }
    }, 10);

}
/*Botón publicar thought*/
$(document).ready(function () {

    $(".contenidoBotonThought").unbind('click').click(function (event)
    {
        if ($(".containerPT").hasClass('expand'))
        {
            $(".containerPT").removeClass('expand').addClass('shrink');
            $('#iconThought').removeClass('expand');
        } else
        {
            if ($(".containerPT").hasClass('shrink'))
            {
                $(".containerPT").removeClass('shrink').addClass('expand');

            } else
            {
                $(".containerPT").addClass('expand');

            }
            $('#iconThought').addClass('expand');
        }

    });

});
/*Links en thoughts*/

var id = $(this).attr("data-id");
var idurl = "idurl" + id;

function replace_content()
{
    var exp_match = /(\b(https?|):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    var element_content = content.replace(exp_match, "<a href='$1'>$1</a>");
    var new_exp_match = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    var new_content = element_content.replace(new_exp_match, '$1<a target="_blank" href="http://$2">$2</a>');
    return new_content;
}
var content = $('#content').html();
$('#content').html(replace_content(content));

