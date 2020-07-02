$(document).ready(function(){
    $('#login').on( 'click', function () {
        // var data = $(this).data();
        var login = $('#singin-email').val();
        var password = $('#singin-password').val();
        $.ajax({
            url: $('#loginform').data('url'),
            type: "POST",
            dataType: "json",
            data: {
                "login": login,
                "pass": password
            },
            async: true,
            success: function (data)
            {
                // console.log(data['status']);
                if (data['status'] === 'in'){
                    console.log('done');
                }else {
                    console.log('not done');
                }
            }
        });
    } );
});