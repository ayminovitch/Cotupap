$(document).ready(function(e){
    // e.preventDefault();
    $('#login').on( 'click', function () {
        var client = $('#singin-client-login');
        $.ajax({
            url: $('#loginform').data('url'),
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                "codeClient": client.val(),
                "step": client.data('step')
            },
            async: true,
            success: function (data)
            {
                // console.log(data['status']);
                if (data['status'] == 'smerf'){
                    console.log(data['status']);
                    $('#msg-error').css("display", "block");
                } else if (data['status'] != 'in'){
                    $('#content-side').html(data['loginInput'])
                } else {
                    window.location.reload();
                }
            }
        });
    } );
});