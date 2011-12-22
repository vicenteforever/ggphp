Ext.application({
    name: 'AM',

    appFolder: 'js',
    controllers:[],

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
                margins: '2 0 0 5',
                width:250,
                split:true,  
                border:true,
                collapsible: true,
                title:'菜单',
                html: 'menu'
            },
            {
                region:'center',
                margins: '2 5 0 0',
                border:true,
                title:'管理中心',
                html: 'center'
            }
            ]
        });
    }
});