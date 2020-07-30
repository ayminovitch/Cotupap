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