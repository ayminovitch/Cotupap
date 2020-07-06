(function($) {
  'use strict';
  $(function() {
    $('#order-listing').DataTable({
      "fnDrawCallback": function(oSettings) {
        if ($('#example tr').length < 11) {
          $('.dataTables_paginate').hide();
        }
      },
      "processing": true,
      "serverSide": true,
      "ajax": {
        // "url": $('#example').data('url'),
        "type": "POST"
      },
      "columns": [
        { "data": "tarticle" },
        { "data": null, "bSortable": false, "render": function(data, type, full) { return '<img src="https://via.placeholder.com/150">'; }},
        { "data": "tdescription" },
        { "data": "tunite" },
        { "data": "tcateg" },
        { "data": "tsouscateg" },
        { "data": "tmarque" },
        { "data": "prix",  render: $.fn.dataTable.render.number( ',', '.', 3, '', ' TND' ) },
        { "data": null, "bSortable": false, "render": function(data, type, full) { return '<button class="btn btn-info btn-sm Buy" id="Buy" href="javascript:void(0)" ><i class="icon-basket mx-0"></i>' + ' Ajouter' + '</button>';} }
      ]
    });
    var table = $('#order-listing').DataTable();
    $('#order-listing tbody').on( 'click', 'button', function () {
      var data = table.row( $(this).parents('tr') ).data();
      $.ajax({
        url: $('#order-listing').data('url'),
        type: "POST",
        dataType: "json",
        data: {
          "reference": data['tarticle'],
          "name": data['tdescription'],
          "prix": data['prix'],
          "qte": 1,
        },
        async: true,
        success: function (data)
        {
          if (data['status'] === 'Done'){
            console.log('done');
          }else {
            $('#panier-reload').html(data);
          }
        }
      });
    } );
  } );
})(jQuery);

