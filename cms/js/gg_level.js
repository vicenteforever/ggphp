/**
 * 将一个字段分拆成几个下拉选择框，并能够联动
 * @author goodzsq@gmail.com
 */
(function( $ ){
  
    $.fn.gg_level = function( options ) {

        var settings = {
            level:['省', '市', '区'],
            data:[{name:'aaa', child:[]}]
        };
        
        var fillData = function(object, data, defaultValue){
            object.empty();
            object.append('<option value=""></option>');
            for(i in data){
                object.append('<option value="'+i+'">'+data[i].name+'</option>');
            }
            object.val(defaultValue);
        }
        
        var getData = function(value){
            var v = value.split(':');          

            if(v[0]==''){
                return ;
            }
            var result = settings.data;            
            for(var i=0; i<v.length; i++){
                if(parseInt(v[i])==v[i] && result[v[i]] && result[v[i]].child){
                    result = result[v[i]].child;
                }
                else{
                    return [];
                }
            }
            return result;
        }
        
        return this.each(function() {
            if ( options ) { 
                $.extend( settings, options );
            }
            //code here
            var selectlist = $(this);       
            
            var name = selectlist.attr('name');

            var buf='';
            for(var i in settings.level){
                buf += '<label><select name="' + name + '_'+ i + '"></select>'+settings.level[i]+'</label>';
            }
            selectlist.after($(buf));
            
            selectlist.parent().find("select").change(function(){
                var level = $(this).attr('name').split('_').pop();
                if(parseInt(level)!=level) return;
                level = parseInt(level);

                //组合成真正的值
                var value = selectlist.parent().find("select:eq(0)").val();
                for(var i=1; i<=level; i++){
                    value += ':' + selectlist.parent().find("select:eq("+i+")").val();
                }
                selectlist.val(value);
                
                //清除后面的选择框数据
                for(var i=level+1; i<settings.level.length; i++){
                    selectlist.parent().find("select:eq("+i+")").empty();
                }
                
                //重新填充下一个下拉框数据
                level++;
                if(level<settings.level.length){
                    var object = selectlist.parent().find("select:eq("+level+")");
                    fillData(object, getData(selectlist.val()), '');
                }

                
            });

            
            var areaList = selectlist.val().split(':');
            
            var first = selectlist.parent().find("select:eq(0)");
            fillData(first, settings.data , areaList[0]);

            var area=areaList[0];
            for(var i=1; i<=areaList.length; i++){
                var object = selectlist.parent().find("select:eq("+i+")");
                fillData(object, getData(area), areaList[i]);
                area += ':' + areaList[i];

            }
        //for(var i=0; i<settings.level.length; i++){
        //    var object = selectlist.parent().find("select:eq("+i+")");
        //    object.val(1);
        //}
        
        
        //end code
        });
    
    
    };

})( jQuery );