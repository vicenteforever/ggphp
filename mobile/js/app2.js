Ext.application({
    name: 'Sencha',

    launch: function() {
		Ext.create("dms.Detail",{id:'zsq'});
        Ext.create("Ext.Panel", {
            fullscreen: true,
            tabBarPosition: 'bottom',
layout:'fit',
            items: [
                {
                    xtype: 'list',
                    title: 'Blog',
                    iconCls: 'star',
listeners:{
	itemtap:function(){
		Ext.getCmp('zsq').setWidth(screen.width/2);
		Ext.getCmp('zsq').show();
			}
},
                    itemTpl: '{title}',
                    store: {
                        fields: ['title', 'url'],
                        data: [
                            {title: 'Ext Scheduler 2.0', url: 'ext-scheduler-2-0-upgrading-to-ext-js-4'},
                            {title: 'Previewing Sencha Touch 2', url: 'sencha-touch-2-what-to-expect'},
                            {title: 'Sencha Con 2011', url: 'senchacon-2011-now-packed-with-more-goodness'},
                            {title: 'Documentation in Ext JS 4', url: 'new-ext-js-4-documentation-center'}
                        ]
                    }
                }
            ]
        });
    }
});
