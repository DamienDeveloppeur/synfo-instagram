function postComment(idPublication) {
    let data = {
        idPublication:idPublication,
        contenue : $("#commentPublication").val()
    }
    $.ajax({
        type: "POST",
        url: '/postComment',
        async: true,
        data:data,
        cache: false
        }).done(function (result) {
            console.log(result)
            getComment(idPublication);
        })
        .fail(function (result) {

        })

}

function getComment(idPubli) {
    let data = {
        idPubli : idPubli,
    }
    $.ajax({
        type: "POST",
        url: '/getComment',
        async: true,
        data:data,
        cache: false
        }).done(function (result) {
            console.log(result)
        })
        .fail(function (result) {

        })

}

function addLikeToPubli(publication){
    $.ajax({
        type: "POST",
        url: '/postLike',
        async: true,
        data:{'publication' : publication},
        cache: false
        }).done(function (result) {
            console.log(result.message)
            if(result.message === "add") {
                $("#heart"+publication).addClass("fas");
                $("#heart"+publication).removeClass("far");
                $("#nbrLike"+publication).text(parseInt($("#nbrLike"+publication).text())+1)    
            } else {
                $("#heart"+publication).addClass("far");
                $("#heart"+publication).removeClass("fas");
                $("#nbrLike"+publication).text(parseInt($("#nbrLike"+publication).text())-1)  
            }
        })
        .fail(function (result) {

        })
}