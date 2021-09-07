$(document).ready(function() {
    
    device_edit_url = $("#device_edit").attr("action");
    //alert(device_edit_url);
	$('.btn-device-delete').click(function() {
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
                    $("#device_delete_form").attr("action", $("#device_delete_form").data('current_url') + "/" + selectedId);
                    $("#device_delete_form").submit();
                }
            }
        });
    });
    $("#show_at_frontend").change(function () {
        var show_at_frontend = $(this).val();
        // alert(device_edit_url);

        $.ajax({
            
            url: device_edit_url + '/get_frontend_refers',
            method: 'GET',
            dataType: 'json',
            data: {'show_at_frontend': show_at_frontend},
            success: function(data, textStatus, jqXHR) {
                if(show_at_frontend == "Free"){
                    optionHtml = '<input name="frontend_refer" class="form-control" placeholder="Input URL..."></input>';
                }
                else {
                    var optionHtml = '<select name="frontend_refer" class="form-control" ><option value="">Select Name</option>';

                    if (show_at_frontend == 'App\\Schedule' || show_at_frontend == 'App\\Flow') {
                        for (var i = 0; i < data.frontend_refers.length; i++) {
                            optionHtml += '<option value="' + data.frontend_refers[i].name + '">' + data.frontend_refers[i].name + '</option>';
                        }
                    } else {

                        for (var i = 0; i < data.frontend_refers.length; i++) {
                            optionHtml += '<option value="' + data.frontend_refers[i].name + '">' + data.frontend_refers[i].name + '</option>';
                        }
                    }
                    optionHtml+="</select>";
                }
                
                
                $("#frontend_refer").html(optionHtml);

            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
    });
    $("#enabled").change(function(){
        if ($(this).is(":checked")){
            $(this).attr("value",1);
        }
        else {
            $(this).attr("value",0);
        }
    });
    $("#force_restart_enabled").change(function(){
        if ($(this).is(":checked")){
            $(this).attr("value",1);
        }
        else {
            $(this).attr("value",0);
        }
    });
});