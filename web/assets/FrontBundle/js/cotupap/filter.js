$(document).ready(function () {
    $(".custom-checkbox").click(function (event) {
        var searchIDs = $("#marque-filter input:checkbox:checked").map(function () {
            return $(this).val();
        }).get();
        var resultArray = [];
        for (i=0; i<searchIDs.length;i++){
            resultArray.push(searchIDs[i])
        }
        $.ajax({
            url: $('#articles-result').data('url'),
            type: "POST",
            dataType: "json",
            data: {
                "refs": resultArray,
            },
            async: true,
            success: function (data)
            {
                if (data === 'Done'){
                    window.location.reload();
                }
            }
        });
    });
});