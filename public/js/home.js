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