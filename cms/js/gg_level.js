/**
 * 下拉列表联动
 * @author goodzsq@gmail.com
 */
(function( $ ){
    $.fn.gg_level = function( options ) {

        var settings = {
            'a': 'aaa'
        };
        
        return this.each(function() {
            if ( options ) { 
                $.extend( settings, options );
            }
            //code here
            var selectlist = $(this);
            var url = selectlist.attr('data');
            selectlist.empty();
            $.get(url, {}, function(data){
                window.zsq = data;
                console.log(data);
                for(i in data){
                    selectlist.append('<option value="i">'+data[i].name+'</option>'); 
                }
                
            }, 'json');
            //end code
        });

    };
})( jQuery );