function postComment(idPublication) {
    let data = {
        idPublication:idPublication,
        contenue : $("#commentPublication"+idPublication).val()
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
// récupére les commentaires d'une publication
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
        }).done(function (r) {
            console.log(r)
            console.log(r.onePublication)
            $("#image_publication_modal").attr("src", r.pathFiles+"/"+r.onePublication[0].user_id+"/"+r.onePublication[0].id+"/"+r.onePublication[0].image+"")

            // inject top of the div
            $("#modal_pseudo").html(r.onePublication[0].pseudo)
            if(r.onePublication[0].avatar == "photo_profil.jpg") {
                let avatarPath = "avatar/defaut/photo_profil.jpg";
            } else {
                let avatarPath = "";
            }
            $("#modal_avatar").attr("src", "avatar/defaut/photo_profil.jpg")

            // inject conversation with
            let conversation ="";

            for (let i in r.comment) {
                console.log();
                conversation += r.comment[i].pseudo + " : " + r.comment[i].contenue
            }
            $("#modal_middle").html(conversation)
        })
        .fail(function (r) {

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
