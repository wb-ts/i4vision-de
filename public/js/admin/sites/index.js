$(document).ready(function() {
	$('.btn-site-delete').click(function() {
        var selectedId = $(this).data("id");
        bootbox.confirm({
            message: "Are you sure you want to delete it?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result === true) {
                    $("#site_delete_form").attr("action", $("#site_delete_form").data("current_url") + "/" + selectedId);
                    $("#site_delete_form").submit();
                }
            }
        });
    });
    $('.btn-site-clone').click(function() {
        var selectSite = $(this).data("sites");
        console.log(selectSite);
        var data = $("#site_clone_form").serialize();
        data +="&name="+selectSite['name']+"_copy&url="+selectSite['url'].replaceAll('&', '-')+"&description="+selectSite['description'];
    
        
        $.ajax({
            type: 'POST',
            url: $("#site_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="sites";
            }
        })
    });
});