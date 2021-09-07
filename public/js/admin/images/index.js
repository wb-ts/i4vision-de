$(document).ready(function() {
	$('.btn-image-delete').click(function() {
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
                    $("#image_delete_form").attr("action", $('#image_delete_form').data('current_url') + "/" + selectedId);
                    $("#image_delete_form").submit();
                }
            }
        });
    });
    
});