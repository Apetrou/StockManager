$(document).ready(function() {

    $('.dropdown').on('hidden.bs.dropdown', function(e) {
        $(this).find('.caret').toggleClass('rotate-180');
    });

    $('.dropdown').on('shown.bs.dropdown', function(e) {
        $(this).find('.caret').toggleClass('rotate-180');
    });

    //this is to avoid the menu from closing if clicked inside the menu
    $('body').on("click", ".dropdown-menu", function(e) {
        $(this).parent().is(".open") && e.stopPropagation();
    });
});