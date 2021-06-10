/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $(".nick-input").blur(function(){
        var usernick=this.value;
        $.ajax({
            url: dirURL+'/comprobarUsuario', 
            data:{usernick:usernick},
            type:'POST',
            success: function(respuesta){
                if(respuesta =="utilizado"){
                    $(".nick-input").css("border","1px solid red");
                }else{
                    $(".nick-input").css("border","1px solid green");
                }
            }
        });
    });
});
$(document).ready(function(){
    $(".mail-input").blur(function(){
        var maildir=this.value;
        $.ajax({
            url: dirURL+'/comprobarCorreo', 
            data:{maildir:maildir},
            type:'POST',
            success: function(respuesta){
                if(respuesta =="utilizado"){
                    $(".mail-input").css("border","1px solid red");
                }else{
                    $(".mail-input").css("border","1px solid green");
                }
            }
        });
    });
});
