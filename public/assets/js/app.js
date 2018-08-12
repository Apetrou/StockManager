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
        ],
        paginate: false,
    } );

    $('#customerTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
        ],
        paginate: false,
    } );

    $('#customerPurchaseTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
        ],
        paginate: false,
    } );

    // $('#customerPurchaseTable').DataTable( {
    //     dom: 'Bfrtip',
    //     buttons: [
    //         { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
    //     ],
    //     paginate: false,
    //     oLanguage:
    //         {
    //             "sZeroRecords": "No products added to order.",
    //         }
    // } );

    // $('#customerPurchaseBasket').DataTable( {
    //     dom: 'Bfrtip',
    //     buttons: [
    //         { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
    //     ],
    //     paginate: false,
    //     oLanguage:
    //     {
    //         "sZeroRecords": "No products added to order.",
    //     },
    //     bfilter: false,
    // } );


    $('[data-toggle="popover"]').popover();

    $('body').on('keypress','#search',function(){
        // $('#search').siblings('span.input-group-btn').find('i.fa-refresh.fa-spin').removeClass('fa-refresh fa-spin').addClass('fa-search');
        // $(this).next().children().find('fa-search').removeClass('fa-search').addClass('fa-refresh fa-spin');
        $(this).siblings('span.input-group-btn').find('i.fa-search').removeClass('fa-search').addClass('fa-refresh fa-spin');
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
                    response( data['customers'] );

                }
            });
        },

        minLength: 3,
        select: function( event, ui ) {
            // console.log(ui.item.label);
            event.preventDefault();
            $("#search").val(ui.item.label);

            if(ui.item.value == "No customer found, click to create new...") {
                location.href = '/customer/new';
            } else {
                location.href = '/customer/' + ui.item.value;

            }
        },

    });

    // ORDER PAGE

    $('body').on('click','.btn-number-plus',function() {
        var $quantityField = $(this).parent().prev();
        var minusButton = $(this).parent().prev().prev().children();

        $quantityField.val(parseInt($quantityField.val()) + 1);

        if($quantityField.val() == $quantityField.prop('max')) {
            $(this).prop('disabled','disabled');
        } else {
            $(this).prop('disabled',false);
        }

        if($quantityField.val() > 0) {
            minusButton.prop('disabled',false);
        } else {
            minusButton.prop('disabled','disabled');
        }

        var $item = {"id":$quantityField.data("id"), "name":$quantityField.data("name"),
            "artifactNumber":$quantityField.data('artifact-number'), "cataloguePage":$quantityField.data('catalogue-page'),
            "cost":$quantityField.data('cost')};

        addOrderItemToBasket($item);
    });

    $('body').on('click','.btn-number-minus',function() {
        var $quantityField = $(this).parent().next();
        var plusButton = $(this).parent().next().next().children();

        $quantityField.val(parseInt($quantityField.val()) - 1);

        if($quantityField.val() == 0) {
            $(this).prop('disabled','disabled');
        } else {
            $(this).prop('disabled',false);
        }

        if($quantityField.val() < $quantityField.prop('max')) {
            plusButton.prop('disabled',false);
        }
    });

    $('body').on('click','#confirmOrder',function (e) {
        e.preventDefault();
        var orders = [];
        $('#order-basket tr.basketItem').each(function () {
            var order = {"id":$(this).data('id'), "name" :$(this).find('.basket-name').html(), "artifactNumber": $(this).find('.basket-artifact-number').html(), "quantity":
                $(this).find('.basket-quantity').html(), "cost": $(this).find('.basket-cost').html()};
            orders.push(order);
        });

        if(orders.length > 0) {
            $('#confirmOrderModal').modal('show');
            $.each(orders,function () {
                var row = '<tr data-id="'+$(this)[0].id+'"><td>'+$(this)[0].name+'</td><td>'+$(this)[0].artifactNumber+'</td><td>'+$(this)[0].quantity+'</td><td>'+$(this)[0].cost+'</td></tr>';
                $('#confirm-order-basket').append(row);
            });
        } else {
            alert('No orders in basket.');
        }
    });

    $('body').on('click','#resetOrder',function(){
        // $('#order-basket tr.basketItem').empty();
        // $('.input-number').val(0);
        // $('.btn-number-minus').prop('disabled','disabled');
        // $('')
        window.location.reload();
    });

    $('body').on('click','#sendOrder',function () {

    });

    $('#confirmOrderModal').on('hidden.bs.modal', function () {
        $('#confirm-order-basket').empty();
    })
});

function addOrderItemToBasket($item) {
    var existing = false;
    $('#order-basket tr.basketItem').each(function () {
        if($(this).data('id') == $item.id) {
            existing = true;
            var currentQuantity = $(this).find('.basket-quantity').html();
            var newQuantity = parseInt(currentQuantity) + 1
            $(this).find('.basket-quantity').html(newQuantity);

            var currentPrice = $(this).find('.basket-cost').html();
            var newPrice = parseFloat(currentPrice) * newQuantity;
            $(this).find('.basket-cost').html(newPrice);
        }
    });

    if(!existing) {
        var row = '<tr class="basketItem" data-id="'+$item.id+'"><td></td><td class="basket-name">'+$item.name+'</td><td class="basket-artifact-number">'+$item.artifactNumber+'</td><td class="basket-quantity">1</td><td class="basket-cost">'+$item.cost+'</td></tr>';
        $('#order-basket').append(row);
    }
}

function removeOrderItemFromBasket($item) {

}
