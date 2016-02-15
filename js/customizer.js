/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
    // Site title and description.
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.site-title a').text(to);
        });
    });
    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('.site-description').text(to);
        });
    });
    // Header text color.
    wp.customize('header_textcolor', function (value) {
        value.bind(function (to) {
            if ('blank' === to) {
                $('.site-title a, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });
            } else {
                $('.site-title a, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });
                $('.site-title a, .site-description').css({
                    'color': to
                });
            }
        });
    });

// todo: live update for front page panels
    //wp.customize('fp_panel_1', function (value) {
    //value.bind(function (to) {
    //$('#front-page-panel-1').text(to);
    /*
                var content_id = 'latest';
                if (to == 'post') {
                    content_id = wp.customize('panel_1_post')();
                }
                if (to == 'page') {
                    content_id = wp.customize('panel_1_page')();
                }
                $.ajax({
                    url: php_array.admin_ajax,
                    data: {
                        action: 'amalgamation_fp_ajax_load',
                        content_type: to,
                        content_id: content_id
                    },
                    success: function(html) {
                        $('#front-page-panel-1').html(html);
                    }
                });
    */
    //});
    //});
})(jQuery);
