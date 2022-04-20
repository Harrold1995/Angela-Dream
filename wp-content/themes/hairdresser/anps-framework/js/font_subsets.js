"use strict";
jQuery(document).ready(function($) { 
    /* Selecting google fonts and showing subsets/variantions */    
    $('#font_type_1').on('change', function() {
        fonts_subsets("1");
    });
    $('#font_type_2').on('change', function() {
        fonts_subsets("2");
    });
    $('#font_type_navigation').on('change', function() {
        fonts_subsets("navigation");
    });
});

function fonts_subsets(index) {    
    var data = {
     'action': 'font_subsets',
        'font_value': jQuery("#font_type_"+index).val()
    };
    jQuery.post(ajax_font_object.ajax_font_url, data, function(data) {  
        if(data == 0) { 
            jQuery("#font_subsets_"+index).empty();
        } else { 
            jQuery("#font_subsets_"+index).empty(); 
            jQuery.each(jQuery.parseJSON(data), function(i, item) { 
                jQuery('#font_subsets_'+index).append("<input type='checkbox' name='font_type_"+index+"_subsets[]' value='"+item+"'>"+item+"<br />");                    
            });
        }
     }); 
}