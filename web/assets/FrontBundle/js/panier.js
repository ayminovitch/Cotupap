$(document).ready(function(){
    $('.btn-carta').on( 'click', function () {
        var data = $(this).data();
        $.ajax({
            url: $('#products').data('url'),
            type: "POST",
            dataType: "json",
            data: {
                "reference": data['ref'],
                "name": data['desc'],
                "prix": data['prix'],
                "qte": 1,
            },
            async: true,
            success: function (data)
            {
                if (data['status'] === 'Done'){
                }else {
                    $('#panier-reload').html(data);
                }
            }
        });
    } );
});