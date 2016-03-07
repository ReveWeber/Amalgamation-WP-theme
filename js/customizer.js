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

    function amalgamation_fp_ajax_call(type, panel) {
        var content_id = 'latest';
        if (type == 'post') {
            content_id = wp.customize('panel_' + panel + '_post')();
        }
        if (type == 'page') {
            content_id = wp.customize('panel_' + panel + '_page')();
        }
        $.ajax({
            url: php_array.admin_ajax,
            method: "POST",
            data: {
                action: 'amalgamation_fp_ajax_load',
                content_type: type,
                content_id: content_id
            },
            success: function (html) {
                $('#front-page-panel-' + panel).html(html);
            }
        });
    }
    wp.customize('fp_panel_1', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call(to, '1');
        });
    });
    wp.customize('fp_panel_2', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call(to, '2');
        });
    });
    wp.customize('fp_panel_3', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call(to, '3');
        });
    });
    wp.customize('fp_panel_4', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call(to, '4');
        });
    });

    wp.customize('panel_1_page', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call('page', '1');
        });
    });
    wp.customize('panel_1_post', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call('post', '1');
        });
    });
    wp.customize('panel_2_page', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call('page', '2');
        });
    });
    wp.customize('panel_2_post', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call('post', '2');
        });
    });
    wp.customize('panel_3_page', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call('page', '3');
        });
    });
    wp.customize('panel_3_post', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call('post', '3');
        });
    });
    wp.customize('panel_4_page', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call('page', '4');
        });
    });
    wp.customize('panel_4_post', function (value) {
        value.bind(function (to) {
            amalgamation_fp_ajax_call('post', '4');
        });
    });
})(jQuery);
