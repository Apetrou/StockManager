// REQUIRE ANY CSS THROUGH THE JS FILE
require('../css/global.scss');
const $ = require('jquery');
require('bootstrap');
require('webpack-jquery-ui');
require('webpack-jquery-ui/css');
// require('typeahead.js');
require('@fortawesome/fontawesome-free/js/all.js');
require('datatables.net-dt');
require('datatables.net-bs4/js/dataTables.bootstrap4')

$(document).ready(function() {

    /*
        CREATE ALL DATATABLES
     */
    $('#productTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
        ]
    } );


    $('[data-toggle="popover"]').popover();

    $('body').on('keypress','#search',function(){
        $('#search').siblings('span.input-group-btn').find('i.fa-refresh.fa-spin').removeClass('fa-refresh fa-spin').addClass('fa-search');
    });

    $('body').on('click','#search',function(){
        $(this).val("");
    });

    $("#search").autocomplete({
        source: function(request, response) {
            $.ajax({
                // type: "POST",
                url: $("#search").attr('href'),
                data: {
                    'query' : $("#search").val()
                },
                dataType: "json",
                success: function( data ) {
                    console.log(data['customers']);
                    response( data['customers'] );
                }
            });
        },

        minLength: 3,
        select: function( event, ui ) {
            $("#search").val("");
            if(ui.item.value == "No customer found, click to create new...") {
                location.href = '/customer/new';
            } else {
                location.href = '/customer/' + ui.item.value;
            }
        },

    });
});

