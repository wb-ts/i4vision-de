$(document).ready(function () {
    $('#save_btn').click(function () {

        var data = $("#gallery_form").serialize();
        var urlsend = $("#gallery_form").attr("action");
		
        $(".spinner").show();
        $.ajax({
            url: urlsend,
            method: "POST",
            data: data,
            dataType: 'json',
            success: function (data) {
                var gallery = data.gallery;
                RetrieveGalleryLinks(gallery.id, gallery.google_link);
                window.location.replace("https://i4vision.de/admin/galleries");
            }
        })

    });
})