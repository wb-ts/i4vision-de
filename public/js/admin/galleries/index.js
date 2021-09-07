$(document).ready(function() {
	$('.btn-gallery-delete').click(function() {
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
                    $("#gallery_delete_form").attr("action", $("#gallery_delete_form").data('current_url') + "/" + selectedId);
                    $("#gallery_delete_form").submit();
                }
            }
        });
    });
    $('.btn-gallery-clone').click(function() {

        var data = $("#gallery_clone_form").serialize();
        var temp = $(this).parent().parent().siblings(),temp_datas  = {"name":"","google_link":"","description":""};
        for(var i =1 ;i<temp.length;i++){
            temp_datas['name'] = temp[1].innerText;
            temp_datas['google_link'] = temp[2].innerText;
            temp_datas['description'] = temp[3].innerText;
            // temp_datas.push(temp_keys[i] : temp[i].innerText);
        }
        data +="&name="+temp_datas['name']+"_copy&google_link="+temp_datas['google_link']+"&description="+temp_datas['description'];
 
        
        //console.log(temp_datas);
        $.ajax({
            type: 'POST',
            url: $("#gallery_clone_form").attr("action"),
            dataType: 'json',
            data: data,
            success: function(data) {
                location.href="galleries";
            }
        })
    });
    
})