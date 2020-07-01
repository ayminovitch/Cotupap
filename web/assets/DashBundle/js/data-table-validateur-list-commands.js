(function($) {
  'use strict';
  $(function() {
    $('#order-listing').DataTable({
      // "fnDrawCallback": function(oSettings) {
      //   if ($('#example tr').length < 11) {
      //     $('.dataTables_paginate').hide();
      //   }
      // },
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": $('#order-listing').data('url'),
        "type": "POST"
      },
      "columns": [
        { "data": "status" },
        { "data": "dcr" },
        { "data": "dcr" },
        { "data": "dcr" },
        // { "data": "tadresse" },
        // { "data": "tphone" },
        // { "data": "tfax" },
        // { "data": "tmatFiscale" },
      ]
    });
  } );
})(jQuery);

