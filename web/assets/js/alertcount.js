$(document).ready(function () {
    if ($(".notificaciones").text() == 0) {
        $(".notificaciones").addClass("d-sm-none");
    } else {
        $(".notificaciones").removeClass("d-sm-none");
    }
    if ($(".notificacionesWhisper").text() == 0) {
        $(".notificacionesWhisper").addClass("d-sm-none");
    } else {
        $(".notificacionesWhisper").removeClass("d-sm-none");
    }
    
    
    alerts();

    setInterval(function () {
        alerts();

    }, 5000);

});

function alerts() {
    $.ajax({
        url: dirURL + '/alerts/count',
        type: 'GET',
        success: function (response) {
            console.log(response);
            if(response < 100){
                $(".notificaciones").html(response);
            }else{
                $(".notificaciones").html(+99);
            }
            if (response == 0) {
                $(".notificaciones").addClass("d-sm-none");
            } else {
                $(".notificaciones").removeClass("d-sm-none");
            }

        }
    });
    $.ajax({
        url: dirURL + '/whisper/alerts/count',
        type: 'GET',
        success: function (response) {
            console.log(response);
            if(response < 100){
                $(".notificacionesWhisper").html(response);
            }else{
                $(".notificacionesWhisper").html(+99);
            }
            if (response == 0) {
                $(".notificacionesWhisper").addClass("d-sm-none");
            } else {
                $(".notificacionesWhisper").removeClass("d-sm-none");
            }

        }
    });
}