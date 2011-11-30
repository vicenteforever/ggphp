Ext.define('dms.bookmark', {
	xtype:'mybookmark',
	extend: 'Ext.Panel',
	config:{
		title:'书签',
		iconCls:'home',
		layout:'fit',
		scroll:true,

		items:[{
			xtype:'toolbar',
			title:'书签列表',
			docked:'top',
			items:[{
				handler:bookmarkadd,
				text:'添加新书签',
			},]
		}],

	},

	load: function(){
		post('ajax/bookmarkload', {},function(response){
			Ext.getCmp('bookmark').setHtml(response.responseText);
		});
	}

});
