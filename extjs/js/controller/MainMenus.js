Ext.define('AM.controller.MainMenus', {

    extend: 'Ext.app.Controller',

    models:['MainMenu'],
    views:['menu.MainMenu'],
    stores:['MainMenus'],
    
    init: function(){
        this.control({
            'mainmenu':{
                'itemclick':function(view, record, item, index, e){
                    this.opentab(record.get('text'));
                }
            }
        });
    },

    opentab: function(title){
        var tabid = 'tab_' + title;
        var tabs = Ext.getCmp('tabpanel');
        var tab = Ext.getCmp(tabid);
        if(tab){
            
        }
        else{
            tab = tabs.add({
                id:tabid,
                title:title, 
                html:title, 
                closable:true
            });
        }
        tabs.setActiveTab(tab);
    }


});