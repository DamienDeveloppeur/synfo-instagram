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
            // inject top of the div
            $("#modal_pseudo").html(r.onePublication[0].pseudo)
            $("#modal_message_pseudo").html(r.onePublication[0].contenu)
            if(r.onePublication[0].avatar == "photo_profil.jpg") {
                var avatarPath = "avatar/defaut/photo_profil.jpg";
            } else {
                var avatarPath = "avatar/"+r.onePublication[0].id+"/"+r.onePublication[i].avatar+"";
            }
            $("#modal_avatar").attr("src", avatarPath)

            // inject conversation with
            let conversation ="";
            for (let i in r.comment) {
                if(r.comment[i].avatar == "photo_profil.jpg") {
                    var avatarPath = "avatar/defaut/photo_profil.jpg";
                } else {
                    var avatarPath = "avatar/"+r.comment[i].id+"/"+r.comment[i].avatar+"";
                }
                conversation += '<img src="'+avatarPath+'" class="rounded_photo_profil mr-2" id="modal_avatar" alt="photo_profil">'+ r.comment[i].pseudo + " " + r.comment[i].contenue
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

// menu déroulant
$('li.dropdown').hover(function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
  }, function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
  });