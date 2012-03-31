/**
 * 表格样式插件
 * @author goodzsq@gmail.com
 */
(function( $ ){
    $.fn.goodzsq_table = function( options ) {

        var settings = {
            'odd': 'odd',
            'even': 'even',
            'first':'first',
            'last':'last',
            'hover':'hover',
            'table':'table'
        };

        return this.each(function() {
            if ( options ) { 
                $.extend( settings, options );
            }
            //code here
            $(this).attr('border', 1).addClass('table');
            $(this).find("tr:odd").addClass(settings.odd);
            $(this).find("tr:even").addClass(settings.even);
            $(this).find("tr:first").addClass(settings.first);
            $(this).find("tr:last").addClass(settings.last);
            $(this).find('tr').hover(
                function(){
                    $(this).addClass(settings.hover);
                },
                function(){
                   $(this).removeClass(settings.hover); 
                }
            );
            //end code
        });

    };
})( jQuery );