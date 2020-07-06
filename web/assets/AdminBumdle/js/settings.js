(function($) {
    'use strict';
    $('#save').on('click', function () {
            var data = {
                //LES MODULES
                'newsletter': $('#newsletter').bootstrapSwitch('state'),
                'search': $('#search').bootstrapSwitch('state'),
                'modal': $('#modal').bootstrapSwitch('state'),
                'maintenance': $('#maintenance').bootstrapSwitch('state'),
                //LES RÉSEAUX SOCIAUX
                'facebook': $('#facebook').val(),
                'instagram': $('#instagram').val(),
                'twitter': $('#twitter').val(),
                'pinterest': $('#pinterest').val(),
                //LES AUTRES PARAMS
            };
            $.ajax({
                url: $('#parameters-list').data('url'),
                type: "POST",
                dataType: "json",
                data: {
                    "data": data
                },
                async: true,
                success: function (data)
                {
                    console.log(data)
                    if (data['status'] === 'success'){
                        window.location.reload();
                    }
                }
            });
    })
})(jQuery);

