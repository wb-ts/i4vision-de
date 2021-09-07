$(document).ready(function () {
	$('.btn-flow-delete').click(function() {
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
                    $("#flow_delete_form").attr("action", $("#flow_delete_form").data("current_url") + "/" + selectedId);
                    $("#flow_delete_form").submit();
                }
            }
        });
    });
    
    $('.btn-flow-clone').click(function() {
        var selectFlow = $(this).data("flows");
        console.log(selectFlow);
        var data = $("#flow_clone_form").serialize();
        data +="&name="+selectFlow['name']+"_copy&description="+selectFlow['description']+"&layout="+selectFlow['layout'];
        
        $.ajax({
            type: 'POST',
            url: $("#flow_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="";
            }
        })
    });
});