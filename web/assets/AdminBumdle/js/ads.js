$(document).on("click", "#ads-submitd", function(e){
    e.preventDefault();
    var form = $("#ads-form")[0];
    $.ajax({
        url: $('#ads-form').data('url'),
        type: 'POST',
        contentType:false,
        processData:false,
        cache:false,
        dataType: 'json',
        data: new FormData(form),
        success:function(data){

            if(data.uploaded === true){
                location.reload();
            }
        }
    });
});

function removeAds(adsId, url) {
    console.log(adsId);
    $.ajax({
        type: "post",
        url: url,
        data: {
            'id': adsId,
        },
        success: function(response) {
            location.reload();
        },
    });
}