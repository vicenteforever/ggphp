Ext.require('Ext.container.Viewport');
Ext.require('Ext.resizer.Splitter');
Ext.require('Ext.tab.Tab');
Ext.require('Ext.layout.container.Border');
Ext.require('Ext.tab.Bar');
Ext.require('Ext.layout.container.Card');
Ext.require('Ext.tab.Panel');


Ext.application({
    name: 'AM',

    appFolder: 'js',
    controllers:['MainMenus'],

    launch: function(){
        Ext.create('Ext.container.Viewport', {
            layout: 'border',
            items:[
            {
                id:'header',
                xtype:'box',
                region:'north',
                height:30,
                html: '<h1>欢迎使用GGPHP</h1>'
            },
            {
                region:'west',
                margins: '2 0 0 0',
                width:250,
                split:true,  
                border:true,
                collapsible: true,
                xtype:'mainmenu'
            },
            {
                region:'center',
                margins: '2 0 0 0',
                border:true,
                xtype:'tabpanel',
                id:'tabpanel',
                items:[{
                    title:'管理中心', 
                    html:'welcome'
                },{
                    title:'bar1', 
                    html:'test',
                    closable:true
                },{
                    title:'bar2', 
                    html:'test',
                    closable:true
                },{
                    title:'bar3', 
                    html:'test',
                    closable:true
                },{
                    title:'bar4', 
                    html:'test',
                    closable:true
                }]
            }
            ]
        });
    }
});