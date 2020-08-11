$('.command-detail').on('click', function(e) {
    console.log('clicked')
    e.preventDefault();
    var id = $(this).data('id');
    var url = $('#order-listing').data('url');
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "id": id,
            "type" : 'singleCommand'
        },
        async: true,
        success: function (data)
        {
            $('.command-information').html(data);
            $('#commandModal').modal('show');
            // console.log(data)
        }
    });
});

function updateQts(e){
    console.log('clicked')
    var arr = [];
    $('.articles-table *').filter(':input').each(function(){
        arr.push({
            id: $(this).data('id'),
            qte: $(this).val()
        });
    });
    var url = $('#order-listing').data('url');
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "articleCollection": arr,
            "type" : 'updateArticles',
            "commande" : $('.articles-table').data('unique')
        },
        async: true,
        success: function (data)
        {
            $('.articles-table').html(data);
        }
    });
}

function validateurConfirm(e){
    alert('not yet implemented')
}