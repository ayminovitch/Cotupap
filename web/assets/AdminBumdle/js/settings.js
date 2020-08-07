(function($) {
    'use strict';
    $('#save').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var form = new FormData(document.getElementById("myform"));
            var checkbox = $("#myForm").find("input[type=checkbox]");

            $.each(checkbox, function(key, val) {
                form.append($(this).attr('name'), this.is(':checked'))
            });
        $.ajax({
                url: $('#parameters-list').data('url'),
                data: form,
                type: "POST",
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (data)
                {
                    if (data['status'] === 'success'){
                        window.location.reload();
                    }
                }
            });
    })
})(jQuery);

