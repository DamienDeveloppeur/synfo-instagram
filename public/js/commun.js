function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#file_upload')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function addPublication() {
    var formData = new FormData();
    formData.append('contenue', $("#contenue_publication").val());
    $('.con-input-file input[type="file"]').each(function(i, elt) { 
        formData.append('file'+i, $(elt).prop('files')[0]);
    
        // if ($(this).prop('files')[0] != undefined) {
        //     if ($(this).prop('files')[0].size > 4000000) {
        //         seizeControl("Image : " + $(this).prop('files')[0].name + " trop volumineuse, taille maximale : 4 Mo", 0)
        //         error_taille = true;
        //     }
        // }
    });
    
    $.ajax({
        type: "POST",
        url: 'publication',
        async: true,
        data:formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,
        dataType: "json",
        cache: false
        })
        .done(function (result) {
                console.log(result)
                $('#createPublication').modal('toggle');
        })
    
}

function openMenu(idDiv) {
    if($("#"+idDiv+"").hasClass("d-none")){
        $("#"+idDiv+"").removeClass("d-none")
    } else {
        $("#"+idDiv+"").addClass("d-none")
    }
}

function abonnement(idUser){
    $.ajax({
        type: "POST",
        url: '/post_abonnement',
        async: true,
        data:{'idUser' : idUser},
        cache: false
        }).done(function (result) {
            console.log(result)
            if(result.message === "ok") {
                $("#suggestion"+idUser).text("Abonné(e)");
                $("#suggestion"+idUser).removeClass("GoBlue");
                $("#suggestion"+idUser).prop("onclick", null).off("click");

            }
        })
        .fail(function (result) {

        })
}