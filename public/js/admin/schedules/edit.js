$(document).ready(function(){
    var schedule_edit_url = $("#schedule_entry_form").attr("action");


    $('.datepicker').datepicker({
        format: "dd.mm.yyyy",
        todayHighlight: true
    });

    $('.multidatepicker').datepicker({
        format: "dd.mm.yyyy",
        todayHighlight: true,
        multidate: true
    });

    $("#btn_schedule_entry_save").click(function() {
        var formData = $("#schedule_entry_form").serializeArray();

        var schedule_tab = 0;
        if ($("#schedule_tab").hasClass('active')) {
            schedule_tab = 1;
        }
        var currentAction = $('#schedule_entry_form').attr('action');
        $('#schedule_entry_form').attr('action', currentAction + '/' + schedule_tab);
        // console.log($('#schedule_entry_form').attr('action'));
        $('#schedule_entry_form').submit();
        // $.ajax({

        //     url: $("#schedule_entry_form").attr("action"),
        //     method: 'POST',
        //     dataType: 'json',
        //     data: formData,
        //     success: function(data, textStatus, jqXHR) {
        //         window.location.reload();

        //         // var optionHtml = '<option>Select Name</option>';

        //         // for (var i = 0; i < data.schedule_entriable_names.length; i++) {
        //         //     optionHtml += '<option value="' + data.schedule_entriable_names[i].id + '">' + data.schedule_entriable_names[i].name + '</option>';
        //         // }

        //         // $("#schedule_entriable_id").html(optionHtml);

        //     },
        //     error: function(jqXHR, textStatus, errorThrown) {
        //     }
        // });
    });

    $(".btn-schedule-entry-edit").click(function () {

        $.ajax({
            url: schedule_edit_url + '/get_schedule_entry/' + $(this).data('id'),
            method: 'GET',
            dataType: 'json',
            success: function(data, textStatus, jqXHR) {
                $("#date").val(data.schedule_entry.date);
                $("#time").val(data.schedule_entry.time);

                console.log(data.schedule_entry.schedule_entriable_id);
                var optionHtml = "<option>Select Type</option>";
                if( data.schedule_entry.schedule_entriable_id == "kids" ) {
                    optionHtml +="<option value='kids' selected>Kids</option>";
                    optionHtml +="<option value='adults'>Adults</option>";
                    optionHtml +="<option value='general'>General</option>";
                }
                if( data.schedule_entry.schedule_entriable_id == "adults") {
                    optionHtml +="<option value='kids'>Kids</option>";
                    optionHtml +="<option value='adults' selected>Adults</option>";
                    optionHtml +="<option value='general'>General</option>";
                }
                if( data.schedule_entry.schedule_entriable_id == "general") {
                    optionHtml +="<option value='kids'>Kids</option>";
                    optionHtml +="<option value='adults'>Adults</option>";
                    optionHtml +="<option value='general' Selected>general</option>";
                }
                console.log(optionHtml);
                $("#schedule_entriable_id").html(optionHtml);
                $("#line1").val(data.schedule_entry.line1);
                $("#line2").val(data.schedule_entry.line2);
                $("#line3").val(data.schedule_entry.line3);
                $("#time").val(data.schedule_entry.time);
                $("#run_from").val(data.flow_entry.run_from);
                $("#run_to").val(data.flow_entry.run_to);
                $("#dates").val(data.flow_entry.dates);

                $("#image_id").val(data.schedule_entry.image_id);


                $("#schedule_entry_form").attr('action', schedule_edit_url + "/schedule_entry_update/" + data.schedule_entry.id);

            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
    });

    $("#btn_show_schedule_entry_modal").click(function () {
        $("#schedule_entry_form").attr('action', schedule_edit_url + "/schedule_entry_store")
    });

    $('.btn-schedule-entry-delete').click(function() {
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
                    $("#schedule_entry_delete_form").attr("action", schedule_edit_url + "/" + selectedId);
                    $("#schedule_entry_delete_form").submit();
                }
            }
        });
    });
    $('.btn-schedule-entry-clone').click(function() {
        var selectSchedule = $(this).data("schedule_entry");
        console.log(selectSchedule);
        var data = $("#schedule_entry_clone_form").serialize();
        data +="&date="+selectSchedule['date']+"&time="+selectSchedule['time']+"&line1="+selectSchedule['line1']+"&line2="+selectSchedule['line2']+"&line3="+selectSchedule['line3']+"&image_id="+selectSchedule['image_id']+"&schedule_entriable_id="+selectSchedule['schedule_entriable_id'];

        $.ajax({
            type: 'POST',
            url: $("#schedule_entry_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="is_schedule_active";
            }
        })
    });
    $('#btn_schedule_entry_move').click(function() {
        move_schedule_id = $('#move_schedule_id').val();
        selectSchedule = $(".btn-schedule-entry-move").data('schedule_entry');
        var data = $("#schedule_entry_move_form").serialize();

        console.log(data);
        $.ajax({
            type: 'POST',
            url: $(".btn-schedule-entry-move").data('url'),
            dataType: 'json',
            data: data ,
            success: function(data) {
                location.href="is_schedule_active";
            }
        })
    });
});