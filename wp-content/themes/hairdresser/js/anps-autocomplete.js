'use strict';

jQuery(function($) {
    $('[data-autocomplete]').each(function() {
        var $el = $(this);
        
        var options = JSON.stringify($el.data('autocomplete'));
        options = options.replace(/anps_single_quote/g, "'");
        options = JSON.parse(options);

        $el.selectize({
            plugins: ['remove_button', 'drag_drop'],
            maxItems: null,
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            options: options,
            create: false,
            onChange: function () {
                $('.vc_edit-form-tab select, .vc_edit-form-tab input').trigger('change');
            },
        });
    });
});
