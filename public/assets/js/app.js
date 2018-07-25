// REQUIRE ANY CSS THROUGH THE JS FILE
// require('../css/global.scss');
const $ = require('jquery');
require('bootstrap');
require('typeahead.js');
require('@fortawesome/fontawesome-free/js/all.js');

$(document).ready(function() {

    $('[data-toggle="popover"]').popover();

    $('body').on('keypress','#search',function(){
        $('#search').siblings('span.input-group-btn').find('i.fa-refresh.fa-spin').removeClass('fa-refresh fa-spin').addClass('fa-search');
    });

    $('body').on('click','#search',function(){
        $(this).val("");
    });


    $("#search").typeahead({
        // source: function( request, response ) {
        //     return $.ajax({
        //         url: "{{ path('ajax_search') }}",
        //         data: {
        //             'query' : $("#search").val()
        //         },
        //         dataType: "json",
        //         success: function( data ) {
        //             console.log(data['customers']);
        //             response( data['customers'] );
        //         }
        //     });
        // },
        source: {
            data: ["Alkis","Palkis"]
        },
        // minLength: 3,
        // select: function( event, ui ) {
        //     $("#search").val("");
        //     if(ui.item.value == "No customer found, click to create new...") {
        //         location.href = '/customer/new';
        //     } else {
        //         location.href = '/customer/' + ui.item.value;
        //     }
        // },

    });
});

