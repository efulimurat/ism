//Ajax requestleri takip eder, unauthorized durumunda refresh atar
$(document).ajaxComplete(function (event, request, settings) {
    //console.log(request.responseText);
    var response = jQuery.parseJSON(request.responseText);
    initMessage.check(response);
    if (request.status == 401) {
        window.location.reload();
    }
});

//Datatables debug kapatır
$.fn.dataTableExt.sErrMode = 'none';


$(document).ready(function () {


    //Logo Effect

    $("#menu_toggle").click(function () {
        var logoText;

        if ($(".logo").hasClass("opened")) {
            logoText = "ism";
            $(".logo").removeClass("opened");
        }
        else {
            logoText = "issue management";
            $(".logo").addClass("opened");
        }
        $(".logo").text(logoText);
    })

    //Notify mesajları
    if (typeof pnotify != "undefined") {
        new PNotify({
            title: pnotify.title,
            text: pnotify.text,
            type: pnotify.type
        });
    }

    $('#form_tags').tagsInput({
        width: 'auto'
    });
})