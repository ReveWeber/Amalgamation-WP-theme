/*
 * customizer-controls.js
 *
 * Customizer helper functions for the control panel, not the preview.
 */

(function ($) {
    $(function () {
        for (var i = 1; i < 5; i++) {
            $('#customize-control-panel_' + i + '_post').hide();
            $('#customize-control-panel_' + i + '_page').hide();
        }
        $('#accordion-section-front_page_content').click(function () {
            for (var i = 1; i < 5; i++) {
                if ($('input:radio[name=_customize-radio-fp_panel_' + i + ']:checked').val() == 'post') {
                    $('#customize-control-panel_' + i + '_post').slideDown();
                    $('#customize-control-panel_' + i + '_page').slideUp();
                } else if ($('input:radio[name=_customize-radio-fp_panel_' + i + ']:checked').val() == 'page') {
                    $('#customize-control-panel_' + i + '_page').slideDown();
                    $('#customize-control-panel_' + i + '_post').slideUp();
                } else {
                    $('#customize-control-panel_' + i + '_page').slideUp();
                    $('#customize-control-panel_' + i + '_post').slideUp();
                }
            }
        });
    });
})(jQuery);
