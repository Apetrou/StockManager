// REQUIRE ANY CSS THROUGH THE JS FILE
const $ = require('jquery');
require('bootstrap');
require('webpack-jquery-ui');
require('webpack-jquery-ui/css');
// require('typeahead.js');
require('@fortawesome/fontawesome-free/js/all.js');
require('datatables.net-dt');
require('datatables.net-bs4/js/dataTables.bootstrap4');
require('../css/global.scss');

$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();

    /*
        SET ALL THE QUANTITY FIELDS FOR ORDER TO 0
     */
    $('.input-number').val(0);

    /*
        CREATE ALL DATATABLES
     */
    $('#orderLogTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
        ],
        bInfo: false,
        paginate: true,
        pageLength: 5,
        order: [[ 0, "desc" ]],
        "oLanguage": {
            "sEmptyTable": "No Orders To Show."
        }
    } );


    $('#productTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
        ],
        bInfo: false,
        paginate: true,
        pageLength: 5,
        "oLanguage": {
            "sEmptyTable": "No Products To Show."
        }
    } );

    $('#customerTable').DataTable( {
        dom: 'Bfrtip',
        bInfo : false,
        buttons: [
            { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
        ],
        bInfo: false,
        paginate: true,
        pageLength: 5,
        "oLanguage": {
            "sEmptyTable": "No Customers To Show."
        }
    } );

    $('#customerPurchaseTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
        ],
        bInfo: false,
        paginate: true,
        pageLength: 5,
        "oLanguage": {
            "sEmptyTable": "No Purchases For This Customer To Show."
        }
    } );

    $('#customerOrderTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend:'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf', 'print'
        ],
        bInfo: false,
        paginate: true,
        pageLength: 5,
        order: [[ 0, "desc" ]],
        "oLanguage": {
            "sEmptyTable": "No Orders To Show."
        }
    } );

    // Add slideDown animation to Bootstrap dropdown when expanding.
    $('.dropdown').on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });

    // Add slideUp animation to Bootstrap dropdown when collapsing.
    $('.dropdown').on('hide.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });

    // GIVE SUBMIT BUTTONS A LOADING ICON
    $('body').on('submit','form',function(){
        $(this).find('.btn-success').prepend('<i class="fas fa-spinner spin fa-spin"></i> ');
        $(this).find('.btn-success').prop('disabled','disabled');
    });

    $('body').on('click','.options-dropdown',function () {
        $(this).children().children('.fa-cog').toggleClass('fa-spin');

        if($(this).hasClass('fa-spin')) {
            $(this).removeClass('fa-spin');
        }


        // if(!$(this).hasClass('show')) {
        //     $(this).children().children('.fa-cog').addClass('spin').addClass('fa-spin');
        // } else {
        //     $(this).children().children('.fa-cog').removeClass('spin').removeClass('fa-spin');
        // }
    });

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

        if($quantityField.val() == $quantityField.prop('max')) {
            $(this).prop('disabled','disabled');
            return false;
        } else {
            $(this).prop('disabled',false);
        }

        $quantityField.val(parseInt($quantityField.val()) + 1);

        if($quantityField.val() > 0) {
            minusButton.prop('disabled',false);
        } else {
            minusButton.prop('disabled','disabled');
        }

        var $item = {'id':$quantityField.data("id"), 'name':$quantityField.data("name"),
            'artifactNumber':$quantityField.data('artifact-number'), 'cataloguePage':$quantityField.data('catalogue-page'),
            'cost':$quantityField.data('cost')};

        addOrderItemToBasket($item);
    });

    $('body').on('click','.btn-number-minus',function() {
        var $quantityField = $(this).parent().next();
        var plusButton = $(this).parent().next().next().children();

        if($quantityField.val() == 0) {
            $(this).prop('disabled','disabled');
            return false;
        }

        $quantityField.val(parseInt($quantityField.val()) - 1);

        if($quantityField.val() == 0) {
            $(this).prop('disabled','disabled');
        } else {
            $(this).prop('disabled',false);
        }

        if($quantityField.val() < $quantityField.prop('max')) {
            plusButton.prop('disabled',false);
        }

        var $item = {"id":$quantityField.data("id"), "name":$quantityField.data("name"),
            "artifactNumber":$quantityField.data('artifact-number'), "cataloguePage":$quantityField.data('catalogue-page'),
            "cost":$quantityField.data('cost')};

        removeOrderItemFromBasket($item, 1);
    });

    $('body').on('click','.remove-basket-item', function () {
        if(confirm('Click OK to confirm.')) {

            var item = $(this).data('item');

            var quantity = $(this).parent().parent().children('.basket-quantity').html();

            $('.input-number').each(function () {
               if($(this).data('id') == item.id) {
                   $(this).val(parseInt($(this).val()) - parseInt(quantity));
               }
            });

            removeOrderItemFromBasket(item, quantity)
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
            $('#confirmOrderModal').modal({backdrop: 'static', keyboard: false});
            $.each(orders,function () {
                var row = '<tr class="order" data-id="'+$(this)[0].id+'" data-quantity="'+$(this)[0].quantity+'" data-cost="'+$(this)[0].cost+'"><td>'+$(this)[0].name+'</td><td>'+$(this)[0].artifactNumber+'</td><td>'+$(this)[0].quantity+'</td><td>€ '+$(this)[0].cost+'</td></tr>';
                $('#confirm-order-basket tbody').append(row);
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
        $(this).prepend('<i class="fas fa-spinner spin fa-spin"></i>');
        $(this).prop('disabled','disabled');

        var orderItems = [];
        var sendOrderUrl = $(this).data('send-order-url');
        var deductStockUrl = $(this).data('deduct-stock-url');
        var customerId;

        $('#confirm-order-basket tbody tr.order').each(function () {
            var orderItem = {};
            orderItem.productId = $(this).data('id');
            orderItem.productQuantity = $(this).data('quantity');
            orderItem.cost = $(this).data('cost');
            orderItems.push((orderItem));
        });

        var order = {};

        if($(this).data('customer-id')) {
            order = {"customerId" : $(this).data('customer-id'), "orderItems" : orderItems};
        } else {
            order = {"customerId" : null, "orderItems" : orderItems};
        }

        $.ajax({
            type: "POST",
            url: sendOrderUrl,
            data: JSON.stringify(order),
            success: function(data, textStatus, xhr){
                var invoiceNumber = xhr.getResponseHeader('Invoice-Number');
                var downloadLink = $('<a class="btn btn-success text-white" href="/invoice/'+invoiceNumber+'"><i class="fas fa-download"></i> Order Completed - Download Invoice</a>');

                $('#sendOrder').replaceWith(downloadLink);
                $('#confirmOrderModal').on('hidden.bs.modal', function () {
                    window.location.reload();
                })
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#confirmOrderModal').modal('toggle');
                if(confirm('An error has occured, click OK to report this.')) {
                    window.location.reload();
                }
            },
        });
    });

    $('#confirmOrderModal').on('hidden.bs.modal', function () {
        $('#confirm-order-basket tbody').empty();
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
        var row = "<tr class='basketItem' data-id='"+$item.id+"'><td><i data-item='"+JSON.stringify($item)+"' class='fas fa-trash-alt hoverable remove-basket-item'></i></td><td class='basket-name'>"+$item.name+"</td><td class='basket-artifact-number'>"+$item.artifactNumber+"</td><td class='basket-quantity'>1</td><td class='basket-cost'>"+$item.cost+"</td></tr>";
        $(row).data('item',JSON.stringify($item));
        $('#order-basket').append(row);
    }
    $('.basket-badge').html(parseInt($('.basket-badge').html()) + 1);
}

function removeOrderItemFromBasket(item, quantity) {
    $('#order-basket tr.basketItem').each(function () {
        if($(this).data('id') == item.id) {
            existing = true;
            var currentQuantity = $(this).find('.basket-quantity').html();
            // REMOVE FROM BASKET
            if(currentQuantity == quantity) {
                $(this).remove();
            } else {
                var newQuantity = parseInt(currentQuantity) - quantity
                $(this).find('.basket-quantity').html(newQuantity);
                var currentPrice = $(this).find('.basket-cost').html();
                var newPrice = parseFloat(currentPrice) * newQuantity;
                $(this).find('.basket-cost').html(newPrice);
            }
        }
    });
    $('.basket-badge').html(parseInt($('.basket-badge').html()) - quantity);
}

// function incrementBasketBadge() {
//     $('.basket-badge').html(parent(('.basket-badge').html()) + 1);
// }
//
// function decrementBasketBadge() {
//     $('.basket-badge').html(parent(('.basket-badge').html()) - 1);
// }
