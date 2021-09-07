$(document).ready(function(){
    var currnetAction = $("#user_form").data("current-url");

    $("#btn_show_user_modal").click(function () {
        $('.is-hide').show();
        $('.is-disabled').prop('disabled', false);
        $("#user_form").attr('action', currnetAction + '/store_user_of_client');
    })

    $("#btn_user_save").click(function() {

        var usersOfClientTabIsActive = 0;
        if ($("#users_of_client_tab").hasClass('active')) {
            usersOfClientTabIsActive = 1;
        }

        var formAction = $('#user_form').attr('action');
        $('#user_form').attr('action', formAction + '/' + usersOfClientTabIsActive);
        // console.log(formAction + '/' + usersOfClientTabIsActive);
        $('#user_form').submit();
    });

    $(".btn-user-edit").click(function () {
        $('.is-hide').hide();
        $('.is-disabled').prop('disabled', true);

        $.ajax({
            url: currnetAction + '/get_user/' + $(this).data('id'),
            method: 'GET',
            dataType: 'json',
            success: function(data, textStatus, jqXHR) {
                var user = data.user;
                $("#first_name").val(user.first_name);
                $("#last_name").val(user.last_name);
                $("#username").val(user.username);
                $("#email").val(user.email);
                $("#phone").val(user.phone);
                $("#gender").val(user.gender);
                $("#user_status").val(user.status);

                $("#user_form").attr('action', currnetAction + "/update_user_of_client/" + user.id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
        });
    });


    $('.btn-user-delete').click(function() {
        var selectedId = $(this).data("id");
        bootbox.confirm({
            message: "Are you sure you want to delete it?t?",
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
                    $("#user_delete_form").attr("action", currnetAction + "/" + selectedId);
                    $("#user_delete_form").submit();
                }
            }
        });
    });
});