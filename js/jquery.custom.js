jQuery(document).ready(function() {
    jQuery('.carousel').jcarousel({
//         auto: 2,
        scroll: 1,
        wrap: 'circular',
        animation: 500,
        continuous: true
    });

    $('.cycle-fade').cycle({
        fx:     'fade',
        delay:  -2000
    });

    $('#search input').click(function() {
      $(this).val('');
      $(this).focus();
    });
});

$(function() {
    $('#backdrops a').lightBox();
});