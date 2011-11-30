Ext.define('dms.model.movie', {
	extend: 'Ext.data.Model',
	fields: [
		{ name: 'id', type: 'string' },
		{ name: 'aliasname', type: 'string' },
		{ name: 'subkind', type: 'string' },
		{ name: 'region', type: 'string' },
		{ name: 'language', type: 'string' },
		{ name: 'year', type: 'string' },
		{ name: 'recommend', type: 'string' },
		{ name: 'rank', type: 'string' },
		{ name: 'dir', type: 'string' },
		{ name: 'pic', type: 'string' },
	]
});

var moviestore = Ext.create('Ext.data.Store', {
	model: 'dms.model.movie',
	proxy: {
		type: 'ajax',
		url : 'ajax/movielist',
		reader: 'json'
	},
	autoLoad: true
});

Ext.define('dms.movie', {
	xtype:'mymovie',
	extend: 'Ext.Panel',
	config:{
		title:'电影',
		iconCls:'home',
		layout:'fit',

		items:[{
			xtype:'toolbar',
			title:'私人影院',
			docked:'top',
			items:[{
				handler:function(){
					var list = Ext.getCmp('movielist');
					list.getStore().load();
					list.refresh();
				},
				text:'刷新',
			},{
					xtype:'searchfield', 
					docked:'right',
					listeners:{
						change: function(){
							moviestore.clearFilter();
							var re = new RegExp(arguments[1].getValue(), "gi");
							moviestore.filter('aliasname', re);
						}
					}
			}]
		}, {
			id:'movielist',
			xtype:'list',
			title:'movie list',
			itemTpl:'<div style="float:left;width:64px;height:64px;background-image:url({pic})"></div><div style="float:left"><h1>{aliasname} {recommend}</h1><p>{year} {region} {language } {subkind} {memo}</p></div></div>',
			store:moviestore,
			listeners:{
				itemtap:function(list, idx, item, e){
					var detail = Ext.getCmp('detail')
					detail.parentList = list;
					detail.setWidth(document.width/2);
					detail.load(list.getStore(idx).getAt(idx).data.id);
					detail.show();
				}
			},
		}],

	}//config


});
