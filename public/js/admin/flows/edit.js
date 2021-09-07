$(document).ready(function(){
    var flow_edit_url = $("#flow_entry_form").attr("action");



    $("#flow_entriable_type").change(function () {
        var flow_entriable_type = $(this).val();



        $.ajax({

            url: flow_edit_url + '/get_flow_entriable_names',
            method: 'GET',
            dataType: 'json',
            data: {'flow_entriable_type': flow_entriable_type},
            success: function(data, textStatus, jqXHR) {

                var optionHtml = '<option value="">Select Name</option>';

                if (flow_entriable_type == 'App\\Schedule') {
                    for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        optionHtml += '<option value="' + data.flow_entriable_names[i].name + '">' + data.flow_entriable_names[i].name + '</option>';
                    }
                } else {

                    for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        optionHtml += '<option value="' + data.flow_entriable_names[i].id + '">' + data.flow_entriable_names[i].name + '</option>';
                    }
                }

                $("#flow_entriable_id").html(optionHtml);

            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
    });

    $('.datepicker').datepicker({
        format: "dd.mm.yyyy",
        todayHighlight: true
    });

    $('.multidatepicker').datepicker({
        format: "dd.mm.yyyy",
        todayHighlight: true,
        multidate: true
    });

    $("#btn_flow_entry_save").click(function() {
        var formData = $("#flow_entry_form").serializeArray();

        var flow_tab = 0;
        if ($("#flow_tab").hasClass('active')) {
            flow_tab = 1;
        }
        var currentAction = $('#flow_entry_form').attr('action');
        $('#flow_entry_form').attr('action', currentAction + '/' + flow_tab);
        // console.log($('#flow_entry_form').attr('action'));
        $('#flow_entry_form').submit();
        // $.ajax({

        //     url: $("#flow_entry_form").attr("action"),
        //     method: 'POST',
        //     dataType: 'json',
        //     data: formData,
        //     success: function(data, textStatus, jqXHR) {
        //         window.location.reload();

        //         // var optionHtml = '<option>Select Name</option>';

        //         // for (var i = 0; i < data.flow_entriable_names.length; i++) {
        //         //     optionHtml += '<option value="' + data.flow_entriable_names[i].id + '">' + data.flow_entriable_names[i].name + '</option>';
        //         // }

        //         // $("#flow_entriable_id").html(optionHtml);

        //     },
        //     error: function(jqXHR, textStatus, errorThrown) {
        //     }
        // });
    });

    $(".btn-flow-entry-edit").click(function () {

        $.ajax({

            url: flow_edit_url + '/get_flow_entry/' + $(this).data('id'),
            method: 'GET',
            dataType: 'json',
            success: function(data, textStatus, jqXHR) {

                var optionHtml = '<option value="">Select Name</option>';

                if (data.flow_entry.flow_entriable_type == 'App\\Device') {
                    for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        optionHtml += '<option value="' + data.flow_entriable_names[i].id + '">' + data.flow_entriable_names[i].device_code + '</option>';
                    }
                } else if (data.flow_entry.flow_entriable_type == 'App\\Schedule')
				{
					for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        optionHtml += '<option value="' + data.flow_entriable_names[i].name + '">' + data.flow_entriable_names[i].name + '</option>';
                    }
				} else {

                    for (var i = 0; i < data.flow_entriable_names.length; i++) {
                        optionHtml += '<option value="' + data.flow_entriable_names[i].id + '">' + data.flow_entriable_names[i].name + '</option>';
                    }
                }

                $("#flow_entriable_id").html(optionHtml);



                $("#sequence").val(data.flow_entry.sequence);
                $("#flow_entriable_type").val(data.flow_entry.flow_entriable_type);
                $("#flow_entriable_id").val(data.flow_entry.flow_entriable_id);
                $("#time").val(data.flow_entry.time);
                $("#run_from").val(data.flow_entry.run_from);
                $("#run_to").val(data.flow_entry.run_to);
                $("#dates").val(data.flow_entry.dates);

                $("#flow_entry_form").attr('action', flow_edit_url + "/flow_entry_update/" + data.flow_entry.id);

            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
    });

    $("#btn_show_flow_entry_modal").click(function () {
        $("#flow_entry_form").attr('action', flow_edit_url + "/flow_entry_store")
    });

    $('.btn-flow-entry-delete').click(function() {
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
                    $("#flow_entry_delete_form").attr("action", flow_edit_url + "/" + selectedId);
                    $("#flow_entry_delete_form").submit();
                }
            }
        });
    });
    $('.btn-flow-entry-clone').click(function() {
        var selectFlow = $(this).data("flow_entry");
        console.log(selectFlow);
        var data = $("#flow_entry_clone_form").serialize();
        for (const [key, value] of Object.entries(selectFlow)) {
            if(value === null) selectFlow[key] = '';
        }
         data +="&dates="+selectFlow['dates'].replaceAll('null', '-')+"&time="+selectFlow['time']+"&run_from="+selectFlow['run_from']+"&run_to="+selectFlow['run_to']+"&sequence="+(selectFlow['sequence']+1)+"&flow_id="+selectFlow['flow_id']+"&flow_entriable_id="+selectFlow['flow_entriable_id']+"&flow_entriable_type="+selectFlow['flow_entriable_type'];
        // alert(data);
        $.ajax({
            type: 'POST',
            url: $("#flow_entry_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="flows";
            }
        })
    });
    $('#btn_flow_entry_move').click(function() {
        move_flow_id = $('#move_flow_id').val();
        var data = $("#flow_entry_move_form").serialize();

        console.log(data);
        $.ajax({
            type: 'POST',
            url: $(".btn-flow-entry-move").data('url'),
            dataType: 'json',
            data: data ,
            success: function(data) {
                location.href="is_flow_active";
            }
        })
    });
});