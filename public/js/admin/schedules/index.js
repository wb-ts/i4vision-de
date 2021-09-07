$(document).ready(function () {
	$('.btn-schedule-delete').click(function() {
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
                    $("#schedule_delete_form").attr("action", $("#schedule_delete_form").data('current_url') + "/" + selectedId);
                    $("#schedule_delete_form").submit();
                }
            }
        });
    });
    
    $('.btn-schedule-clone').click(function() {
        var selectSchedule = $(this).data("schedule");
        console.log(selectSchedule);
        var data = $("#schedule_clone_form").serialize();
        data +="&name="+selectSchedule['name']+"_copy&description="+selectSchedule['description']+"&layout="+selectSchedule['layout'];
        
        $.ajax({
            type: 'POST',
            url: $("#schedule_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="schedules";
            }
        })
    });
})