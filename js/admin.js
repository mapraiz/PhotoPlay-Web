
$(document).ready(function(){


    




    $(".deleteButton").on("click", function(event){
        var username=
        console.log("hello");
        swal({
            title:"Estas seguro?",
            text:"No podras revertir el cambio",
            icon:"warning",
            buttons:{
                cancel:"No",
                confirm:{
                    text:"Si",
                    value:"confirm"
                }

            }   
        }).then((value)=>{
            if(value=="confirm"){
                $.ajax({
                    url: "http://127.0.0.1/PhotoPlay-Web/servicios.php",
                    type: "POST",
                    data: { function: "deleteScore", username:username, newUsername:newUsername},
                    success: function(data){
                        
                    }
                });
            }
        });
    })
})