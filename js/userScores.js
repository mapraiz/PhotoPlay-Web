$(document).ready(function(){
    $(".edit-score").on("click",function(event){
        const parent=event.target.parentElement;
        var score=parent.children[0].innerText;
        console.log(score);
        var fecha=parent.children[1].innerText;
        console.log(fecha);
        $("#editContainer").show();
        document.getElementById("score-edit").value=score;

    })
})